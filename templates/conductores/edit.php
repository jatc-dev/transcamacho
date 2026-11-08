<?php
$title = 'Editar Conductor';
$content = '
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> Editar Conductor</h3>
            </div>
            <div class="panel-body">
                <form method="POST" action="/conductores/' . htmlspecialchars($conductor['idcond'] ?? '', ENT_QUOTES, 'UTF-8') . '/actualizar">
                    <input type="hidden" name="csrf_token" value="' . htmlspecialchars($csrf_token ?? '', ENT_QUOTES, 'UTF-8') . '">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombres y Apellidos <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nombcond" value="' . htmlspecialchars($conductor['nombcond'] ?? '', ENT_QUOTES, 'UTF-8') . '" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cédula <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="docucond" value="' . htmlspecialchars($conductor['docucond'] ?? '', ENT_QUOTES, 'UTF-8') . '" pattern="[0-9]{6,15}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Licencia <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="licecond" value="' . htmlspecialchars($conductor['licecond'] ?? '', ENT_QUOTES, 'UTF-8') . '" pattern="[0-9]{6,15}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Vigencia Licencia <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="vigecond" value="' . htmlspecialchars($conductor['vigecond'] ?? '', ENT_QUOTES, 'UTF-8') . '" placeholder="YYYY-MM-DD" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-right">
                        <a href="/conductores" class="btn btn-default">Cancelar</a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
';

include __DIR__ . '/layout.php';
