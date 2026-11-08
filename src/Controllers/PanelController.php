<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Controller;

class PanelController extends Controller
{
    public function index(): void
    {
        $this->requireAuth();

        $contratoModel = new \App\Models\Contrato();
        $fuecModel = new \App\Models\Fuec();

        echo $this->render('panel/index', [
            'nombre_usuario' => $_SESSION['nombre_usuario'] ?? 'usuario',
            'tipo_usuario' => $_SESSION['tipo_usuario'] ?? '',
            'total_contratos' => $contratoModel->count(),
            'total_fuec' => $fuecModel->count(),
            'csrf_token' => $this->csrfToken(),
        ]);
    }

    private function requireAuth(): void
    {
        if (empty($_SESSION['id_usuario'])) {
            $this->redirect('/login');
        }
    }
}
