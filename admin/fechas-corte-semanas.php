<?php 
session_start();
 if(isset($_SESSION['login'])){
 	include("../conexion.php");

date_default_timezone_set('America/Mexico_City');
$fechaAct=date("Y-m-d"); //Fecha Entrada
$horaAct=date("H:i:s"); //hora Entrada
$numeroSemana=date("W"); 
$year=date("Y"); 

 	//comprobacion de errores
$error=0;
if(isset($_GET["error"])){

    if($_GET["error"]==1){
    $error=1;
    }
    if($_GET["error"]==2){
    $error=2;
    }
    if($_GET["error"]==3){
    $error=3;
    }
    if($_GET["error"]==4){
    $error=4;
    }
    if($_GET["error"]==5){
    $error=5;
    }
    if($_GET["error"]==6){
    $error=6;
    }
}

$ok="";
if(isset($_GET["ok"])){

    if($_GET["ok"]==1){
    $ok=1;
    }
}

$clave="";
if(isset($_GET["clave"])){

    $clave=$_GET["clave"];
}

$costo="";
if(isset($_GET["costo"])){

    $costo=$_GET["costo"];
}

$puesto="";
if(isset($_GET["puesto"])){

    $puesto=$_GET["puesto"];
}




 ?>
 <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Panel Principal</title>

    <!-- Bootstrap -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
    .form{
      margin: 0 auto;
      width: 400px;
    }
     .btn-back{
      margin: 0 auto;
      width: 100px;
    }

    .clave{
      font-size: 20px;
      font-weight: bold;
    }


    </style>
  </head>
  <body>

<?php
 	if($_SESSION['permiso']==1){
?>
<div class="jumbotron">
  <div class="container">
    <!-- <h1>GeoFel.Net</h1> -->
    <h3><?php echo "Bienvenido: ".strtoupper($_SESSION['user']); ?></h3>
    <a href="salir-panel.php" class="btn btn-danger btn-lg pull-right" role="button"><span class="glyphicon glyphicon-off"></span> Salir</a>
      <p>Semana: 
    <?php echo $numeroSemana; 

      if ($sqlSem = mysql_query("SELECT DATE_FORMAT(inicia,'%d-%b-%Y') AS inicia , DATE_FORMAT(finaliza,'%d-%b-%Y') AS finaliza FROM semanas WHERE year='".$year."' AND semana=".$numeroSemana." ",$con)) {
              
                while($row0 = mysql_fetch_assoc($sqlSem)) {
                   echo " - del ".$row0["inicia"]." al ".$row0["finaliza"]." ";
                  }
                   mysql_free_result($sqlSem);
         }
    ?>
  </p>
  </div>
</div>

<div class="container">

<?php
 include("menu-admin.php");
?>
<br/><br/><br/>


<?php
if($error==1){
?>
 <div class="alert alert-warning alert-danger" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Error!</strong>  Complete el campo de Semana
</div>
<?php
}
?>

<?php
if($error==2){
?>
 <div class="alert alert-warning alert-danger" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Error!</strong>  Complete el campo de año
</div>
<?php
}
?>

<?php
if($error==3){
?>
 <div class="alert alert-warning alert-danger" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Error!</strong>  Complete el campo de fecha inicial
</div>
<?php
}
?>

<?php
if($error==4){
?>
 <div class="alert alert-warning alert-danger" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Error!</strong>  Complete el campo de fecha final
</div>
<?php
}
?>

<?php
if($error==5){
?>
 <div class="alert alert-warning alert-danger" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Error!</strong>  No se puede duplicar la semana y a&ntilde;o capturados. Agrege nuevos valores.
</div>
<?php
}
?>

<?php
if($ok==1){
?>
 <div class="alert alert-success alert-success" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <span class="glyphicon glyphicon-ok"></span>  El registro fue agregado correctamente.
</div>
<?php
}
?>

<div class="form">
  <form role="form" action="procesa-fecha-corte-semanas.php" method="POST">
  <div class="form-group">
    <label for="">Semana:</label>
    <input type="text" class="form-control" id="" name="semana"
           placeholder="Introduce el numero de semana. Ej. 7..">
  </div>
  <div class="form-group">
    <label for="">Año:</label>
    <input type="number" class="form-control" id="" name="year"
           placeholder="Introduce el año Ej. 2016">
  </div>
  <div class="form-group">
    <label for="">Inicia:</label>
    <input type="date" class="form-control" id="" name="fechaInicia"
           placeholder="Introduce una fecha valida Ej. 2015-06-15">
  </div>
   <div class="form-group">
    <label for="">Finaliza:</label>
    <input type="date" class="form-control" id="" name="fechaFin"
           placeholder="Introduce una fecha valida Ej. 2015-06-15">
  </div>

  <button type="submit" class="btn btn-default">Guardar</button>
</form>
</div>
<br/>
<br/>

<div class="btn-back">
  <a href="panel-principal.php" class="btn btn-default btn-lg" role="button"><span class="glyphicon glyphicon-arrow-left"></span> Regresar</a>
</div>

</div>
<br/>
<br/>
<br/>
<?php
} //cierre admin
?>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>

<?php
}else{
  echo "Acceso Restringido: Favor de Iniciar Sesion";
}

?>