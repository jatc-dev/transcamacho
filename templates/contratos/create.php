<?php
$title = 'Nuevo Contrato';
$content = '
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-plus"></i> Nuevo Contrato</h3>
            </div>
            <div class="panel-body">
';

if (!empty($errors)) {
    $content .= '
                <div class="alert alert-danger">
                    <ul>
';
    foreach ($errors as $e) {
        $content .= '                        <li>' . htmlspecialchars($e, ENT_QUOTES, 'UTF-8') . '</li>
';
    }
    $content .= '
                    </ul>
                </div>
';
}

$content .= '
                <form method="POST" action="/contratos">
                    <input type="hidden" name="csrf_token" value="' . htmlspecialchars($csrf_token ?? '', ENT_QUOTES, 'UTF-8') . '">

                    <div class="form-group">
                        <label>Contratante <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="contratante" value="' . htmlspecialchars($old['contratante'] ?? '', ENT_QUOTES, 'UTF-8') . '" placeholder="Razón social o nombre" required>
                    </div>

                    <div class="form-group">
                        <label>NIT/CC <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nitcontratante" value="' . htmlspecialchars($old['nitcontratante'] ?? '', ENT_QUOTES, 'UTF-8') . '" placeholder="7 a 10 dígitos" pattern="[0-9]{7,10}" required>
                    </div>

                    <div class="form-group">
                        <label>Objeto del Contrato <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="objetocontrato" rows="3" required placeholder="Describa el objeto del contrato">' . htmlspecialchars($old['objetocontrato'] ?? '', ENT_QUOTES, 'UTF-8') . '</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Responsable <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="respcont" value="' . htmlspecialchars($old['respcont'] ?? '', ENT_QUOTES, 'UTF-8') . '" placeholder="Nombre del responsable" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Documento del Responsable <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="docuresp" value="' . htmlspecialchars($old['docuresp'] ?? '', ENT_QUOTES, 'UTF-8') . '" placeholder="6 a 10 dígitos" pattern="[0-9]{6,10}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Teléfono <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="teleresp" value="' . htmlspecialchars($old['teleresp'] ?? '', ENT_QUOTES, 'UTF-8') . '" placeholder="7 a 10 dígitos" pattern="[0-9]{7,10}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Dirección <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="direresp" value="' . htmlspecialchars($old['direresp'] ?? '', ENT_QUOTES, 'UTF-8') . '" placeholder="Dirección completa" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-right">
                        <a href="/contratos" class="btn btn-default">Cancelar</a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar Contrato</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
';

include __DIR__ . '/layout.php';
