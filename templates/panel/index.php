<?php
$title = 'Panel de Control';
$content = '
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-dashboard"></i> Panel de Control</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="panel panel-success text-center">
                            <div class="panel-heading">Contratos</div>
                            <div class="panel-body font-size-24">
                                ' . (int) ($total_contratos ?? 0) . '
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="panel panel-info text-center">
                            <div class="panel-heading">FUEC Generados</div>
                            <div class="panel-body font-size-24">
                                ' . (int) ($total_fuec ?? 0) . '
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="panel panel-warning text-center">
                            <div class="panel-heading">Usuario</div>
                            <div class="panel-body">
                                ' . htmlspecialchars($nombre_usuario ?? 'Usuario', ENT_QUOTES, 'UTF-8') . '
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="panel panel-info text-center">
                            <div class="panel-heading">Tipo</div>
                            <div class="panel-body">
                                ' . htmlspecialchars($tipo_usuario ?? 'Usuario', ENT_QUOTES, 'UTF-8') . '
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title"><i class="fa fa-file-text"></i> Gestión de Contratos</h4>
            </div>
            <div class="panel-body">
                <a href="/contratos" class="btn btn-primary"><i class="fa fa-list"></i> Ver Contratos</a>
                <a href="/contratos/crear" class="btn btn-success"><i class="fa fa-plus"></i> Nuevo Contrato</a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title"><i class="fa fa-file-pdf-o"></i> Gestión de FUEC</h4>
            </div>
            <div class="panel-body">
                <a href="/fuec" class="btn btn-primary"><i class="fa fa-list"></i> Ver FUEC</a>
                <a href="/fuec/crear" class="btn btn-success"><i class="fa fa-plus"></i> Nuevo FUEC</a>
            </div>
        </div>
    </div>
</div>
';

include __DIR__ . '/layout.php';
