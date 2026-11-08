<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Controller;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    public function list(): void
    {
        $this->requireAdmin();

        $usuarioModel = new Usuario();
        $usuarios = $usuarioModel->all(100, 0);

        echo $this->render('usuarios/list', [
            'usuarios' => $usuarios,
            'csrf_token' => $this->csrfToken(),
        ]);
    }

    public function create(): void
    {
        $this->requireAdmin();
        echo $this->render('usuarios/create', [
            'csrf_token' => $this->csrfToken(),
        ]);
    }

    public function store(): void
    {
        $this->requireAdmin();

        $csrf = (string) ($this->input('csrf_token') ?? '');
        if (!$this->validateCsrf($csrf)) {
            http_response_code(400);
            echo $this->render('usuarios/error', ['message' => 'Token CSRF inválido.']);
            return;
        }

        $nombre = trim((string) ($this->input('nombre') ?? ''));
        $usuario = trim((string) ($this->input('usuario') ?? ''));
        $password = (string) ($this->input('password') ?? '');
        $con_password = (string) ($this->input('con_password') ?? '');
        $email = trim((string) ($this->input('email') ?? ''));
        $tipo_usuario = trim((string) ($this->input('tipo_usuario') ?? 'Usuario'));

        $errors = [];
        if ($nombre === '' || $usuario === '' || $password === '' || $con_password === '' || $email === '' || $tipo_usuario === '') {
            $errors[] = 'Debe llenar todos los campos';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Dirección de correo inválida';
        }
        if ($password !== $con_password) {
            $errors[] = 'Las contraseñas no coinciden';
        }

        $usuarioModel = new Usuario();
        if ($usuarioModel->existeUsuario($usuario)) {
            $errors[] = 'El nombre de usuario ya existe';
        }
        if ($usuarioModel->existeEmail($email)) {
            $errors[] = 'El correo electrónico ya existe';
        }

        if (!empty($errors)) {
            echo $this->render('usuarios/create', [
                'csrf_token' => $this->csrfToken(),
                'errors' => $errors,
                'old' => compact('nombre', 'usuario', 'email', 'tipo_usuario'),
            ]);
            return;
        }

        $usuarioModel->create([
            'nombre' => $nombre,
            'usuario' => $usuario,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'correo' => $email,
            'activacion' => 1,
            'token' => bin2hex(random_bytes(16)),
            'tipo_usuario' => $tipo_usuario,
        ]);

        $this->redirect('/usuarios?creado=1');
    }

    public function edit(int $id): void
    {
        $this->requireAdmin();

        $usuarioModel = new Usuario();
        $usuario = $usuarioModel->find($id);

        if ($usuario === null) {
            $this->redirect('/usuarios?error=noexiste');
            return;
        }

        echo $this->render('usuarios/edit', [
            'usuario' => $usuario,
            'csrf_token' => $this->csrfToken(),
        ]);
    }

    public function update(int $id): void
    {
        $this->requireAdmin();

        $csrf = (string) ($this->input('csrf_token') ?? '');
        if (!$this->validateCsrf($csrf)) {
            http_response_code(400);
            echo $this->render('usuarios/error', ['message' => 'Token CSRF inválido.']);
            return;
        }

        $usuarioModel = new Usuario();
        $usuario = $usuarioModel->find($id);
        if ($usuario === null) {
            $this->redirect('/usuarios?error=noexiste');
            return;
        }

        $nombre = trim((string) ($this->input('nombre') ?? ''));
        $email = trim((string) ($this->input('email') ?? ''));
        $tipo_usuario = trim((string) ($this->input('tipo_usuario') ?? 'Usuario'));

        $data = [
            'nombre' => $nombre,
            'correo' => $email,
            'tipo_usuario' => $tipo_usuario,
        ];

        $password = (string) ($this->input('password') ?? '');
        if ($password !== '') {
            $con_password = (string) ($this->input('con_password') ?? '');
            if ($password !== $con_password) {
                http_response_code(400);
                echo $this->render('usuarios/error', ['message' => 'Las contraseñas no coinciden.']);
                return;
            }
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $usuarioModel->update($id, $data);
        $this->redirect('/usuarios?actualizado=1');
    }

    public function delete(int $id): void
    {
        $this->requireAdmin();

        $usuarioModel = new Usuario();
        $usuarioModel->delete($id);
        $this->redirect('/usuarios?eliminado=1');
    }

    private function requireAdmin(): void
    {
        if (empty($_SESSION['id_usuario'])) {
            $this->redirect('/login');
        }
        if ($_SESSION['tipo_usuario'] ?? '' !== 'Administrador') {
            http_response_code(403);
            echo $this->render('auth/error', ['message' => 'Acceso solo para administradores.']);
            exit;
        }
    }
}
