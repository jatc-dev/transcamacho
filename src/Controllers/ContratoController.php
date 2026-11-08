<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Controller;
use App\Models\Contrato;

class ContratoController extends Controller
{
    public function list(): void
    {
        $this->requireAuth();

        $contratoModel = new Contrato();
        $contratos = $contratoModel->all(50, 0);
        $total = $contratoModel->count();

        echo $this->render('contratos/list', [
            'contratos' => $contratos,
            'total' => $total,
            'csrf_token' => $this->csrfToken(),
        ]);
    }

    public function create(): void
    {
        $this->requireAuth();
        echo $this->render('contratos/create', [
            'csrf_token' => $this->csrfToken(),
        ]);
    }

    public function store(): void
    {
        $this->requireAuth();

        $csrf = (string) ($this->input('csrf_token') ?? '');
        if (!$this->validateCsrf($csrf)) {
            http_response_code(400);
            echo $this->render('contratos/error', ['message' => 'Token CSRF inválido.']);
            return;
        }

        $contratante = trim((string) ($this->input('contratante') ?? ''));
        $nitcontratante = trim((string) ($this->input('nitcontratante') ?? ''));
        $objetocontrato = trim((string) ($this->input('objetocontrato') ?? ''));
        $respcont = trim((string) ($this->input('respcont') ?? ''));
        $docuresp = trim((string) ($this->input('docuresp') ?? ''));
        $teleresp = trim((string) ($this->input('teleresp') ?? ''));
        $direresp = trim((string) ($this->input('direresp') ?? ''));

        $errors = [];
        if ($contratante === '') { $errors[] = 'El contratante es obligatorio'; }
        if ($nitcontratante === '' || !preg_match('/^[0-9]{7,10}$/', $nitcontratante)) {
            $errors[] = 'El NIT/CC debe contener entre 7 y 10 dígitos';
        }
        if ($objetocontrato === '') { $errors[] = 'El objeto del contrato es obligatorio'; }
        if ($respcont === '') { $errors[] = 'El responsable es obligatorio'; }
        if ($docuresp === '' || !preg_match('/^[0-9]{6,10}$/', $docuresp)) {
            $errors[] = 'El documento del responsable debe contener entre 6 y 10 dígitos';
        }
        if ($teleresp === '' || !preg_match('/^[0-9]{7,10}$/', $teleresp)) {
            $errors[] = 'El teléfono debe contener entre 7 y 10 dígitos';
        }
        if ($direresp === '') { $errors[] = 'La dirección es obligatoria'; }

        if (!empty($errors)) {
            echo $this->render('contratos/create', [
                'csrf_token' => $this->csrfToken(),
                'errors' => $errors,
                'old' => compact('contratante', 'nitcontratante', 'objetocontrato', 'respcont', 'docuresp', 'teleresp', 'direresp'),
            ]);
            return;
        }

        $contratoModel = new Contrato();
        $contratoModel->create(compact(
            'contratante', 'nitcontratante', 'objetocontrato', 'respcont', 'docuresp', 'teleresp', 'direresp'
        ));

        $this->redirect('/contratos?creado=1');
    }

    public function edit(int $id): void
    {
        $this->requireAuth();

        $contratoModel = new Contrato();
        $contrato = $contratoModel->find($id);

        if ($contrato === null) {
            $this->redirect('/contratos?error=noexiste');
            return;
        }

        echo $this->render('contratos/edit', [
            'contrato' => $contrato,
            'csrf_token' => $this->csrfToken(),
        ]);
    }

    public function update(int $id): void
    {
        $this->requireAuth();

        $csrf = (string) ($this->input('csrf_token') ?? '');
        if (!$this->validateCsrf($csrf)) {
            http_response_code(400);
            echo $this->render('contratos/error', ['message' => 'Token CSRF inválido.']);
            return;
        }

        $contratoModel = new Contrato();
        $contrato = $contratoModel->find($id);
        if ($contrato === null) {
            $this->redirect('/contratos?error=noexiste');
            return;
        }

        $data = [
            'contratante' => trim((string) ($this->input('contratante') ?? '')),
            'nitcontratante' => trim((string) ($this->input('nitcontratante') ?? '')),
            'objetocontrato' => trim((string) ($this->input('objetocontrato') ?? '')),
            'respcont' => trim((string) ($this->input('respcont') ?? '')),
            'docuresp' => trim((string) ($this->input('docuresp') ?? '')),
            'teleresp' => trim((string) ($this->input('teleresp') ?? '')),
            'direresp' => trim((string) ($this->input('direresp') ?? '')),
        ];

        $contratoModel->update($id, $data);
        $this->redirect('/contratos?actualizado=1');
    }

    public function delete(int $id): void
    {
        $this->requireAuth();

        $contratoModel = new Contrato();
        $contratoModel->delete($id);
        $this->redirect('/contratos?eliminado=1');
    }

    private function requireAuth(): void
    {
        if (empty($_SESSION['id_usuario'])) {
            $this->redirect('/login');
        }
    }
}
