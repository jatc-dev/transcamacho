<?php
    include 'header.php';
?>
<html>
<head>
  <title></title>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" rel="stylesheet"/>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.2/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/locale/es.js"></script>  

  <script src="https://kit.fontawesome.com/7a00a4bd48.js" crossorigin="anonymous"></script>

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
  <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>

</head>
  
<body>
<div class="container" style="margin-top:60px">
        
        <div class="panel panel-primary">
          <div class="panel-heading">
            <div class="panel-title">Descargar FUEC</div>
          </div>  
          
          <div class="panel-body" >
            
            <form id="signupform" class="form-horizontal" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
              
              <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">FUEC No:</label>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                  <input class="form-control" name="numfuec" id="numfuec" type="text" pattern="[0-9]{4}" oninvalid="setCustomValidity('Este campo solo acepta números de 4 dígitos')" onchange="try{setCustomValidity('')}catch(e){}" placeholder="4 últimos dígitos" required>
                </div>                
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                 <input type="submit" value="Buscar" class="btn btn-success" name="buscafuec">
                </div>                
           </div>

            </form>
            
          </div><!-- FIN DE  <div class="panel-body" >-->
        </div><!-- FIN DE  <div class="panel panel-primary">-->
</div><!-- FIN DE  div class="container"-->

  <?php
  require 'conexion.php';
  
      if(isset($_POST['buscafuec']))
    {
        
    global $mysqli;  

        $numfuec = $_POST['numfuec'];
        $existe=0;

        if($numfuec=="")
          {echo "
        <div class='contenido'>
          <div class='alert alert-warning' style='margin:20px'>
                    Ingrese el número del FUEC (4 digitos)
          </div>
        </div>";
              }
        else
        {  
          $resultados = mysqli_query($mysqli,"SELECT * FROM fuec WHERE numfuec = '$numfuec'");
          
          while($mysqli = mysqli_fetch_array($resultados))
          { 
            $existe++; 
              echo "
<div class='container'>

  <div class='panel panel-primary' style='margin-top: 20px; '>

    <div class='panel-body canvas_div_pdf'>

 <form name='reporte' action='' method='post'>


<input type='hidden' name='numfuec' value=".$mysqli['numfuec'].">
<input type='hidden' name='idcontrato' value=".$mysqli['idcontrato'].">
<input type='hidden' name='anoexped' value=".$mysqli['anoexped'].">
<textarea name='contratante' style='display:none;'>".$mysqli['contratante']."</textarea>
<input type='hidden' name='nitcontratante' value=".$mysqli['nitcontratante'].">
<textarea name='objetocontrato' style='display:none;'>".$mysqli['objetocontrato']."</textarea>
<textarea name='origen' style='display:none;'>".$mysqli['origen']."</textarea>
<textarea name='destino' style='display:none;'>".$mysqli['destino']."</textarea>
<textarea name='emprvehi' style='display:none;'>".$mysqli['emprvehi']."</textarea>
<input type='hidden' name='fechainicial' value=".$mysqli['fechainicial'].">
<input type='hidden' name='fechafinal' value=".$mysqli['fechafinal'].">
<textarea name='placa' style='display:none;'>".$mysqli['placa']."</textarea>
<textarea name='modelo' style='display:none;'>".$mysqli['modelo']."</textarea>
<textarea name='marca' style='display:none;'>".$mysqli['marca']."</textarea>
<textarea name='clase' style='display:none;'>".$mysqli['clase']."</textarea>
<textarea name='numinterno' style='display:none;'>".$mysqli['numinterno']."</textarea>
<textarea name='numtarjeta' style='display:none;'>".$mysqli['numtarjeta']."</textarea>
<textarea name='nombcond1' style='display:none;'>".$mysqli['nombcond1']."</textarea>
<textarea name='docucond1' style='display:none;'>".$mysqli['docucond1']."</textarea>
<textarea name='licecond1' style='display:none;'>".$mysqli['licecond1']."</textarea>
<textarea name='vigecond1' style='display:none;'>".$mysqli['vigecond1']."</textarea>
<textarea name='nombcond2' style='display:none;'>".$mysqli['nombcond2']."</textarea>
<textarea name='docucond2' style='display:none;'>".$mysqli['docucond2']."</textarea>
<textarea name='licecond2' style='display:none;'>".$mysqli['licecond2']."</textarea>
<textarea name='vigecond2' style='display:none;'>".$mysqli['vigecond2']."</textarea>
<textarea name='nombcond3' style='display:none;'>".$mysqli['nombcond3']."</textarea>
<textarea name='docucond3' style='display:none;'>".$mysqli['docucond3']."</textarea>
<textarea name='licecond3' style='display:none;'>".$mysqli['licecond3']."</textarea>
<textarea name='vigecond3' style='display:none;'>".$mysqli['vigecond3']."</textarea>
<textarea name='respcont' style='display:none;'>".$mysqli['respcont']."</textarea>
<textarea name='docuresp' style='display:none;'>".$mysqli['docuresp']."</textarea>
<textarea name='teleresp' style='display:none;'>".$mysqli['teleresp']."</textarea>
<textarea name='direresp' style='display:none;'>".$mysqli['direresp']."</textarea>
<textarea name='timestamp' style='display:none;'>".$mysqli['timestamp']."</textarea>

    <table class='table table-bordered'>
    <tr>
    <td>
    
      <div align='center'>
        <div><img src='img/head.jpg' style='height: 110px'/></div>
      </div>
        <h4 align='center'>FORMATO ÚNICO DE EXTRACTO DEL CONTRATO<br>DEL SERVICIO PÚBLICO DE TRANSPORTE TERRESTRE AUTOMOTOR ESPECIAL</h4>
        <h4 align='center'>No. 208204520".$mysqli['anoexped']."".$mysqli['idcontrato']."".$mysqli['numfuec']."</h4>


                                  
        <div class='panel-body form-group'>

          <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'><label>RAZÓN SOCIAL DE LA EMPRESA DE TRANSPORTE ESPECIAL:</label></div>
          <div class='col-lg-9 col-md-9 col-sm-9 col-xs-9'>TRANS CAMACHO TOURS S.A.S.</div><br><br></div>

          <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'><label>NIT:</label></div>
          <div class='col-lg-9 col-md-9 col-sm-9 col-xs-9'>901.363.632-0<br><br></div>

          <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'><label>CONTRATO No:</label></div>
          <div class='col-lg-9 col-md-9 col-sm-9 col-xs-9'>".$mysqli['idcontrato']."<br><br></div>

          <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'><label>CONTRATANTE: </label></div>
          <div class='col-lg-9 col-md-9 col-sm-9 col-xs-9'>".$mysqli['contratante']."<br><br></div>

          <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'><label>NIT/CC:</label></div>
          <div class='col-lg-9 col-md-9 col-sm-9 col-xs-9'>".$mysqli['nitcontratante']."<br><br></div>  

          <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'><label>OBJETO CONTRATO:</label></div>
          <div class='col-lg-9 col-md-9 col-sm-9 col-xs-9'>".$mysqli['objetocontrato']."<br><br></div>

          <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'><label>ORIGEN - DESTINO</label></div>
          <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>".$mysqli['origen']."</div>
          <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'>".$mysqli['destino']."</div>
          <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>".$mysqli['origen']."<br><br></div>

          <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'><label>CONVENIO DE COLABORACÍON:</label></div>
          <div class='col-lg-9 col-md-9 col-sm-9 col-xs-9'>".$mysqli['emprvehi']."<br><br></div>                   
              
    <table class='table table-bordered'>
        <thead>
          <tr>
            <th colspan=2 class='text-center'>VIGENCIA DEL CONTRATO</th>
          </tr>
        </thead>
        <tbody class='text-center'>   
            <tr>
              <th>FECHA INICIAL</th>
              <td>".$mysqli['fechainicial']."</td>        
            </tr>
        
            <tr>
              <th>FECHA VENCIMIENTO</th>
              <td>".$mysqli['fechafinal']."</td>        
            </tr>
        </tbody>
      </table>



      <table class='table table-bordered'>
        <thead>
          <tr>
            <th colspan=4 class='text-center'>CARACTERÍSTICAS DEL VEHÍCULO</th>
            </tr>
        </thead>
        <tbody class='text-center'>   
            <tr>
              <th class='text-center'>PLACA</th>
              <th class='text-center'>MODELO</th>
              <th class='text-center'>MARCA</th>
              <th class='text-center'>CLASE</th>                  
            </tr>

            <tr>          
              <td>".$mysqli['placa']."</td>
              <td>".$mysqli['modelo']."</td>
              <td>".$mysqli['marca']."</td>
              <td>".$mysqli['clase']."</td>        
            </tr>

            <tr>
              <th colspan=2 class='text-center'>NÚMERO INTERNO</th>
              <th colspan=2 class='text-center'>NÚMERO DE TARJETA DE OPERACIÓN</th>                  
            </tr>

            <tr>          
              <td colspan=2>".$mysqli['numinterno']."</td>
              <td colspan=2>".$mysqli['numtarjeta']."</td>
            </tr>
        </tbody>
      </table>

      <table class='table table-bordered'>
        <thead>
          <tr>
            <th></th>
            <th class='text-center'>NOMBRES Y APELLIDOS</th>
            <th class='text-center'>CÉDULA</th>
            <th class='text-center'>LICENCIA</th>
            <th class='text-center'>VIGENCIA</th>
          </tr>
        </thead>
        <tbody>   
            <tr>
              <th class='text-center'>DATOS DEL CONDUCTOR 1</th>
              <td class='text-center'>".$mysqli['nombcond1']."</td>
              <td class='text-center'>".$mysqli['docucond1']."</td>
              <td class='text-center'>".$mysqli['licecond1']."</td>
              <td class='text-center'>".$mysqli['vigecond1']."</td>                           
            </tr>
            <tr>
              <th class='text-center'>DATOS DEL CONDUCTOR 2</th>
              <td class='text-center'>".$mysqli['nombcond2']."</td>
              <td class='text-center'>".$mysqli['docucond2']."</td>
              <td class='text-center'>".$mysqli['licecond2']."</td>
              <td class='text-center'>".$mysqli['vigecond2']."</td>                           
            </tr>
            <tr>
              <th class='text-center'>DATOS DEL CONDUCTOR 3</th>
              <td class='text-center'>".$mysqli['nombcond3']."</td>
              <td class='text-center'>".$mysqli['docucond3']."</td>
              <td class='text-center'>".$mysqli['licecond3']."</td>
              <td class='text-center'>".$mysqli['vigecond3']."</td>                           
            </tr>                
        </tbody>
      </table>

      <table class='table table-bordered'>
        <thead>
          <tr>
            <th></th>
            <th class='text-center'>NOMBRES Y APELLIDOS</th>
            <th class='text-center'>CÉDULA</th>
            <th class='text-center'>TELÉFONO</th>
            <th class='text-center'>DIRECCIÓN</th>
          </tr>
        </thead>
        <tbody>   
            <tr>
              <th class='text-center'>RESPONSABLE DEL CONTRATANTE</th>
              <td class='text-center'>".$mysqli['respcont']."</td>
              <td class='text-center'>".$mysqli['docuresp']."</td>
              <td class='text-center'>".$mysqli['teleresp']."</td>
              <td class='text-center'>".$mysqli['direresp']."</td>                           
            </tr>
        </tbody>
      </table>    

      <table class='table table-bordered'>     
          <tr>
            <td class='text-center'><b>TRANS CAMACHO TOURS S.A.S</b><br>
                RESOLUCIÓN MINTRANSPORTE 20203040012045<br>
                NIT 901363632-0<br>
                Teléfono: 3125780760<br>
                Carrera 79F No 51A-12 Sur BQ 1 IN 3 Apto.203<br>
                Bogotá D.C.– Colombia<br>
                transcamachotours@outlook.com<br>
                <a href='www.transcamacho.com'><b>www.transcamacho.com<b></a></td>

            <td class='text-center'><div><img src='img/qr.jpg' style='height: 180px'/></div></td>

            <td class='text-center'><div id='sign'></div><br>
            <b>Representante Legal TRANS CAMACHO TOURS S.A.S.</b><br>Firmado digitalmente - Fecha: ".$mysqli['timestamp']."<br>
            <small>Firma digital según resolución 6652 de 2019 Art. 8.<br>Ley 527 de 1999 – Decreto 1074 de 2015.</small></td>
          </tr>      
      </table>
      
      </td>
      </tr>
      </table>
      
    </div> 

        <div class='form-group panel-body' align='center'>
          <button id='pdf' type='submit' class='btn btn-danger' onclick=this.form.action='genpdfqr.php'>Descargar PDF <i class='far fa-file-pdf' style='font-size:150%'></i></button><br><br>
      </div>
   </form>

    </div><!-- FIN DE PANEL BODY  -->
  </div><!-- FIN DE panel-info -->  
</div ><!-- FIN DE container -->

          ";             
          }
        if($existe==0){
          echo "
          <div class='contenido'>
          <div class='alert alert-danger' style='margin:20px'>
                  El FUEC solicitado no se encuentra en la base de datos
                </div>
          </div>";
          }
        }
    }
  ?>
</body>
</html>