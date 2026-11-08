<?php
$title = 'FUEC';
$content = '
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading clearfix">
                <h3 class="panel-title pull-left"><i class="fa fa-file-pdf-o"></i> FUEC - Formato Único de Extracto del Contrato</h3>
                <div class="pull-right">
                    <a href="/fuec/crear" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Nuevo FUEC</a>
                </div>
            </div>
            <div class="panel-body">
                <form method="GET" action="/fuec" class="form-inline">
                    <div class="form-group">
                        <label>Contratante:</label>
                        <input type="text" class="form-control" name="contratante" value="' . htmlspecialchars($contratante ?? '', ENT_QUOTES, 'UTF-8') . '" placeholder="Buscar por contratante">
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                </form>

                <hr>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No. FUEC</th>
                                <th>Contratante</th>
                                <th>NIT</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
';

if (empty($registros)) {
    $content .= '
                            <tr>
                                <td colspan="5" class="text-center">No hay registros de FUEC.</td>
                            </tr>
';
} else {
    foreach ($registros as $r) {
        $content .= '
                            <tr>
                                <td>' . htmlspecialchars($r['numfuec'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
                                <td>' . htmlspecialchars($r['contratante'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
                                <td>' . htmlspecialchars($r['nitcontratante'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
                                <td>' . htmlspecialchars($r['fechainicial'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
                                <td>
                                    <a href="#" class="btn btn-xs btn-info"><i class="fa fa-file-pdf-o"></i> Ver PDF</a>
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
