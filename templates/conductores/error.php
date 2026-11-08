<?php
$title = 'Error';
$content = '
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-exclamation-triangle"></i> Error</h3>
            </div>
            <div class="panel-body text-center">
                <p><i class="fa fa-exclamation-triangle fa-4x text-danger"></i></p>
                <h4>' . htmlspecialchars($message ?? 'Ocurrió un error', ENT_QUOTES, 'UTF-8') . '</h4>
                <a href="/conductores" class="btn btn-primary">Volver a Conductores</a>
            </div>
        </div>
    </div>
</div>
';

include __DIR__ . '/layout.php';
