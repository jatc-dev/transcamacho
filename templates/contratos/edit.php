<?php
$title = 'Editar Contrato';
$content = '
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> Editar Contrato #' . htmlspecialchars($contrato['idcontrato'] ?? '', ENT_QUOTES, 'UTF-8') . '</h3>
            </div>
            <div class="panel-body">
                <form method="POST" action="/contratos/' . htmlspecialchars($contrato['idcontrato'] ?? '', ENT_QUOTES, 'UTF-8') . '/actualizar">
                    <input type="hidden" name="csrf_token" value="' . htmlspecialchars($csrf_token ?? '', ENT_QUOTES, 'UTF-8') . '">

                    <div class="form-group">
                        <label>Contratante <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="contratante" value="' . htmlspecialchars($contrato['contratante'] ?? '', ENT_QUOTES, 'UTF-8') . '" required>
                    </div>

                    <div class="form-group">
                        <label>NIT/CC <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nitcontratante" value="' . htmlspecialchars($contrato['nitcontratante'] ?? '', ENT_QUOTES, 'UTF-8') . '" pattern="[0-9]{7,10}" required>
                    </div>

                    <div class="form-group">
                        <label>Objeto del Contrato <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="objetocontrato" rows="3" required>' . htmlspecialchars($contrato['objetocontrato'] ?? '', ENT_QUOTES, 'UTF-8') . '</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Responsable <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="respcont" value="' . htmlspecialchars($contrato['respcont'] ?? '', ENT_QUOTES, 'UTF-8') . '" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Documento del Responsable <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="docuresp" value="' . htmlspecialchars($contrato['docuresp'] ?? '', ENT_QUOTES, 'UTF-8') . '" pattern="[0-9]{6,10}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Teléfono <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="teleresp" value="' . htmlspecialchars($contrato['teleresp'] ?? '', ENT_QUOTES, 'UTF-8') . '" pattern="[0-9]{7,10}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Dirección <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="direresp" value="' . htmlspecialchars($contrato['direresp'] ?? '', ENT_QUOTES, 'UTF-8') . '" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-right">
                        <a href="/contratos" class="btn btn-default">Cancelar</a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
';

include __DIR__ . '/layout.php';
