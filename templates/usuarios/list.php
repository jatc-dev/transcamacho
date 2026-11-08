<?php
$title = 'Usuarios';
$content = '
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading clearfix">
                <h3 class="panel-title pull-left"><i class="fa fa-users"></i> Usuarios</h3>
                <div class="pull-right">
                    <a href="/usuarios/crear" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Nuevo Usuario</a>
                </div>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Tipo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
';

if (empty($usuarios)) {
    $content .= '
                            <tr>
                                <td colspan="5" class="text-center">No hay usuarios registrados.</td>
                            </tr>
';
} else {
    foreach ($usuarios as $u) {
        $content .= '
                            <tr>
                                <td>' . htmlspecialchars($u['usuario'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
                                <td>' . htmlspecialchars($u['nombre'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
                                <td>' . htmlspecialchars($u['correo'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
                                <td><span class="label label-' . (($u['tipo_usuario'] ?? '') === 'Administrador' ? 'danger' : 'info') . '">' . htmlspecialchars($u['tipo_usuario'] ?? '', ENT_QUOTES, 'UTF-8') . '</span></td>
                                <td>
                                    <a href="/usuarios/' . htmlspecialchars($u['id'] ?? '', ENT_QUOTES, 'UTF-8') . '/editar" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i></a>
                                    <form method="POST" action="/usuarios/' . htmlspecialchars($u['id'] ?? '', ENT_QUOTES, 'UTF-8') . '/eliminar" style="display:inline" onsubmit="return confirm(\'¿Está seguro de eliminar este usuario?\')">
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
