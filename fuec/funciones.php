<?php
	

	function isNull($nombre, $user, $pass, $pass_con, $tipo_usuario, $email){
		if(strlen(trim($nombre)) < 1 || strlen(trim($user)) < 1 || strlen(trim($pass)) < 1 || strlen(trim($pass_con)) < 1 || strlen(trim($email)) < 1 || strlen(trim($tipo_usuario)) < 1)
		{
			return true;
			} else {
			return false;
		}		
	}


	function isNullContrato($contratante, $nitcontratante, $objetocontrato, $respcont, $docuresp, $teleresp, $direresp){
		if(strlen(trim($contratante)) < 1 || strlen(trim($nitcontratante)) < 1  || strlen(trim($objetocontrato)) < 1  || strlen(trim($respcont)) < 1  || strlen(trim($docuresp)) < 1  || strlen(trim($teleresp)) < 1 || strlen(trim($direresp)) < 1 )
		{
			return true;
			} else {
			return false;
		}		
	}


	function isNullVehiculo($placa, $modelo, $marca, $clase, $numinterno, $numtarjeta, $vencetarjeta){
		if(strlen(trim($placa)) < 1 || strlen(trim($modelo)) < 1  || strlen(trim($marca)) < 1  || strlen(trim($clase)) < 1 || strlen(trim($numinterno)) < 1 || strlen(trim($numtarjeta)) < 1  || strlen(trim($vencetarjeta)) < 1)
		{
			return true;
			} else {
			return false;
		}		
	}

	function isNullFuec($idcontrato, $contratante,  $nitcontratante, $objetocontrato, $origen, $destino, $fechainicial, $fechafinal, $placa, $modelo, $marca, $clase, $numinterno, $numtarjeta, $nombcond1, $docucond1, $licecond1, $vigecond1, $respcont, $docuresp, $teleresp, $direresp){
		if(strlen(trim($idcontrato)) < 1 || strlen(trim($contratante)) < 1 || strlen(trim($nitcontratante)) < 1 || strlen(trim($objetocontrato)) < 1 || strlen(trim($origen)) < 1 || strlen(trim($destino)) < 1 || strlen(trim($fechainicial)) < 1 || strlen(trim($fechafinal)) < 1 || strlen(trim($placa)) < 1 || strlen(trim($modelo)) < 1 || strlen(trim($marca)) < 1 || strlen(trim($clase)) < 1 || strlen(trim($numinterno)) < 1 || strlen(trim($numtarjeta)) < 1 || strlen(trim($nombcond1)) < 1 || strlen(trim($docucond1)) < 1 || strlen(trim($licecond1)) < 1 || strlen(trim($vigecond1)) < 1 || strlen(trim($respcont)) < 1 || strlen(trim($docuresp)) < 1 || strlen(trim($teleresp)) < 1 || strlen(trim($direresp)) < 1 )
		{
			return true;
			} else {
			return false;
		}		
	}


	function isNullConductor($nombcond, $docucond, $licecond, $vigecond){
		if(strlen(trim($nombcond)) < 1  || strlen(trim($docucond)) < 1  || strlen(trim($licecond)) < 1 || strlen(trim($vigecond)) < 1)
		{
			return true;
			} else {
			return false;
		}		
	}

	function isEmail($email)
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL)){
			return true;
			} else {
			return false;
		}
	}
	
	function validaPassword($var1, $var2)
	{
		if (strcmp($var1, $var2) !== 0){
			return false;
			} else {
			return true;
		}
	}
	
	function minMax($min, $max, $valor){
		if(strlen(trim($valor)) < $min)
		{
			return true;
		}
		else if(strlen(trim($valor)) > $max)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function usuarioExiste($usuario)
	{
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE usuario = ? LIMIT 1");
		$stmt->bind_param("s", $usuario);
		$stmt->execute();
		$stmt->store_result();
		$num = $stmt->num_rows;
		$stmt->close();
		
		if ($num > 0){
			return true;
			} else {
			return false;
		}
	}
	
	function emailExiste($email)
	{
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE correo = ? LIMIT 1");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$stmt->store_result();
		$num = $stmt->num_rows;
		$stmt->close();
		
		if ($num > 0){
			return true;
			} else {
			return false;	
		}
	}
	
	function generateToken()
	{
		$gen = md5(uniqid(mt_rand(), false));	
		return $gen;
	}
	
	function hashPassword($password) 
	{
		$hash = password_hash($password, PASSWORD_DEFAULT);
		return $hash;
	}
	
	function resultBlock($errors){
		if(count($errors) > 0)
		{
			echo "<div id='error' class='alert alert-danger' role='alert'>
			<a href='#' onclick=\"showHide('error');\"></a>
			<ul>";
			foreach($errors as $error)
			{
				echo "<li>".$error."</li>";
			}
			echo "</ul>";
			echo "</div>";
		}
	}

							
	function registraUsuario($usuario, $pass_hash, $nombre, $email, $activo, $token, $tipo_usuario){
		
		global $mysqli;
														
		$stmt = $mysqli->prepare("INSERT INTO usuarios (usuario, password, nombre, correo, activacion, token, tipo_usuario) VALUES(?,?,?,?,?,?,?)");
		$stmt->bind_param('ssssiss', $usuario, $pass_hash, $nombre, $email, $activo, $token, $tipo_usuario);
		
		if ($stmt->execute()){
			return $mysqli->insert_id;
			} else {
			return 0;	
		}		
	}

	function registraContrato($contratante, $nitcontratante, $objetocontrato, $respcont, $docuresp, $teleresp, $direresp){
		
		global $mysqli;
														
		$stmt = $mysqli->prepare("INSERT INTO contratos (contratante, nitcontratante, objetocontrato, respcont, docuresp, teleresp, direresp) VALUES(?,?,?,?,?,?,?)");
		$stmt->bind_param('ssssiis', $contratante, $nitcontratante, $objetocontrato, $respcont, $docuresp, $teleresp, $direresp);
		
		if ($stmt->execute()){
			return $mysqli->insert_id;
			} else {
			return 0;	
		}		
	}

	function registraVehiculo($placa, $modelo, $marca, $clase, $numinterno, $numtarjeta, $vencetarjeta, $emprvehi, $nitempresa){
		
		global $mysqli;
														
		$stmt = $mysqli->prepare("INSERT INTO vehiculos (placa, modelo, marca, clase, numinterno, numtarjeta, vencetarjeta, emprvehi, nitempresa) VALUES(?,?,?,?,?,?,?,?,?)");
		$stmt->bind_param('sissiisss', $placa, $modelo, $marca, $clase, $numinterno, $numtarjeta, $vencetarjeta, $emprvehi, $nitempresa);
		
		if ($stmt->execute()){
			return $mysqli->insert_id;
			} else {
			return 0;	
		}		
	}	

	function registraConductor($nombcond, $docucond, $licecond, $vigecond){
		
		global $mysqli;
														
		$stmt = $mysqli->prepare("INSERT INTO conductores (nombcond, docucond, licecond, vigecond) VALUES(?,?,?,?)");
		$stmt->bind_param('siis', $nombcond, $docucond, $licecond, $vigecond);
		
		if ($stmt->execute()){
			return $mysqli->insert_id;
			} else {
			return 0;	
		}		
	}	
	
	function registraFuec($idcontrato, $contratante, $nitcontratante, $objetocontrato, $origen, $destino, $emprvehi, $fechainicial, $fechafinal, $placa, $modelo, $marca, $clase, $numinterno, $numtarjeta, $nombcond1, $docucond1, $licecond1, $vigecond1, $nombcond2, $docucond2, $licecond2, $vigecond2, $nombcond3, $docucond3, $licecond3, $vigecond3, $respcont, $docuresp, $teleresp, $direresp, $usercrea){
		
		global $mysqli;
														
		$stmt = $mysqli->prepare("INSERT INTO fuec (idcontrato, contratante, nitcontratante, objetocontrato, origen, destino, emprvehi, fechainicial, fechafinal, placa, modelo, marca, clase, numinterno, numtarjeta, nombcond1, docucond1, licecond1, vigecond1, nombcond2, docucond2, licecond2, vigecond2, nombcond3, docucond3, licecond3, vigecond3, respcont, docuresp, teleresp, direresp, usercrea) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
		$stmt->bind_param('isisssssssisssisssssssssssssiiss', $idcontrato, $contratante, $nitcontratante, $objetocontrato, $origen, $destino, $emprvehi, $fechainicial, $fechafinal, $placa, $modelo, $marca, $clase, $numinterno, $numtarjeta, $nombcond1, $docucond1, $licecond1, $vigecond1, $nombcond2, $docucond2, $licecond2, $vigecond2, $nombcond3, $docucond3, $licecond3, $vigecond3, $respcont, $docuresp, $teleresp, $direresp, $usercrea);
		
		if ($stmt->execute()){
			return $mysqli->insert_id;
			} else {
			return 0;	
		}		
	}
	
	function validaIdToken($id, $token){
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT activacion FROM usuarios WHERE id = ? AND token = ? LIMIT 1");
		$stmt->bind_param("is", $id, $token);
		$stmt->execute();
		$stmt->store_result();
		$rows = $stmt->num_rows;
		
		if($rows > 0) {
			$stmt->bind_result($activacion);
			$stmt->fetch();
			
			if($activacion == 1){
				$msg = "La cuenta ya se activo anteriormente.";
				} else {
				if(activarUsuario($id)){
					$msg = 'Cuenta activada.';
					} else {
					$msg = 'Error al Activar Cuenta';
				}
			}
			} else {
			$msg = 'No existe el registro para activar.';
		}
		return $msg;
	}
	
	function activarUsuario($id)
	{
		global $mysqli;
		
		$stmt = $mysqli->prepare("UPDATE usuarios SET activacion=1 WHERE id = ?");
		$stmt->bind_param('s', $id);
		$result = $stmt->execute();
		$stmt->close();
		return $result;
	}
	
	function isNullLogin($usuario, $password){
		if(strlen(trim($usuario)) < 1 || strlen(trim($password)) < 1)
		{
			return true;
		}
		else
		{
			return false;
		}		
	}
	
	function login($usuario, $password)
	{
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT id, tipo_usuario, password FROM usuarios WHERE usuario = ? || correo = ? LIMIT 1");
		$stmt->bind_param("ss", $usuario, $usuario);
		$stmt->execute();
		$stmt->store_result();
		$rows = $stmt->num_rows;
		
		if($rows > 0) {
			
			if(isActivo($usuario)){
				
				$stmt->bind_result($id, $tipo_usuario, $passwd);
				$stmt->fetch();
				
				$validaPassw = password_verify($password, $passwd);
				
				if($validaPassw){
					
					lastSession($id);
					$_SESSION['id_usuario'] = $id;
					$_SESSION['tipo_usuario'] = $tipo_usuario;
					
					header("location: welcome.php");
					} else {
					
					$errors = "La contrase&ntilde;a es incorrecta";
				}
				} else {
				$errors = 'El usuario no esta activo';
			}
			} else {
			$errors = "El nombre de usuario o correo electr&oacute;nico no existe";
		}
		return $errors;
	}
	
	function lastSession($id)
	{
		global $mysqli;
		
		$stmt = $mysqli->prepare("UPDATE usuarios SET last_session=NOW(), token_password='', password_request=0 WHERE id = ?");
		$stmt->bind_param('s', $id);
		$stmt->execute();
		$stmt->close();
	}
	
	function isActivo($usuario)
	{
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT activacion FROM usuarios WHERE usuario = ? || correo = ? LIMIT 1");
		$stmt->bind_param('ss', $usuario, $usuario);
		$stmt->execute();
		$stmt->bind_result($activacion);
		$stmt->fetch();
		
		if ($activacion == 1)
		{
			return true;
		}
		else
		{
			return false;	
		}
	}	
	
	function generaTokenPass($user_id)
	{
		global $mysqli;
		
		$token = generateToken();
		
		$stmt = $mysqli->prepare("UPDATE usuarios SET token_password=?, password_request=1 WHERE id = ?");
		$stmt->bind_param('ss', $token, $user_id);
		$stmt->execute();
		$stmt->close();
		
		return $token;
	}
	
	function getValor($campo, $campoWhere, $valor)
	{
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT $campo FROM usuarios WHERE $campoWhere = ? LIMIT 1");
		$stmt->bind_param('s', $valor);
		$stmt->execute();
		$stmt->store_result();
		$num = $stmt->num_rows;
		
		if ($num > 0)
		{
			$stmt->bind_result($_campo);
			$stmt->fetch();
			return $_campo;
		}
		else
		{
			return null;	
		}
	}
	
	function getPasswordRequest($id)
	{
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT password_request FROM usuarios WHERE id = ?");
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$stmt->bind_result($_id);
		$stmt->fetch();
		
		if ($_id == 1)
		{
			return true;
		}
		else
		{
			return null;	
		}
	}
	
	function verificaTokenPass($user_id, $token){
		
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT activacion FROM usuarios WHERE id = ? AND token_password = ? AND password_request = 1 LIMIT 1");
		$stmt->bind_param('is', $user_id, $token);
		$stmt->execute();
		$stmt->store_result();
		$num = $stmt->num_rows;
		
		if ($num > 0)
		{
			$stmt->bind_result($activacion);
			$stmt->fetch();
			if($activacion == 1)
			{
				return true;
			}
			else 
			{
				return false;
			}
		}
		else
		{
			return false;	
		}
	}
	
	function cambiaPassword($password, $user_id, $token){
		
		global $mysqli;
		
		$stmt = $mysqli->prepare("UPDATE usuarios SET password = ?, token_password='', password_request=0 WHERE id = ? AND token_password = ?");
		$stmt->bind_param('sis', $password, $user_id, $token);
		
		if($stmt->execute()){
			return true;
			} else {
			return false;		
		}
	}	



?>