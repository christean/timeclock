<?php 
session_start();
 if(isset($_SESSION['login'])){
 	include("../conexion.php");

 

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
      width: 400px;
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
  if($_SESSION['permiso']==2){

     if(isset($_GET["area"])){

       $area=$_GET["area"];


     


   $rutaPanelPrin="panel-supervisor.php";
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

      echo "<p>".ucwords(strtolower($area))."</p>";
    ?>
  </p>

  </div>
</div>

 <div class="container">



<table class="table table-hover" cellspacing="1" id="TablaRes">
    <thead>  
      <tr>  
        <th>Puesto</th>  
        <th>Nombre del Empleado</th>  
      </tr>  
    </thead>  
    <tbody>   
    <?php //bucle sql 
    date_default_timezone_set('America/Mexico_City');
    $fechaAct=date("Y-m-d"); //Fecha Actual






    //detalle por la semana actual

     /*$SQLgeneral="SELECT E.id AS  `id` , E.nombre AS  `nombre` , E.apellido AS  `apellido` , E.puesto AS  `puesto`

    FROM empleados AS E
    LEFT OUTER JOIN  `horas_trabajadas` AS T ON T.idEmpleado = E.id
    WHERE T.semana =".$numeroSemana."
    ORDER BY E.puesto ASC";
    


      $rsP = mysql_query($SQLgeneral,$con);

      if(@mysql_num_rows($rsP)==0){
        echo "No se encontraron Resultados.";
      }else{

        while($row = mysql_fetch_assoc($rsP)) {
          echo "<tr>";
          echo "<td>".ucwords(strtolower($row["puesto"]))."</td>";

             $sqlA="SELECT fechaEntrada FROM asistencia WHERE fechaEntrada='".$fechaAct."' AND idEmpleado=".$row["id"]." ";
             $rsA = mysql_query($sqlA,$con);
              if(@mysql_num_rows($rsA)==0){
                echo "<td>".ucwords(strtolower($row["apellido"]))." ".ucwords(strtolower($row["nombre"]))."</td>";
              }else{
                echo "<td><a href='rep-asistencia-empleado.php?id=".$row["id"]."&area=".$area."'> ".ucwords(strtolower($row["apellido"]))." ".ucwords(strtolower($row["nombre"]))."</a></td>";
              }

        }

        echo "</tr>";
      }
      */
  

     //detalle por fecha de entrada del dia actual filtrado por departamento
     $SQLgeneral="SELECT E.id AS `id`, E.nombre AS  `nombre` , E.apellido AS  `apellido` , E.puesto AS  `puesto`

      FROM empleados AS E
      LEFT OUTER JOIN  `asistencia` AS A ON A.idEmpleado = E.id
      WHERE A.fechaEntrada ='".$fechaAct."' AND E.puesto='".$area."' AND A.status=1
      ORDER BY E.puesto ASC";
    
      $rsP = mysql_query($SQLgeneral,$con);

      if(@mysql_num_rows($rsP)==0){
        echo "No se encontraron Resultados.";
      }else{

        while($row = mysql_fetch_assoc($rsP)) {
          echo "<tr>";
          echo "<td>".ucwords(strtolower($row["puesto"]))."</td>";
                echo "<td><a href='rep-asistencia-empleado.php?id=".$row["id"]."&area=".$area."'> ".ucwords(strtolower($row["apellido"]))." ".ucwords(strtolower($row["nombre"]))."</a></td>";
        }

        echo "</tr>";
      }
    






    ?>
    </tbody>
</table>


<br/>
<br/>
<div class="btn-back">
  <a href="panel-supervisor.php" class="btn btn-default btn-lg" role="button"><span class="glyphicon glyphicon-arrow-left"></span> Regresar</a>
</div>




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