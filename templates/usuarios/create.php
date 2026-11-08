<?php
$title = 'Nuevo Usuario';
$content = '
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-plus"></i> Nuevo Usuario</h3>
            </div>
            <div class="panel-body">
';

if (!empty($errors)) {
    $content .= '
                <div class="alert alert-danger">
                    <ul>
';
    foreach ($errors as $e) {
        $content .= '                        <li>' . htmlspecialchars($e, ENT_QUOTES, 'UTF-8') . '</li>
';
    }
    $content .= '
                    </ul>
                </div>
';
}

$content .= '
                <form method="POST" action="/usuarios">
                    <input type="hidden" name="csrf_token" value="' . htmlspecialchars($csrf_token ?? '', ENT_QUOTES, 'UTF-8') . '">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombre <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nombre" value="' . htmlspecialchars($old['nombre'] ?? '', ENT_QUOTES, 'UTF-8') . '" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Usuario <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="usuario" value="' . htmlspecialchars($old['usuario'] ?? '', ENT_QUOTES, 'UTF-8') . '" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Contraseña <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Confirmar Contraseña <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="con_password" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" value="' . htmlspecialchars($old['email'] ?? '', ENT_QUOTES, 'UTF-8') . '" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tipo de Usuario <span class="text-danger">*</span></label>
                                <select class="form-control" name="tipo_usuario" required>
                                    <option value="Usuario" ' . (($old['tipo_usuario'] ?? '') === 'Usuario' ? 'selected' : '') . '>Usuario</option>
                                    <option value="Administrador" ' . (($old['tipo_usuario'] ?? '') === 'Administrador' ? 'selected' : '') . '>Administrador</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-right">
                        <a href="/usuarios" class="btn btn-default">Cancelar</a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
';

include __DIR__ . '/layout.php';
