<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Controller;
use App\Models\Fuec;

class FuecController extends Controller
{
    public function list(): void
    {
        $this->requireAuth();

        $contratante = trim((string) ($this->input('contratante') ?? ''));
        $fuecModel = new Fuec();

        $registros = [];
        if ($contratante !== '') {
            $registros = $fuecModel->listByContratante($contratante, 50);
        }

        echo $this->render('fuec/list', [
            'registros' => $registros,
            'contratante' => $contratante,
            'csrf_token' => $this->csrfToken(),
        ]);
    }

    public function create(): void
    {
        $this->requireAuth();
        echo $this->render('fuec/create', [
            'csrf_token' => $this->csrfToken(),
        ]);
    }

    public function store(): void
    {
        $this->requireAuth();

        $csrf = (string) ($this->input('csrf_token') ?? '');
        if (!$this->validateCsrf($csrf)) {
            http_response_code(400);
            echo $this->render('fuec/error', ['message' => 'Token CSRF inválido.']);
            return;
        }

        echo $this->render('fuec/success', ['message' => 'FUEC generado correctamente (en migración).']);
    }

    private function requireAuth(): void
    {
        if (empty($_SESSION['id_usuario'])) {
            $this->redirect('/login');
        }
    }
}
