<?php
declare(strict_types=1);

function isNull($nombre, $user, $pass, $pass_con, $tipo_usuario, $email): bool
{
    return (
        strlen(trim($nombre)) < 1 ||
        strlen(trim($user)) < 1 ||
        strlen(trim($pass)) < 1 ||
        strlen(trim($pass_con)) < 1 ||
        strlen(trim($email)) < 1 ||
        strlen(trim($tipo_usuario)) < 1
    );
}

function isNullContrato($contratante, $nitcontratante, $objetocontrato, $respcont, $docuresp, $teleresp, $direresp): bool
{
    return (
        strlen(trim($contratante)) < 1 ||
        strlen(trim($nitcontratante)) < 1 ||
        strlen(trim($objetocontrato)) < 1 ||
        strlen(trim($respcont)) < 1 ||
        strlen(trim($docuresp)) < 1 ||
        strlen(trim($teleresp)) < 1 ||
        strlen(trim($direresp)) < 1
    );
}

function isNullVehiculo($placa, $modelo, $marca, $clase, $numinterno, $numtarjeta, $vencetarjeta): bool
{
    return (
        strlen(trim($placa)) < 1 ||
        strlen(trim($modelo)) < 1 ||
        strlen(trim($marca)) < 1 ||
        strlen(trim($clase)) < 1 ||
        strlen(trim($numinterno)) < 1 ||
        strlen(trim($numtarjeta)) < 1 ||
        strlen(trim($vencetarjeta)) < 1
    );
}

function isNullFuec($idcontrato, $contratante, $nitcontratante, $objetocontrato, $origen, $destino, $fechainicial, $fechafinal, $placa, $modelo, $marca, $clase, $numinterno, $numtarjeta, $nombcond1, $docucond1, $licecond1, $vigecond1, $respcont, $docuresp, $teleresp, $direresp): bool
{
    return (
        strlen(trim($idcontrato)) < 1 ||
        strlen(trim($contratante)) < 1 ||
        strlen(trim($nitcontratante)) < 1 ||
        strlen(trim($objetocontrato)) < 1 ||
        strlen(trim($origen)) < 1 ||
        strlen(trim($destino)) < 1 ||
        strlen(trim($fechainicial)) < 1 ||
        strlen(trim($fechafinal)) < 1 ||
        strlen(trim($placa)) < 1 ||
        strlen(trim($modelo)) < 1 ||
        strlen(trim($marca)) < 1 ||
        strlen(trim($clase)) < 1 ||
        strlen(trim($numinterno)) < 1 ||
        strlen(trim($numtarjeta)) < 1 ||
        strlen(trim($nombcond1)) < 1 ||
        strlen(trim($docucond1)) < 1 ||
        strlen(trim($licecond1)) < 1 ||
        strlen(trim($vigecond1)) < 1 ||
        strlen(trim($respcont)) < 1 ||
        strlen(trim($docuresp)) < 1 ||
        strlen(trim($teleresp)) < 1 ||
        strlen(trim($direresp)) < 1
    );
}

function isNullConductor($nombcond, $docucond, $licecond, $vigecond): bool
{
    return (
        strlen(trim($nombcond)) < 1 ||
        strlen(trim($docucond)) < 1 ||
        strlen(trim($licecond)) < 1 ||
        strlen(trim($vigecond)) < 1
    );
}

function isEmail(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function validaPassword(string $var1, string $var2): bool
{
    return strcmp($var1, $var2) === 0;
}

function minMax(int $min, int $max, string $valor): bool
{
    $len = strlen(trim($valor));
    return $len < $min || $len > $max;
}

function usuarioExiste(PDO $pdo, string $usuario): bool
{
    try {
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE usuario = ? LIMIT 1");
        $stmt->execute([$usuario]);
        return $stmt->fetchColumn() !== false;
    } catch (PDOException $e) {
        error_log("usuarioExiste error: " . $e->getMessage());
        return false;
    }
}

function emailExiste(PDO $pdo, string $email): bool
{
    try {
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE correo = ? LIMIT 1");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() !== false;
    } catch (PDOException $e) {
        error_log("emailExiste error: " . $e->getMessage());
        return false;
    }
}

function generateToken(): string
{
    return md5(uniqid(mt_rand(), true));
}

function hashPassword(string $password): string
{
    return password_hash($password, PASSWORD_DEFAULT);
}

function resultBlock(array $errors): void
{
    if (count($errors) > 0) {
        echo "<div id='error' class='alert alert-danger' role='alert'>
            <a href='#' onclick=\"showHide('error');\"></a>
            <ul>";
        foreach ($errors as $error) {
            echo "<li>" . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . "</li>";
        }
        echo "</ul></div>";
    }
}

function registraUsuario(PDO $pdo, string $usuario, string $pass_hash, string $nombre, string $email, int $activo, string $token, string $tipo_usuario): ?int
{
    try {
        $stmt = $pdo->prepare(
            "INSERT INTO usuarios (usuario, password, nombre, correo, activacion, token, tipo_usuario)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([$usuario, $pass_hash, $nombre, $email, $activo, $token, $tipo_usuario]);
        return (int) $pdo->lastInsertId();
    } catch (PDOException $e) {
        error_log("registraUsuario error: " . $e->getMessage());
        return null;
    }
}

function registraContrato(PDO $pdo, string $contratante, string $nitcontratante, string $objetocontrato, string $respcont, string $docuresp, string $teleresp, string $direresp): ?int
{
    try {
        $stmt = $pdo->prepare(
            "INSERT INTO contratos (contratante, nitcontratante, objetocontrato, respcont, docuresp, teleresp, direresp)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([$contratante, $nitcontratante, $objetocontrato, $respcont, $docuresp, $teleresp, $direresp]);
        return (int) $pdo->lastInsertId();
    } catch (PDOException $e) {
        error_log("registraContrato error: " . $e->getMessage());
        return null;
    }
}

function registraVehiculo(PDO $pdo, string $placa, string $modelo, string $marca, string $clase, string $numinterno, string $numtarjeta, string $vencetarjeta, string $emprvehi, string $nitempresa): ?int
{
    try {
        $stmt = $pdo->prepare(
            "INSERT INTO vehiculos (placa, modelo, marca, clase, numinterno, numtarjeta, vencetarjeta, emprvehi, nitempresa)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([$placa, $modelo, $marca, $clase, $numinterno, $numtarjeta, $vencetarjeta, $emprvehi, $nitempresa]);
        return (int) $pdo->lastInsertId();
    } catch (PDOException $e) {
        error_log("registraVehiculo error: " . $e->getMessage());
        return null;
    }
}

function registraConductor(PDO $pdo, string $nombcond, string $docucond, string $licecond, string $vigecond): ?int
{
    try {
        $stmt = $pdo->prepare(
            "INSERT INTO conductores (nombcond, docucond, licecond, vigecond) VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([$nombcond, $docucond, $licecond, $vigecond]);
        return (int) $pdo->lastInsertId();
    } catch (PDOException $e) {
        error_log("registraConductor error: " . $e->getMessage());
        return null;
    }
}

function registraFuec(
    PDO $pdo,
    string $idcontrato,
    string $contratante,
    string $nitcontratante,
    string $objetocontrato,
    string $origen,
    string $destino,
    string $emprvehi,
    string $fechainicial,
    string $fechafinal,
    string $placa,
    string $modelo,
    string $marca,
    string $clase,
    string $numinterno,
    string $numtarjeta,
    string $nombcond1,
    string $docucond1,
    string $licecond1,
    string $vigecond1,
    string $nombcond2,
    string $docucond2,
    string $licecond2,
    string $vigecond2,
    string $nombcond3,
    string $docucond3,
    string $licecond3,
    string $vigecond3,
    string $respcont,
    string $docuresp,
    string $teleresp,
    string $direresp,
    string $usercrea
): ?int {
    try {
        $stmt = $pdo->prepare(
            "INSERT INTO fuec (
                idcontrato, contratante, nitcontratante, objetocontrato, origen, destino, emprvehi,
                fechainicial, fechafinal, placa, modelo, marca, clase, numinterno, numtarjeta,
                nombcond1, docucond1, licecond1, vigecond1, nombcond2, docucond2, licecond2, vigecond2,
                nombcond3, docucond3, licecond3, vigecond3, respcont, docuresp, teleresp, direresp, usercrea
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
            )"
        );
        $stmt->execute([
            $idcontrato, $contratante, $nitcontratante, $objetocontrato, $origen, $destino, $emprvehi,
            $fechainicial, $fechafinal, $placa, $modelo, $marca, $clase, $numinterno, $numtarjeta,
            $nombcond1, $docucond1, $licecond1, $vigecond1, $nombcond2, $docucond2, $licecond2, $vigecond2,
            $nombcond3, $docucond3, $licecond3, $vigecond3, $respcont, $docuresp, $teleresp, $direresp, $usercrea
        ]);
        return (int) $pdo->lastInsertId();
    } catch (PDOException $e) {
        error_log("registraFuec error: " . $e->getMessage());
        return null;
    }
}

function validaIdToken(PDO $pdo, int $id, string $token): string
{
    try {
        $stmt = $pdo->prepare("SELECT activacion FROM usuarios WHERE id = ? AND token = ? LIMIT 1");
        $stmt->execute([$id, $token]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row === false || $row === null) {
            return 'No existe el registro para activar.';
        }

        $activacion = (int) ($row['activacion'] ?? 0);
        if ($activacion === 1) {
            return 'La cuenta ya se activó anteriormente.';
        }

        if (activarUsuario($pdo, $id)) {
            return 'Cuenta activada.';
        }
        return 'Error al Activar Cuenta';
    } catch (PDOException $e) {
        error_log("validaIdToken error: " . $e->getMessage());
        return 'Error al validar el token.';
    }
}

function activarUsuario(PDO $pdo, int $id): bool
{
    try {
        $stmt = $pdo->prepare("UPDATE usuarios SET activacion = 1 WHERE id = ?");
        return $stmt->execute([$id]);
    } catch (PDOException $e) {
        error_log("activarUsuario error: " . $e->getMessage());
        return false;
    }
}

function isNullLogin(string $usuario, string $password): bool
{
    return strlen(trim($usuario)) < 1 || strlen(trim($password)) < 1;
}

function login(PDO $pdo, string $usuario, string $password): ?array
{
    try {
        $stmt = $pdo->prepare(
            "SELECT id, tipo_usuario, password, activacion FROM usuarios WHERE usuario = ? OR correo = ? LIMIT 1"
        );
        $stmt->execute([$usuario, $usuario]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row === false || $row === null) {
            return ['error' => 'El nombre de usuario o correo electrónico no existe'];
        }

        if ((int) ($row['activacion'] ?? 0) !== 1) {
            return ['error' => 'El usuario no está activo'];
        }

        if (!password_verify($password, $row['password'])) {
            return ['error' => 'La contraseña es incorrecta'];
        }

        lastSession($pdo, (int) $row['id']);

        return [
            'id' => (int) $row['id'],
            'tipo_usuario' => $row['tipo_usuario'],
        ];
    } catch (PDOException $e) {
        error_log("login error: " . $e->getMessage());
        return ['error' => 'Error al intentar iniciar sesión. Inténtelo de nuevo más tarde.'];
    }
}

function lastSession(PDO $pdo, int $id): void
{
    try {
        $stmt = $pdo->prepare(
            "UPDATE usuarios SET last_session = NOW(), token_password = '', password_request = 0 WHERE id = ?"
        );
        $stmt->execute([$id]);
    } catch (PDOException $e) {
        error_log("lastSession error: " . $e->getMessage());
    }
}

function isActivo(PDO $pdo, string $usuario): bool
{
    try {
        $stmt = $pdo->prepare("SELECT activacion FROM usuarios WHERE usuario = ? OR correo = ? LIMIT 1");
        $stmt->execute([$usuario, $usuario]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($row !== false && $row !== null && (int) ($row['activacion'] ?? 0) === 1);
    } catch (PDOException $e) {
        error_log("isActivo error: " . $e->getMessage());
        return false;
    }
}

function generaTokenPass(PDO $pdo, int $user_id): ?string
{
    try {
        $token = generateToken();
        $stmt = $pdo->prepare(
            "UPDATE usuarios SET token_password = ?, password_request = 1 WHERE id = ?"
        );
        $stmt->execute([$token, $user_id]);
        return $token;
    } catch (PDOException $e) {
        error_log("generaTokenPass error: " . $e->getMessage());
        return null;
    }
}

function getValor(PDO $pdo, string $campo, string $campoWhere, string $valor)
{
    try {
        $stmt = $pdo->prepare("SELECT {$campo} FROM usuarios WHERE {$campoWhere} = ? LIMIT 1");
        $stmt->execute([$valor]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row !== false && $row !== null ? $row[$campo] : null;
    } catch (PDOException $e) {
        error_log("getValor error: " . $e->getMessage());
        return null;
    }
}

function getPasswordRequest(PDO $pdo, int $id): ?bool
{
    try {
        $stmt = $pdo->prepare("SELECT password_request FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row === false || $row === null) {
            return null;
        }
        return (int) ($row['password_request'] ?? 0) === 1;
    } catch (PDOException $e) {
        error_log("getPasswordRequest error: " . $e->getMessage());
        return null;
    }
}

function verificaTokenPass(PDO $pdo, int $user_id, string $token): bool
{
    try {
        $stmt = $pdo->prepare(
            "SELECT activacion FROM usuarios WHERE id = ? AND token_password = ? AND password_request = 1 LIMIT 1"
        );
        $stmt->execute([$user_id, $token]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row === false || $row === null) {
            return false;
        }
        return (int) ($row['activacion'] ?? 0) === 1;
    } catch (PDOException $e) {
        error_log("verificaTokenPass error: " . $e->getMessage());
        return false;
    }
}

function cambiaPassword(PDO $pdo, string $password, int $user_id, string $token): bool
{
    try {
        $stmt = $pdo->prepare(
            "UPDATE usuarios SET password = ?, token_password = '', password_request = 0
             WHERE id = ? AND token_password = ?"
        );
        return $stmt->execute([$password, $user_id, $token]);
    } catch (PDOException $e) {
        error_log("cambiaPassword error: " . $e->getMessage());
        return false;
    }
}
