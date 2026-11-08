<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Controller;
use App\Models\Vehiculo;

class VehiculoController extends Controller
{
    public function list(): void
    {
        $this->requireAuth();

        $placa = trim((string) ($this->input('placa') ?? ''));
        $vehiculoModel = new Vehiculo();

        $registros = [];
        if ($placa !== '') {
            $registros = $vehiculoModel->findByPlaca($placa, 100);
        } else {
            $registros = $vehiculoModel->all(100, 0);
        }

        echo $this->render('vehiculos/list', [
            'registros' => $registros,
            'placa' => $placa,
            'csrf_token' => $this->csrfToken(),
        ]);
    }

    public function create(): void
    {
        $this->requireAuth();
        echo $this->render('vehiculos/create', [
            'csrf_token' => $this->csrfToken(),
        ]);
    }

    public function store(): void
    {
        $this->requireAuth();

        $csrf = (string) ($this->input('csrf_token') ?? '');
        if (!$this->validateCsrf($csrf)) {
            http_response_code(400);
            echo $this->render('vehiculos/error', ['message' => 'Token CSRF inválido.']);
            return;
        }

        $data = [
            'placa' => trim((string) ($this->input('placa') ?? '')),
            'modelo' => trim((string) ($this->input('modelo') ?? '')),
            'marca' => trim((string) ($this->input('marca') ?? '')),
            'clase' => trim((string) ($this->input('clase') ?? '')),
            'numinterno' => trim((string) ($this->input('numinterno') ?? '')),
            'numtarjeta' => trim((string) ($this->input('numtarjeta') ?? '')),
            'vencetarjeta' => trim((string) ($this->input('vencetarjeta') ?? '')),
            'emprvehi' => trim((string) ($this->input('emprvehi') ?? '')),
            'nitempresa' => trim((string) ($this->input('nitempresa') ?? '')),
        ];

        $errors = [];
        if ($data['placa'] === '') { $errors[] = 'La placa es obligatoria'; }
        if ($data['modelo'] === '') { $errors[] = 'El modelo es obligatorio'; }
        if ($data['marca'] === '') { $errors[] = 'La marca es obligatoria'; }
        if ($data['clase'] === '') { $errors[] = 'La clase es obligatoria'; }
        if ($data['numinterno'] === '') { $errors[] = 'El número interno es obligatorio'; }
        if ($data['numtarjeta'] === '') { $errors[] = 'El número de tarjeta es obligatorio'; }
        if ($data['vencetarjeta'] === '') { $errors[] = 'La vigencia de tarjeta es obligatoria'; }

        if (!empty($errors)) {
            echo $this->render('vehiculos/create', [
                'csrf_token' => $this->csrfToken(),
                'errors' => $errors,
                'old' => $data,
            ]);
            return;
        }

        $vehiculoModel = new Vehiculo();
        $vehiculoModel->create($data);
        $this->redirect('/vehiculos?creado=1');
    }

    public function edit(int $id): void
    {
        $this->requireAuth();

        $vehiculoModel = new Vehiculo();
        $vehiculo = $vehiculoModel->find($id);

        if ($vehiculo === null) {
            $this->redirect('/vehiculos?error=noexiste');
            return;
        }

        echo $this->render('vehiculos/edit', [
            'vehiculo' => $vehiculo,
            'csrf_token' => $this->csrfToken(),
        ]);
    }

    public function update(int $id): void
    {
        $this->requireAuth();

        $csrf = (string) ($this->input('csrf_token') ?? '');
        if (!$this->validateCsrf($csrf)) {
            http_response_code(400);
            echo $this->render('vehiculos/error', ['message' => 'Token CSRF inválido.']);
            return;
        }

        $vehiculoModel = new Vehiculo();
        $vehiculo = $vehiculoModel->find($id);
        if ($vehiculo === null) {
            $this->redirect('/vehiculos?error=noexiste');
            return;
        }

        $data = [
            'placa' => trim((string) ($this->input('placa') ?? '')),
            'modelo' => trim((string) ($this->input('modelo') ?? '')),
            'marca' => trim((string) ($this->input('marca') ?? '')),
            'clase' => trim((string) ($this->input('clase') ?? '')),
            'numinterno' => trim((string) ($this->input('numinterno') ?? '')),
            'numtarjeta' => trim((string) ($this->input('numtarjeta') ?? '')),
            'vencetarjeta' => trim((string) ($this->input('vencetarjeta') ?? '')),
            'emprvehi' => trim((string) ($this->input('emprvehi') ?? '')),
            'nitempresa' => trim((string) ($this->input('nitempresa') ?? '')),
        ];

        $vehiculoModel->update($id, $data);
        $this->redirect('/vehiculos?actualizado=1');
    }

    public function delete(int $id): void
    {
        $this->requireAuth();

        $vehiculoModel = new Vehiculo();
        $vehiculoModel->delete($id);
        $this->redirect('/vehiculos?eliminado=1');
    }

    public function search(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        $term = trim((string) ($_GET['term'] ?? ''));
        if ($term === '') {
            echo json_encode([]);
            exit;
        }

        $vehiculoModel = new Vehiculo();
        $resultados = $vehiculoModel->findByPlaca($term, 10);
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
