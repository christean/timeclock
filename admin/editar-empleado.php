<?php 
session_start();
 if(isset($_SESSION['login'])){
 	include("../conexion.php");

date_default_timezone_set('America/Mexico_City');
$fechaAct=date("Y-m-d"); //Fecha Entrada
$horaAct=date("H:i:s"); //hora Entrada
$numeroSemana=date("W"); 
$year=date("Y"); 


$clave="";
if(isset($_GET["clave"])){
  $clave=$_GET["clave"];
}
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
  <p>Editar Empleado</p>
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
  <strong>Error!</strong>  Completa el nombre del Empleado
</div>
<?php
}
?>

<?php
if($error==2){
?>
 <div class="alert alert-warning alert-danger" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Error!</strong>  Completa los apellidos del Empleado
</div>
<?php
}
?>

<?php
if($error==3){
?>
 <div class="alert alert-warning alert-danger" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Error!</strong>  Selecciona de la lista el puesto del empleado
</div>
<?php
}
?>

<?php
if($error==4){
?>
 <div class="alert alert-warning alert-danger" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Error!</strong>  Completa el campo de Sueldo Normal
</div>
<?php
}
?>

<?php
if($error==5){
?>
 <div class="alert alert-warning alert-danger" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Error!</strong>  Completa el campo de Sueldo Hora Extra
</div>
<?php
}
?>

<?php
if($error==6){
?>
 <div class="alert alert-warning alert-danger" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Error!</strong>  Existio un error al guardar el registro.
</div>
<?php
}
?>


<?php
if($ok==1){
?>
 <div class="alert alert-success alert-success" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <span class="glyphicon glyphicon-ok"></span>  El empleado se actualizo correctamente</span>
</div>
<?php
}
?>


<?php
/*if($clave==0){
  echo "No existe informacion para procesar";

}else{*/
       if ($sqld = mysql_query("SELECT clave, nombre, apellido, puesto, sueldo, sueldoExtra, permiso FROM empleados WHERE activo=1 AND clave=".$clave." ",$con)) {
              
                while($rowd = mysql_fetch_assoc($sqld)) {
                    $puesto=ucwords(strtolower($rowd["puesto"]));
?>
<div class="form">
  <form role="form" action="procesa-editar-empleado.php" method="POST">
    <input type="hidden" value="<?php echo $rowd["clave"]; ?>" name="clave">
  <div class="form-group">
    <label for="">Nombre</label>
    <input type="text" class="form-control" id="" name="nombre"
           value="<?php echo $rowd["nombre"]; ?>" placeholder="Introduce el Nombre del Empleado. Ej. Juan Carlos">
  </div>
  <div class="form-group">
    <label for="">Apellidos</label>
    <input type="text" class="form-control" id="" name="apellidos"
           value="<?php echo $rowd["apellido"]; ?>" placeholder="Introduce los Apellidos Ej. Garcia Morales">
  </div>

  <div class="form-group">
  <label for="">Puesto</label>
    <select class="form-control" name="puesto">
      <option value="vacio">Seleccione una opci&oacute;n</option>
      <?php
      echo $puesto;
      echo "<br>";
          if ($sql = mysql_query("SELECT puesto FROM puestos WHERE activo=1 ORDER BY puesto ASC",$con)) {
              
                while($row0 = mysql_fetch_assoc($sql)) {

                      if($row0["puesto"]==$puesto){

                        echo "<option value='".$row0["puesto"]."' selected='selected'>".ucwords(strtolower($row0["puesto"]))."</option>";
                      }else{ echo $row0["puesto"];
                        echo "<option value='".$row0["puesto"]."' >".ucwords(strtolower($row0["puesto"]))."</option>";
                      }
                  }
                   mysql_free_result($sql);
         }
      ?>
    </select>
  </div>
  <div class="form-group">
    <label for="">Sueldo Normal</label>
    <input type="number" class="form-control" id="" name="sueldo"
           value="<?php echo $rowd["sueldo"]; ?>" placeholder="Introduce el sueldo correspondiente.">
  </div>

  <div class="form-group">
    <label for="">Sueldo Hora Extra</label>
    <input type="number" class="form-control" id="" name="sueldoExtra"
           value="<?php echo $rowd["sueldoExtra"]; ?>" placeholder="Introduce el sueldo extra correspondiente.">
  </div>

  <button type="submit" class="btn btn-default">Actualizar</button>
</form>
</div>

<?php
                 
                    
                  }
                   mysql_free_result($sqld);
         }else{
          echo "error";
         }



//}
?>


<br/>
<br/>
<div class="btn-back">
  <a href="ver-lista-empleados.php" class="btn btn-default btn-lg" role="button"><span class="glyphicon glyphicon-arrow-left"></span> Regresar</a>
</div>

</div>

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