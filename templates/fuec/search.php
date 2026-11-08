<?php
$title = 'Buscar FUEC';
$content = '
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-file-pdf-o"></i> Buscar FUEC</h3>
            </div>
            <div class="panel-body">
                <form method="GET" action="/fuec/buscar">
                    <input type="hidden" name="csrf_token" value="' . htmlspecialchars($csrf_token ?? '', ENT_QUOTES, 'UTF-8') . '">

                    <div class="form-group">
                        <label>Número de FUEC (4 dígitos):</label>
                        <input type="text" class="form-control" name="numfuec" maxlength="4" pattern="[0-9]{4}" placeholder="Ej: 1234" required>
                    </div>

                    <div class="form-group text-right">
                        <a href="/panel" class="btn btn-default">Cancelar</a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
';

include __DIR__ . '/layout.php';
