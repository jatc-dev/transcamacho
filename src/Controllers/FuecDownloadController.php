<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Controller;
use App\Models\Fuec;

class FuecDownloadController extends Controller
{
    public function search(): void
    {
        $this->requireAuth();
        echo $this->render('fuec/search', [
            'csrf_token' => $this->csrfToken(),
        ]);
    }

    public function view(string $numfuec): void
    {
        $this->requireAuth();

        $fuecModel = new Fuec();
        $fuec = $fuecModel->findByNumFuec($numfuec);

        if ($fuec === null) {
            echo $this->render('fuec/error', ['message' => 'El FUEC solicitado no se encuentra.']);
            return;
        }

        echo $this->render('fuec/view', [
            'fuec' => $fuec,
        ]);
    }

    private function requireAuth(): void
    {
        if (empty($_SESSION['id_usuario'])) {
            $this->redirect('/login');
        }
    }
}
