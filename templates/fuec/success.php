<?php
$title = 'Éxito';
$content = '
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-check-circle"></i> Operación exitosa</h3>
            </div>
            <div class="panel-body text-center">
                <p><i class="fa fa-check fa-4x text-success"></i></p>
                <h4>' . htmlspecialchars($message ?? 'Operación realizada correctamente', ENT_QUOTES, 'UTF-8') . '</h4>
                <a href="/panel" class="btn btn-primary">Volver al Panel</a>
            </div>
        </div>
    </div>
</div>
';

include __DIR__ . '/layout.php';
