<?php
$title = 'Nuevo Conductor';
$content = '
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-plus"></i> Nuevo Conductor</h3>
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
                <form method="POST" action="/conductores">
                    <input type="hidden" name="csrf_token" value="' . htmlspecialchars($csrf_token ?? '', ENT_QUOTES, 'UTF-8') . '">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombres y Apellidos <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nombcond" value="' . htmlspecialchars($old['nombcond'] ?? '', ENT_QUOTES, 'UTF-8') . '" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cédula <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="docucond" value="' . htmlspecialchars($old['docucond'] ?? '', ENT_QUOTES, 'UTF-8') . '" placeholder="6 a 15 dígitos" pattern="[0-9]{6,15}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Licencia <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="licecond" value="' . htmlspecialchars($old['licecond'] ?? '', ENT_QUOTES, 'UTF-8') . '" placeholder="6 a 15 dígitos" pattern="[0-9]{6,15}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Vigencia Licencia <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="vigecond" value="' . htmlspecialchars($old['vigecond'] ?? '', ENT_QUOTES, 'UTF-8') . '" placeholder="YYYY-MM-DD" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-right">
                        <a href="/conductores" class="btn btn-default">Cancelar</a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar Conductor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
';

include __DIR__ . '/layout.php';
