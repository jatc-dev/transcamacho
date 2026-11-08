<?php
$title = 'Iniciar sesión';
$content = '
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-sign-in"></i> Iniciar sesión</h3>
            </div>
            <div class="panel-body">
';

if (!empty($error)) {
    $content .= '
                <div class="alert alert-danger">' . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . '</div>
';
}

$content .= '
                <form method="POST" action="/login">
                    <input type="hidden" name="csrf_token" value="' . htmlspecialchars($csrf_token ?? '', ENT_QUOTES, 'UTF-8') . '">

                    <div class="form-group">
                        <label>Usuario</label>
                        <input type="text" class="form-control" name="usuario" value="' . htmlspecialchars($usuario ?? '', ENT_QUOTES, 'UTF-8') . '" placeholder="Usuario" required autofocus>
                    </div>

                    <div class="form-group">
                        <label>Contraseña</label>
                        <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
                    </div>

                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary">Ingresar <i class="fa fa-arrow-right"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
';

include __DIR__ . '/layout.php';
