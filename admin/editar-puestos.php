<?php 
session_start();
 if(isset($_SESSION['login'])){
 	include("../conexion.php");

date_default_timezone_set('America/Mexico_City');
$fechaAct=date("Y-m-d"); //Fecha Entrada
$horaAct=date("H:i:s"); //hora Entrada
$numeroSemana=date("W"); 
$year=date("Y"); 


$id="";
if(isset($_GET["id"])){

    $id=$_GET["id"];
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

    .table{
      margin: 0 auto;
      width: 300px;
      font-size: 18px;
    }

    </style>


    <script type="text/javascript">
        function confirmar(id) {
          var id;
         if ( confirm('Esta por borrar el puesto seleccionado') ) {
         window.location='borrar-puesto.php?id='+id;
      }
        return false;
      }
    </script>


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
    <p>Editar Puesto</p>
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
  <strong>Error!</strong>  Complete el campo de Puesto.
</div>
<?php
}
?>

<?php
if($error==2){
?>
 <div class="alert alert-warning alert-danger" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Error!</strong> El registro que desea agregar no se encuentra activo.
</div>
<?php
}
?>

<?php
if($error==3){
?>
 <div class="alert alert-warning alert-danger" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Error!</strong> Existio un error al procesar el registro.
</div>
<?php
}
?>


<?php
if($ok==1){
?>
 <div class="alert alert-success alert-success" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <span class="glyphicon glyphicon-ok"></span>  El puesto fue actualizado correctamente.
</div>
<?php
}
?>




  <?php //bucle sql 

     $SQL="SELECT id, puesto FROM puestos WHERE activo=1 AND id=".$id." ";
   
      $rs = mysql_query($SQL,$con);

      if(@mysql_num_rows($rs)==0){
        echo "No se encontro el puesto en la base de datos.";
      }else{

        while($row = mysql_fetch_assoc($rs)) {
          
          $puesto=$row["puesto"];
          $id=$row["id"];
        }
   
      }

    ?>

<div class="form">
  <form role="form" action="procesa-editar-puestos.php" method="POST">
  <div class="form-group">
    <label for="">Puesto:</label>
    <input type="text" class="form-control" id="" value="<?php echo $puesto; ?>" name="puesto"
           placeholder="Introduce el puesto">
    <input type="hidden" value="<?php echo $id; ?>" name="idPuesto">
  </div>

  <button type="submit" class="btn btn-default">Actualizar</button>
</form>
</div>

<br/><br/>

<div class="btn-back">
  <a href="alta-puestos.php" class="btn btn-default btn-lg" role="button"><span class="glyphicon glyphicon-arrow-left"></span> Regresar</a>
</div>

<br/><br/><br/>

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