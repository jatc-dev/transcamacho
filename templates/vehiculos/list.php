<?php
$title = 'Vehículos';
$content = '
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading clearfix">
                <h3 class="panel-title pull-left"><i class="fa fa-car"></i> Vehículos</h3>
                <div class="pull-right">
                    <a href="/vehiculos/crear" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Nuevo Vehículo</a>
                </div>
            </div>
            <div class="panel-body">
                <form method="GET" action="/vehiculos" class="form-inline" style="margin-bottom:15px">
                    <div class="form-group">
                        <label>Placa:</label>
                        <input type="text" class="form-control" name="placa" value="' . htmlspecialchars($placa ?? '', ENT_QUOTES, 'UTF-8') . '" placeholder="Buscar por placa">
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Placa</th>
                                <th>Modelo</th>
                                <th>Marca</th>
                                <th>Clase</th>
                                <th>Número Interno</th>
                                <th>Tarjeta Operación</th>
                                <th>Vigencia Tarjeta</th>
                                <th>Empresa</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
';

if (empty($registros)) {
    $content .= '
                            <tr>
                                <td colspan="9" class="text-center">No hay vehículos registrados.</td>
                            </tr>
';
} else {
    foreach ($registros as $v) {
        $content .= '
                            <tr>
                                <td>' . htmlspecialchars($v['placa'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
                                <td>' . htmlspecialchars($v['modelo'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
                                <td>' . htmlspecialchars($v['marca'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
                                <td>' . htmlspecialchars($v['clase'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
                                <td>' . htmlspecialchars($v['numinterno'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
                                <td>' . htmlspecialchars($v['numtarjeta'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
                                <td>' . htmlspecialchars($v['vencetarjeta'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
                                <td>' . htmlspecialchars($v['emprvehi'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
                                <td>
                                    <a href="/vehiculos/' . htmlspecialchars($v['idvehi'] ?? '', ENT_QUOTES, 'UTF-8') . '/editar" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i></a>
                                    <form method="POST" action="/vehiculos/' . htmlspecialchars($v['idvehi'] ?? '', ENT_QUOTES, 'UTF-8') . '/eliminar" style="display:inline" onsubmit="return confirm(\'¿Está seguro de eliminar este vehículo?\')">
                                        <input type="hidden" name="csrf_token" value="' . htmlspecialchars($csrf_token ?? '', ENT_QUOTES, 'UTF-8') . '">
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></button>
                                    </form>
                                </td>
                            </tr>
';
    }
}

$content .= '
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
';

include __DIR__ . '/layout.php';
