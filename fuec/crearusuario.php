<?php
declare(strict_types=1);

require 'conexion.php';
require 'funciones.php';
include 'header.php';

$errors = [];
$nombre = '';
$usuario = '';
$email = '';
$tipo_usuario = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = isset($_POST['nombre']) ? trim((string) $_POST['nombre']) : '';
    $usuario = isset($_POST['usuario']) ? trim((string) $_POST['usuario']) : '';
    $password = isset($_POST['password']) ? (string) $_POST['password'] : '';
    $con_password = isset($_POST['con_password']) ? (string) $_POST['con_password'] : '';
    $email = isset($_POST['email']) ? trim((string) $_POST['email']) : '';
    $captcha = isset($_POST['g-recaptcha-response']) ? trim((string) $_POST['g-recaptcha-response']) : '';
    $activo = 1;
    $tipo_usuario = isset($_POST['tipo_usuario']) ? trim((string) $_POST['tipo_usuario']) : '';

    // Validaciones de entrada
    if (!$captcha) {
        $errors[] = 'Por favor verifica el captcha';
    }

    if (isNull($nombre, $usuario, $password, $con_password, $email, $tipo_usuario)) {
        $errors[] = 'Debe llenar todos los campos';
    }

    if (!isEmail($email)) {
        $errors[] = 'Dirección de correo inválida';
    }

    if (!validaPassword($password, $con_password)) {
        $errors[] = 'Las contraseñas no coinciden';
    }

    if (usuarioExiste($pdo, $usuario)) {
        $errors[] = 'El nombre de usuario ya existe';
    }

    if (emailExiste($pdo, $email)) {
        $errors[] = 'El correo electrónico ya existe';
    }

    if (count($errors) === 0) {
        // Verificar reCAPTCHA con Google
        $secret = getenv('RECAPTCHA_SECRET') ?: '6Lej9dQZAAAAAIfPMZv54gqaD4-88BIDJb75c-H3';
        $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secret) . '&response=' . urlencode($captcha);

        try {
            $response = @file_get_contents($verifyUrl);
            if ($response === false) {
                throw new Exception('No se pudo verificar el captcha');
            }
            $arr = json_decode($response, true);

            if ($arr['success'] ?? false) {
                $pass_hash = hashPassword($password);
                $token = generateToken();

                $registro = registraUsuario(
                    $pdo,
                    $usuario,
                    $pass_hash,
                    $nombre,
                    $email,
                    $activo,
                    $token,
                    $tipo_usuario
                );

                if ($registro !== null && $registro > 0) {
                    header('Location: confirma.php');
                    exit;
                } else {
                    $errors[] = 'Error al registrar el usuario';
                }
            } else {
                $errors[] = 'Error al comprobar el captcha';
            }
        } catch (Exception $e) {
            error_log("crearusuario captcha error: " . $e->getMessage());
            $errors[] = 'Error al procesar el registro. Inténtelo de nuevo más tarde.';
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Crear usuario</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
<div class="container" style="margin-top:60px">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title">Crear usuario</div>
        </div>
        <div class="panel-body">
            <form id="signupform" class="form-horizontal" role="form"
                  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                  method="POST" autocomplete="off">
                <div class="form-group">
                    <label for="nombre" class="col-md-3 control-label">Nombre:</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="nombre" placeholder="Nombre"
                               value="<?php echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="usuario" class="col-md-3 control-label">Usuario</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="usuario" placeholder="Usuario"
                               value="<?php echo htmlspecialchars($usuario, ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-md-3 control-label">Contraseña</label>
                    <div class="col-md-9">
                        <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="con_password" class="col-md-3 control-label">Confirmar Contraseña</label>
                    <div class="col-md-9">
                        <input type="password" class="form-control" name="con_password"
                               placeholder="Confirmar Contraseña" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-md-3 control-label">Email</label>
                    <div class="col-md-9">
                        <input type="email" class="form-control" name="email" placeholder="Email"
                               value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tipo_usuario" class="col-md-3 control-label">Privilegios</label>
                    <div class="col-md-9">
                        <select class="form-control" name="tipo_usuario" required>
                            <option value="" disabled selected>Selecciona</option>
                            <option value="Usuario" <?php echo $tipo_usuario === 'Usuario' ? 'selected' : ''; ?>>Usuario</option>
                            <option value="Administrador" <?php echo $tipo_usuario === 'Administrador' ? 'selected' : ''; ?>>Administrador</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="captcha" class="col-md-3 control-label">Captcha</label>
                    <div class="g-recaptcha col-md-6"
                         data-sitekey="6Lej9dQZAAAAANGjFj_WtU5K57qxvFKVP3lOcbG6"></div>
                </div>
                <div class="form-group" align="center">
                    <div>
                        <button id="btn-signup" type="submit" class="btn btn-success">Crear usuario</button>
                    </div>
                </div>
            </form>
            <?php resultBlock($errors); ?>
        </div>
    </div>
</div>
</body>
</html>
