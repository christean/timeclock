<?php
include("hora-login.php");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Login Empleado</title>

    <!-- Bootstrap -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>

    .log{
      width: 300px;
      height: auto;
      display: block;
      margin: 0 auto;
    }

    .form-control{
      font-size: 18px;
      font-weight: bold;
    }

    .note{
      font-size: 14px;
      font-style: italic;
      color: #8c1010;
    }
    </style>
  </head>
  <body>
<div class="jumbotron">
  <div class="container">
    <!-- <h1>Bienvenido a GeoFel.Net</h1> -->
    <h1>Bienvenido</h1>
  </div>
</div>


<?php

 date_default_timezone_set('America/Mexico_City');
  $fechaAct=date("Y-m-d"); //Fecha actual
  $horaAct=date("H:i:s"); //hora actual


//comprobacion de errores
$error=0;
if(isset($_GET["error"])){

    if($_GET["error"]==1){
    $error=1;
  }
}
?>

     
<div class="container">


<?php
if($error==1){
?>

 <div class="alert alert-warning alert-danger" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Error!</strong>  Verifica tu Clave de Acceso
</div>

<?php
}
 // if($horaAct>=$horaEntrada && $horaAct<=$horaSalida){
?>
    <div class="log">
      <div class="tamForm">
      <form class="contact_form" id="frmLogin" method="POST" action="val-log-emp.php">
      <fieldset>
      <legend class="textLog">LOGIN Empleado</legend>  

      <div  class= "input-group" > 
      <input  type= "password"  class= "form-control"  placeholder= "Clave"  aria-describedby= "basic-addon2" name="clave" maxlength="5" > 
      <span  class= "input-group-addon"  id= "basic-addon1" > 
      <span class="glyphicon glyphicon-user" aria-hidden="true"></span> 
      </span> 
      </div>
      <br/>
      <legend class="note">Ingrese su Clave: Ej. 22335</legend>

      <button type="submit" class="btn btn-default">Entrar</button>  

      <button type="reset" class="btn btn-default">Borrar</button>

<?php
  //2015-04-24
  //23:13:22
 /* }else{
        echo "<h2>Inicie sesion en los horarios permitidos. Gracias</h2>";
        echo "Hora Entrada: ".$horaEntrada;
        echo "   -    Hora Salida: ".$horaSalida;
  }*/
?>
      </fieldset>
      </form>
      </div>
    </div>
      
  </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>