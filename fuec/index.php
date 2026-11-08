<?php
declare(strict_types=1);

session_start();
include 'conexion.php';
include 'funciones.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = isset($_POST['usuario']) ? trim((string) $_POST['usuario']) : '';
    $password = isset($_POST['password']) ? (string) $_POST['password'] : '';

    if ($usuario === '' || $password === '') {
        $errors[] = 'Debe llenar todos los campos';
    } else {
        try {
            $stmt = $pdo->prepare(
                "SELECT id, tipo_usuario, password FROM usuarios WHERE usuario = ? OR correo = ? LIMIT 1"
            );
            $stmt->execute([$usuario, $usuario]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row === false || $row === null) {
                $errors[] = 'El nombre de usuario o correo electrónico no existe';
            } else {
                // Verificar activación (asumiendo columna 'activacion')
                $activacion = isset($row['activacion']) ? (int) $row['activacion'] : 0;
                if ($activacion !== 1) {
                    $errors[] = 'El usuario no está activo';
                } elseif (!password_verify($password, $row['password'])) {
                    $errors[] = 'La contraseña es incorrecta';
                } else {
                    $_SESSION['id_usuario'] = (int) $row['id'];
                    $_SESSION['tipo_usuario'] = $row['tipo_usuario'];
                    $_SESSION['tiempo'] = time();

                    // Actualizar última sesión
                    try {
                        $upd = $pdo->prepare(
                            "UPDATE usuarios SET last_session = NOW(), token_password = '', password_request = 0 WHERE id = ?"
                        );
                        $upd->execute([(int) $row['id']]);
                    } catch (PDOException $e) {
                        error_log("Error al actualizar última sesión: " . $e->getMessage());
                    }

                    header('Location: welcome.php');
                    exit;
                }
            }
        } catch (PDOException $e) {
            error_log("Error en login: " . $e->getMessage());
            $errors[] = 'Error al intentar iniciar sesión. Inténtelo de nuevo más tarde.';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Trans Camacho Tours</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon/favicon-16x16.png">
    <link rel="manifest" href="img/favicon/site.webmanifest">
    <link rel="mask-icon" href="img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" type="text/css" href="css/estilos.css">
</head>
<body>
<header style="justify-content: center; align-items:center; height: auto;">
    <div id="logo"><img src="img/logo.png" style="height: 100px;"></div>
    <div id="textlogo" style="margin-left: 0px;">
        <i><h3>Trans Camacho Tours S.A.S.</h3><h4>Sistema para la gestión de extractos de contrato</h4></i>
    </div>
</header>

<div class="container">
    <div id="loginbox" style="margin-top:180px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">Iniciar Sesión</div>
            </div>

            <div style="padding-top:30px" class="panel-body">
                <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

                <?php if (count($errors) > 0): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form id="loginform" class="form-horizontal" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" method="POST" autocomplete="off">
                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="usuario" type="text" class="form-control" name="usuario"
                               value="<?php echo isset($_POST['usuario']) ? htmlspecialchars($_POST['usuario'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                               placeholder="usuario" required>
                    </div>
                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="password" type="password" class="form-control" name="password"
                               placeholder="contraseña" required>
                    </div>
                    <div style="margin-top:10px" class="form-group" align="center">
                        <div class="col-sm-12 controls">
                            <button id="btn-login" type="submit" class="btn btn-primary">Ingresar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
