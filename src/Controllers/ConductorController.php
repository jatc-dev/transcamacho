<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Controller;
use App\Models\Conductor;

class ConductorController extends Controller
{
    public function list(): void
    {
        $this->requireAuth();

        $nombre = trim((string) ($this->input('nombre') ?? ''));
        $conductorModel = new Conductor();

        $registros = [];
        if ($nombre !== '') {
            $registros = $conductorModel->findByNombre($nombre, 100);
        } else {
            $registros = $conductorModel->all(100, 0);
        }

        echo $this->render('conductores/list', [
            'registros' => $registros,
            'nombre' => $nombre,
            'csrf_token' => $this->csrfToken(),
        ]);
    }

    public function create(): void
    {
        $this->requireAuth();
        echo $this->render('conductores/create', [
            'csrf_token' => $this->csrfToken(),
        ]);
    }

    public function store(): void
    {
        $this->requireAuth();

        $csrf = (string) ($this->input('csrf_token') ?? '');
        if (!$this->validateCsrf($csrf)) {
            http_response_code(400);
            echo $this->render('conductores/error', ['message' => 'Token CSRF inválido.']);
            return;
        }

        $data = [
            'nombcond' => trim((string) ($this->input('nombcond') ?? '')),
            'docucond' => trim((string) ($this->input('docucond') ?? '')),
            'licecond' => trim((string) ($this->input('licecond') ?? '')),
            'vigecond' => trim((string) ($this->input('vigecond') ?? '')),
        ];

        $errors = [];
        if ($data['nombcond'] === '') { $errors[] = 'El nombre es obligatorio'; }
        if ($data['docucond'] === '' || !preg_match('/^[0-9]{6,15}$/', $data['docucond'])) {
            $errors[] = 'El documento debe contener entre 6 y 15 dígitos';
        }
        if ($data['licecond'] === '' || !preg_match('/^[0-9]{6,15}$/', $data['licecond'])) {
            $errors[] = 'La licencia debe contener entre 6 y 15 dígitos';
        }
        if ($data['vigecond'] === '') { $errors[] = 'La vigencia es obligatoria'; }

        if (!empty($errors)) {
            echo $this->render('conductores/create', [
                'csrf_token' => $this->csrfToken(),
                'errors' => $errors,
                'old' => $data,
            ]);
            return;
        }

        $conductorModel = new Conductor();
        $conductorModel->create($data);
        $this->redirect('/conductores?creado=1');
    }

    public function edit(int $id): void
    {
        $this->requireAuth();

        $conductorModel = new Conductor();
        $conductor = $conductorModel->find($id);

        if ($conductor === null) {
            $this->redirect('/conductores?error=noexiste');
            return;
        }

        echo $this->render('conductores/edit', [
            'conductor' => $conductor,
            'csrf_token' => $this->csrfToken(),
        ]);
    }

    public function update(int $id): void
    {
        $this->requireAuth();

        $csrf = (string) ($this->input('csrf_token') ?? '');
        if (!$this->validateCsrf($csrf)) {
            http_response_code(400);
            echo $this->render('conductores/error', ['message' => 'Token CSRF inválido.']);
            return;
        }

        $conductorModel = new Conductor();
        $conductor = $conductorModel->find($id);
        if ($conductor === null) {
            $this->redirect('/conductores?error=noexiste');
            return;
        }

        $data = [
            'nombcond' => trim((string) ($this->input('nombcond') ?? '')),
            'docucond' => trim((string) ($this->input('docucond') ?? '')),
            'licecond' => trim((string) ($this->input('licecond') ?? '')),
            'vigecond' => trim((string) ($this->input('vigecond') ?? '')),
        ];

        $conductorModel->update($id, $data);
        $this->redirect('/conductores?actualizado=1');
    }

    public function delete(int $id): void
    {
        $this->requireAuth();

        $conductorModel = new Conductor();
        $conductorModel->delete($id);
        $this->redirect('/conductores?eliminado=1');
    }

    public function search(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        $term = trim((string) ($_GET['term'] ?? ''));
        if ($term === '') {
            echo json_encode([]);
            exit;
        }

        $conductorModel = new Conductor();
        $resultados = $conductorModel->findByNombre($term, 10);
        echo json_encode($resultados);
        exit;
    }

    private function requireAuth(): void
    {
        if (empty($_SESSION['id_usuario'])) {
            $this->redirect('/login');
        }
    }
}
