<?php
$title = 'Ver FUEC #' . htmlspecialchars($fuec['numfuec'] ?? '', ENT_QUOTES, 'UTF-8');
$content = '
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-file-pdf-o"></i> FUEC #' . htmlspecialchars($fuec['numfuec'] ?? '', ENT_QUOTES, 'UTF-8') . '</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Contratante:</strong> ' . htmlspecialchars($fuec['contratante'] ?? '', ENT_QUOTES, 'UTF-8') . '</p>
                        <p><strong>NIT/CC:</strong> ' . htmlspecialchars($fuec['nitcontratante'] ?? '', ENT_QUOTES, 'UTF-8') . '</p>
                        <p><strong>Contrato No:</strong> ' . htmlspecialchars($fuec['idcontrato'] ?? '', ENT_QUOTES, 'UTF-8') . '</p>
                        <p><strong>Objeto:</strong> ' . htmlspecialchars($fuec['objetocontrato'] ?? '', ENT_QUOTES, 'UTF-8') . '</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Origen:</strong> ' . htmlspecialchars($fuec['origen'] ?? '', ENT_QUOTES, 'UTF-8') . '</p>
                        <p><strong>Destino:</strong> ' . htmlspecialchars($fuec['destino'] ?? '', ENT_QUOTES, 'UTF-8') . '</p>
                        <p><strong>Fecha Inicial:</strong> ' . htmlspecialchars($fuec['fechainicial'] ?? '', ENT_QUOTES, 'UTF-8') . '</p>
                        <p><strong>Fecha Final:</strong> ' . htmlspecialchars($fuec['fechafinal'] ?? '', ENT_QUOTES, 'UTF-8') . '</p>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Placa:</strong> ' . htmlspecialchars($fuec['placa'] ?? '', ENT_QUOTES, 'UTF-8') . '</p>
                        <p><strong>Modelo:</strong> ' . htmlspecialchars($fuec['modelo'] ?? '', ENT_QUOTES, 'UTF-8') . '</p>
                        <p><strong>Marca:</strong> ' . htmlspecialchars($fuec['marca'] ?? '', ENT_QUOTES, 'UTF-8') . '</p>
                        <p><strong>Clase:</strong> ' . htmlspecialchars($fuec['clase'] ?? '', ENT_QUOTES, 'UTF-8') . '</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Número Interno:</strong> ' . htmlspecialchars($fuec['numinterno'] ?? '', ENT_QUOTES, 'UTF-8') . '</p>
                        <p><strong>Tarjeta de Operación:</strong> ' . htmlspecialchars($fuec['numtarjeta'] ?? '', ENT_QUOTES, 'UTF-8') . '</p>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-4">
                        <h5>Conductor 1</h5>
                        <p>' . htmlspecialchars($fuec['nombcond1'] ?? '', ENT_QUOTES, 'UTF-8') . '<br>
                        Cédula: ' . htmlspecialchars($fuec['docucond1'] ?? '', ENT_QUOTES, 'UTF-8') . '<br>
                        Licencia: ' . htmlspecialchars($fuec['licecond1'] ?? '', ENT_QUOTES, 'UTF-8') . '<br>
                        Vigencia: ' . htmlspecialchars($fuec['vigecond1'] ?? '', ENT_QUOTES, 'UTF-8') . '</p>
                    </div>
                    <div class="col-md-4">
                        <h5>Conductor 2</h5>
                        <p>' . htmlspecialchars($fuec['nombcond2'] ?? '', ENT_QUOTES, 'UTF-8') . '<br>
                        Cédula: ' . htmlspecialchars($fuec['docucond2'] ?? '', ENT_QUOTES, 'UTF-8') . '<br>
                        Licencia: ' . htmlspecialchars($fuec['licecond2'] ?? '', ENT_QUOTES, 'UTF-8') . '<br>
                        Vigencia: ' . htmlspecialchars($fuec['vigecond2'] ?? '', ENT_QUOTES, 'UTF-8') . '</p>
                    </div>
                    <div class="col-md-4">
                        <h5>Conductor 3</h5>
                        <p>' . htmlspecialchars($fuec['nombcond3'] ?? '', ENT_QUOTES, 'UTF-8') . '<br>
                        Cédula: ' . htmlspecialchars($fuec['docucond3'] ?? '', ENT_QUOTES, 'UTF-8') . '<br>
                        Licencia: ' . htmlspecialchars($fuec['licecond3'] ?? '', ENT_QUOTES, 'UTF-8') . '<br>
                        Vigencia: ' . htmlspecialchars($fuec['vigecond3'] ?? '', ENT_QUOTES, 'UTF-8') . '</p>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Responsable:</strong> ' . htmlspecialchars($fuec['respcont'] ?? '', ENT_QUOTES, 'UTF-8') . '</p>
                        <p><strong>Documento:</strong> ' . htmlspecialchars($fuec['docuresp'] ?? '', ENT_QUOTES, 'UTF-8') . '</p>
                        <p><strong>Teléfono:</strong> ' . htmlspecialchars($fuec['teleresp'] ?? '', ENT_QUOTES, 'UTF-8') . '</p>
                        <p><strong>Dirección:</strong> ' . htmlspecialchars($fuec['direresp'] ?? '', ENT_QUOTES, 'UTF-8') . '</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Usuario Crea:</strong> ' . htmlspecialchars($fuec['usercrea'] ?? '', ENT_QUOTES, 'UTF-8') . '</p>
                        <p><strong>Fecha:</strong> ' . htmlspecialchars($fuec['timestamp'] ?? '', ENT_QUOTES, 'UTF-8') . '</p>
                    </div>
                </div>

                <div class="text-right mt-3">
                    <a href="/fuec/buscar" class="btn btn-default">Buscar otro</a>
                    <a href="/panel" class="btn btn-primary">Volver al Panel</a>
                </div>
            </div>
        </div>
    </div>
</div>
';

include __DIR__ . '/layout.php';
