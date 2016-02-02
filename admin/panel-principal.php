<?php 
session_start();
 if(isset($_SESSION['login'])){
 	include("../conexion.php");

 //Escribir Asistencia
date_default_timezone_set('America/Mexico_City');
$fechaAct=date("Y-m-d"); //Fecha Entrada
$horaAct=date("H:i:s"); //hora Entrada
$numeroSemana=date("W"); 
$year=date("Y"); 





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
      margin: 0 auto;
      width: 600px;
      font-size: 18px;
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
<table class="table table-hover" cellspacing="1" id="TablaRes">
    <thead>  
      <tr>  
        <th>Puestos</th>  
        <th>Normal</th>
        <th>Extra</th>
        <th>Total</th>
      </tr>  
    </thead>  
    <tbody>
    <?php //bucle sql 

     $SQLgeneral="SELECT E.puesto AS `puesto`, FORMAT(SUM( T.cantPagado),2) AS `pago`, FORMAT(SUM(T.cantPagadoHrExtra),2) AS `extra` , FORMAT(SUM(T.cantPagado+T.cantPagadoHrExtra),2) AS `total`
        FROM  `empleados` AS E
        LEFT OUTER JOIN  `horas_trabajadas` AS T ON T.idEmpleado = E.id
        WHERE T.semana =".$numeroSemana."
        GROUP BY E.puesto ASC";

      $rsP = mysql_query($SQLgeneral,$con);

      if(@mysql_num_rows($rsP)==0){
        echo "No se encontraron Resultados.";
      }else{

        while($row = mysql_fetch_assoc($rsP)) {
          echo "<tr>";
          echo "<td><a href='detalle-costo-area.php?area=".$row["puesto"]."' >".ucwords(strtolower($row["puesto"]))."</a></td><td>$ ".$row["pago"]."</td><td>$ ".$row["extra"]."</td><td><strong>$ ".$row["total"]."</strong></td>";
          echo "</tr>";
        }
      }

    ?>
    </tbody>
</table>

<br/><br/>
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