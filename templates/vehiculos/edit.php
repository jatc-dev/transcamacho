<?php
$title = 'Editar Vehículo';
$content = '
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> Editar Vehículo</h3>
            </div>
            <div class="panel-body">
                <form method="POST" action="/vehiculos/' . htmlspecialchars($vehiculo['idvehi'] ?? '', ENT_QUOTES, 'UTF-8') . '/actualizar">
                    <input type="hidden" name="csrf_token" value="' . htmlspecialchars($csrf_token ?? '', ENT_QUOTES, 'UTF-8') . '">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Placa <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="placa" value="' . htmlspecialchars($vehiculo['placa'] ?? '', ENT_QUOTES, 'UTF-8') . '" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Modelo <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="modelo" value="' . htmlspecialchars($vehiculo['modelo'] ?? '', ENT_QUOTES, 'UTF-8') . '" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Marca <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="marca" value="' . htmlspecialchars($vehiculo['marca'] ?? '', ENT_QUOTES, 'UTF-8') . '" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Clase <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="clase" value="' . htmlspecialchars($vehiculo['clase'] ?? '', ENT_QUOTES, 'UTF-8') . '" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Número Interno <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="numinterno" value="' . htmlspecialchars($vehiculo['numinterno'] ?? '', ENT_QUOTES, 'UTF-8') . '" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Número de Tarjeta de Operación <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="numtarjeta" value="' . htmlspecialchars($vehiculo['numtarjeta'] ?? '', ENT_QUOTES, 'UTF-8') . '" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Vigencia Tarjeta <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="vencetarjeta" value="' . htmlspecialchars($vehiculo['vencetarjeta'] ?? '', ENT_QUOTES, 'UTF-8') . '" placeholder="YYYY-MM-DD" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Empresa / Convenio</label>
                                <input type="text" class="form-control" name="emprvehi" value="' . htmlspecialchars($vehiculo['emprvehi'] ?? '', ENT_QUOTES, 'UTF-8') . '">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>NIT Empresa</label>
                        <input type="text" class="form-control" name="nitempresa" value="' . htmlspecialchars($vehiculo['nitempresa'] ?? '', ENT_QUOTES, 'UTF-8') . '">
                    </div>

                    <div class="form-group text-right">
                        <a href="/vehiculos" class="btn btn-default">Cancelar</a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
';

include __DIR__ . '/layout.php';
