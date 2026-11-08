<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Controller;
use App\Models\Usuario;

class AuthController extends Controller
{
    public function login(): void
    {
        if (!empty($_SESSION['id_usuario'])) {
            $this->redirect('/panel');
        }
        echo $this->render('auth/login', ['csrf_token' => $this->csrfToken()]);
    }

    public function authenticate(): void
    {
        $usuario = trim((string) ($this->input('usuario') ?? ''));
        $password = (string) ($this->input('password') ?? '');

        $csrf = (string) ($this->input('csrf_token') ?? '');
        if (!$this->validateCsrf($csrf)) {
            http_response_code(400);
            echo $this->render('auth/error', ['message' => 'Token CSRF inválido.']);
            return;
        }

        if ($usuario === '' || $password === '') {
            echo $this->render('auth/login', [
                'csrf_token' => $this->csrfToken(),
                'error' => 'Debe llenar todos los campos',
            ]);
            return;
        }

        $usuarioModel = new Usuario();
        $user = $usuarioModel->findByUsuarioOrEmail($usuario);

        if ($user === null) {
            echo $this->render('auth/login', [
                'csrf_token' => $this->csrfToken(),
                'error' => 'El nombre de usuario o correo electrónico no existe',
                'usuario' => $usuario,
            ]);
            return;
        }

        if ((int) ($user['activacion'] ?? 0) !== 1) {
            echo $this->render('auth/login', [
                'csrf_token' => $this->csrfToken(),
                'error' => 'El usuario no está activo',
                'usuario' => $usuario,
            ]);
            return;
        }

        if (!password_verify($password, $user['password'])) {
            echo $this->render('auth/login', [
                'csrf_token' => $this->csrfToken(),
                'error' => 'La contraseña es incorrecta',
                'usuario' => $usuario,
            ]);
            return;
        }

        $usuarioModel->actualizarUltimaSesion((int) $user['id']);

        $_SESSION['id_usuario'] = (int) $user['id'];
        $_SESSION['nombre_usuario'] = $user['nombre'];
        $_SESSION['tipo_usuario'] = $user['tipo_usuario'];
        $_SESSION['tiempo'] = time();

        $this->redirect('/panel');
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();
        $this->redirect('/login');
    }
}
