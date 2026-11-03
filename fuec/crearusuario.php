<?php  
    require 'funciones.php';
    include 'header.php';

  if(!empty($_POST))
  {
    $nombre = $mysqli->real_escape_string($_POST['nombre']);  
    $usuario = $mysqli->real_escape_string($_POST['usuario']);
    
    $password = $mysqli->real_escape_string($_POST['password']);  
    $con_password = $mysqli->real_escape_string($_POST['con_password']);

    $email = $mysqli->real_escape_string($_POST['email']);  
    $captcha = $mysqli->real_escape_string($_POST['g-recaptcha-response']);
    
    $activo = 1;    /*0 para activacion por correo*/
    $tipo_usuario = $mysqli->real_escape_string($_POST['tipo_usuario']);  /*1 para administradores*/

    //$secret = '6Le4mtEUAAAAAH9-cq35P_lLoNYmZoz2oYY8W4Dn'; // Secret Key Local
    $secret = '6Lej9dQZAAAAAIfPMZv54gqaD4-88BIDJb75c-H3';  //Secret Key jatc.tech
    
    if(!$captcha){
      $errors[] = "Por favor verifica el captcha";
    }
    
    if(isNull($nombre, $usuario, $password, $con_password, $email, $tipo_usuario))
    {
      $errors[] = "Debe llenar todos los campos";
    }
    
    if(!isEmail($email))
    {
      $errors[] = "Dirección de correo inválida";
    }
    
    if(!validaPassword($password, $con_password))
    {
      $errors[] = "Las contraseñas no coinciden";
    }
    
    if(usuarioExiste($usuario))
    {
      $errors[] = "El nombre de usuario $usuario ya existe";
    }
    
    if(emailExiste($email))
    {
      $errors[] = "El correo electronico $email ya existe";
    }
    
    if(count($errors) == 0)
    {
      $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha");
      
      $arr = json_decode($response, TRUE);
      
      if($arr['success'])
      {
        
        $pass_hash = hashPassword($password);
        $token = generateToken();
        
        $registro = registraUsuario($usuario, $pass_hash, $nombre, $email, $activo, $token, $tipo_usuario);
                
        if($registro > 0 )
        {
        
        $yourURL="confirma.php"; 
        echo ("<script>location.href='$yourURL'</script>"); 

        
          } else {
          $errors[] = "Error al Registrar";
        }
        
        } else {
        $errors[] = 'Error al comprobar Captcha';
      }     
    }   
  }    
?>

<!DOCTYPE html>
<html>
<head>

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

    <div class="panel-body" >
          
      <form id="signupform" class="form-horizontal" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">  
        
        <div class="form-group">
          <label for="nombre" class="col-md-3 control-label">Nombre:</label>
          <div class="col-md-9">
            <input type="text" class="form-control" name="nombre" placeholder="Nombre" value="<?php if(isset($nombre)) echo $nombre; ?>" required >
          </div>
        </div>
        
        <div class="form-group">
          <label for="usuario" class="col-md-3 control-label">Usuario</label>
          <div class="col-md-9">
            <input type="text" class="form-control" name="usuario" placeholder="Usuario" value="<?php if(isset($usuario)) echo $usuario; ?>" required>
          </div>
        </div>

                    
        <div class="form-group">
          <label for="password" class="col-md-3 control-label">Contrase&ntilde;a</label>
          <div class="col-md-9">
            <input type="password" class="form-control" name="password" placeholder="Contrase&ntilde;a" required>
          </div>
        </div>
        
        <div class="form-group">
          <label for="con_password" class="col-md-3 control-label">Confirmar Contrase&ntilde;a</label>
          <div class="col-md-9">
            <input type="password" class="form-control" name="con_password" placeholder="Confirmar Contrase&ntilde;a" required>
          </div>
        </div>
        
        <div class="form-group">
          <label for="email" class="col-md-3 control-label">Email</label>
          <div class="col-md-9">
            <input type="email" class="form-control" name="email" placeholder="Email" value="<?php if(isset($email)) echo $email; ?>" required>
          </div>
        </div>
        
        <div class="form-group">
          <label for="unidad_usuario" class="col-md-3 control-label">Privilegios</label>
          <div class="col-md-9">
            <select type="text" class="form-control" name="tipo_usuario" placeholder="Selecciona" value="<?php if(isset($tipo_usuario)) echo $tipo_usuario; ?>" required>
                        <option value="" disabled selected>Selecciona</option> 
                        <option>Usuario</option>
                        <option>Administrador</option>
                      </select>
            </div>
        </div>
        <div class="form-group">
          <label for="captcha" class="col-md-3 control-label">Captcha</label>
          <!-- site key localhost-->
          <!-- <div class="g-recaptcha col-md-6" data-sitekey="6Le4mtEUAAAAAKytJd_0vhewTqh22MO3wa4KvHZg"></div>  -->
          
          <!--site key jatc.tech -->
          <div class="g-recaptcha col-md-6" data-sitekey="6Lej9dQZAAAAANGjFj_WtU5K57qxvFKVP3lOcbG6"></div>
          
        </div>
        
        <div class="form-group" align="center">                                      
          <div>
            <button id="btn-signup" type="submit" class="btn btn-success">Crear usuario</button>
          </div>
        </div>
      </form>
      <?php echo resultBlock($errors); ?>

    </div>
 
  </div>
</div>

</body>
</html>


    
 
        

