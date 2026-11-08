<?php
$title = 'Conductores';
$content = '
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading clearfix">
                <h3 class="panel-title pull-left"><i class="fa fa-user-tie"></i> Conductores</h3>
                <div class="pull-right">
                    <a href="/conductores/crear" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Nuevo Conductor</a>
                </div>
            </div>
            <div class="panel-body">
                <form method="GET" action="/conductores" class="form-inline" style="margin-bottom:15px">
                    <div class="form-group">
                        <label>Nombre:</label>
                        <input type="text" class="form-control" name="nombre" value="' . htmlspecialchars($nombre ?? '', ENT_QUOTES, 'UTF-8') . '" placeholder="Buscar por nombre">
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Cédula</th>
                                <th>Licencia</th>
                                <th>Vigencia Licencia</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
';

if (empty($registros)) {
    $content .= '
                            <tr>
                                <td colspan="5" class="text-center">No hay conductores registrados.</td>
                            </tr>
';
} else {
    foreach ($registros as $c) {
        $content .= '
                            <tr>
                                <td>' . htmlspecialchars($c['nombcond'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
                                <td>' . htmlspecialchars($c['docucond'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
                                <td>' . htmlspecialchars($c['licecond'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
                                <td>' . htmlspecialchars($c['vigecond'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
                                <td>
                                    <a href="/conductores/' . htmlspecialchars($c['idcond'] ?? '', ENT_QUOTES, 'UTF-8') . '/editar" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i></a>
                                    <form method="POST" action="/conductores/' . htmlspecialchars($c['idcond'] ?? '', ENT_QUOTES, 'UTF-8') . '/eliminar" style="display:inline" onsubmit="return confirm(\'¿Está seguro de eliminar este conductor?\')">
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
