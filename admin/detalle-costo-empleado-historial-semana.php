<?php 
session_start();
 if(isset($_SESSION['login'])){
 	include("../conexion.php");

date_default_timezone_set('America/Mexico_City');
$fechaAct=date("Y-m-d"); //Fecha Entrada
$horaAct=date("H:i:s"); //hora Entrada

 

    if(isset($_GET["semana"])){
       $numeroSemana=$_GET["semana"];
     }

      if(isset($_GET["pagina"])){
       $pagina=$_GET["pagina"];
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
    .table{
    
      font-size: 18px;
    }
    .btn-back{
      margin: 0 auto;
      width: 100px;
    }

    </style>
  </head>
  <body>




<?php
  if($_SESSION['permiso']==1){

     if(isset($_GET["area"])){

       $area=$_GET["area"];


      if(isset($_GET["semana"])){

       $semana=$_GET["semana"];
     }

      if(isset($_GET["id"])){

       $idEmpleado=$_GET["id"];
     }


     if(isset($_GET["year"])){

       $year=$_GET["year"];
     }


   $rutaPanelPrin="panel-principal.php";
?>
<div class="jumbotron">
  <div class="container">
    <!-- <h1>GeoFel.Net</h1> -->
    <h3><?php echo "Bienvenido: ".strtoupper($_SESSION['user']);?></h3>
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

  <?php
         if ($sqlDat = mysql_query("SELECT nombre, apellido, puesto FROM empleados WHERE id=".$idEmpleado." ",$con)) {
              
                while($rowDat = mysql_fetch_assoc($sqlDat)) {
                   echo "<h3> ".ucfirst($rowDat["puesto"])." - ".ucwords($rowDat["nombre"])." ".ucwords($rowDat["apellido"])." </h3><br/><br/>";
                  }
                   mysql_free_result($sqlDat);
         }

?>
  </div>
</div>

 <div class="container">
<?php
 include("menu-admin.php");
?>
<br/><br/><br/>


<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th></th>
      <th>Horario</th>
      <th>Normales</th>
      <th>Extra</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
<?php

$dia = array('Monday' => 'Lunes', 
  'Tuesday' => 'Martes',
  'Wednesday' => 'Miercoles',
  'Thursday' => 'Jueves',
  'Friday' => 'Viernes',
  'Saturday' => 'Sabado',
  'Sunday' => 'Domingo');

 if ($sqlReport = mysql_query("SELECT dia, horario, hrNormal, hrExtra FROM reporte WHERE idEmpleado=".$idEmpleado." AND semana=".$semana." AND year=".$year." ",$con)) {
              
                $hrAcom=0;
                $hrAcumHrNormal=0;
                $hrAcumHrExtra=0;
                $hrAcumTotal=0;

                while($rowDat = mysql_fetch_assoc($sqlReport)) {
                   $hrAcumTotal=($rowDat["hrNormal"]+$rowDat["hrExtra"])+$hrAcumTotal;
                   $hrAcumHrNormal=$rowDat["hrNormal"]+$hrAcumHrNormal;
                   $hrAcumHrExtra=$rowDat["hrExtra"]+$hrAcumHrExtra;
                   echo "<tr><td><strong>".$dia[$rowDat["dia"]]."</strong></td><td>".$rowDat["horario"]."</td><td>".$rowDat["hrNormal"]." hrs</td><td>".$rowDat["hrExtra"]." hrs</td><td>".$hrAcumTotal." hrs</td></tr>";
                  
                  }

                    if ($sqlCost = mysql_query("SELECT sueldo, sueldoExtra FROM empleados WHERE id=".$idEmpleado." ",$con)) {

                          while($row = mysql_fetch_assoc($sqlCost)) {
                              $hrCostoNormal=$row["sueldo"];
                              $hrCostoExtra=$row["sueldoExtra"];
                          }
                          mysql_free_result($sqlCost);

                          $normal=$hrCostoNormal*$hrAcumHrNormal;
                          $extra=$hrCostoExtra*$hrAcumHrExtra;
                          $total=$normal+$extra;
                    }


                  echo "<tr>
                          <td></td><td><strong>Suma</strong></td><td><strong>".$hrAcumHrNormal." hrs</strong></td><td><strong>".$hrAcumHrExtra." hrs</td><td><strong>".$hrAcumTotal." hrs</strong></td>
                        </tr>
                         <tr>
                          <td></td><td></td><td><strong>$ ".number_format($normal,2)."</td><td><strong>$ ".number_format($extra,2)."</strong></td><td><strong>$ ".number_format($total,2)."</strong></td>
                        </tr>";

                   mysql_free_result($sqlReport);
    }
?>
  
  </tbody>
</table>

<br/><br/>



<br/>
<div class="btn-back">
  <a href="detalle-costo-area-semana.php?<?php echo "area=".$area."&semana=".$semana."&year=".$year."&pagina=".$pagina; ?>" class="btn btn-default btn-lg" role="button"><span class="glyphicon glyphicon-arrow-left"></span> Regresar</a>
</div>

<br/><br/><br/>


</div>
<?php
            }//cierre GET
  } //cierre supervisor
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