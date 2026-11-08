<?php
$title = 'Contratos';
$content = '
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading clearfix">
                <h3 class="panel-title pull-left"><i class="fa fa-file-text"></i> Contratos</h3>
                <div class="pull-right">
                    <a href="/contratos/crear" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Nuevo Contrato</a>
                </div>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID Contrato</th>
                                <th>Contratante</th>
                                <th>NIT/CC</th>
                                <th>Objeto</th>
                                <th>Responsable</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
';

if (empty($contratos)) {
    $content .= '
                            <tr>
                                <td colspan="6" class="text-center">No hay contratos registrados.</td>
                            </tr>
';
} else {
    foreach ($contratos as $c) {
        $content .= '
                            <tr>
                                <td>' . htmlspecialchars($c['idcontrato'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
                                <td>' . htmlspecialchars($c['contratante'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
                                <td>' . htmlspecialchars($c['nitcontratante'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
                                <td>' . htmlspecialchars(mb_strimwidth($c['objetocontrato'] ?? '', 0, 50, '...'), ENT_QUOTES, 'UTF-8') . '</td>
                                <td>' . htmlspecialchars($c['respcont'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
                                <td>
                                    <a href="/contratos/' . htmlspecialchars($c['idcontrato'] ?? '', ENT_QUOTES, 'UTF-8') . '/editar" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i></a>
                                    <a href="/contratos/' . htmlspecialchars($c['idcontrato'] ?? '', ENT_QUOTES, 'UTF-8') . '/eliminar" class="btn btn-xs btn-danger" onclick="return confirm(\'¿Está seguro de eliminar este contrato?\')"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
';
    }
}

$content .= '
                        </tbody>
                    </table>
                </div>
                <div class="text-muted small">
                    Total de contratos: <strong>' . (int) ($total ?? 0) . '</strong>
                </div>
            </div>
        </div>
    </div>
</div>
';

include __DIR__ . '/layout.php';
