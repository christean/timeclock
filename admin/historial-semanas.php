<?php 
session_start();
 if(isset($_SESSION['login'])){
 	include("../conexion.php");

 //Escribir Asistencia
date_default_timezone_set('America/Mexico_City');
$fechaAct=date("Y-m-d"); //Fecha Entrada
$horaAct=date("H:i:s"); //hora Entrada
$numeroSemana=date("W");


if (isset($_GET["pagina"])){
            $pagina = $_GET["pagina"];

}
 ?>
 <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Historial</title>

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
      width: 550px;
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
?>
<div class="jumbotron">
  <div class="container">
    <!-- <h1>GeoFel.Net</h1> -->
    <h3><?php echo "Bienvenido: ".strtoupper($_SESSION['user']); ?></h3>
    <a href="salir-panel.php" class="btn btn-danger btn-lg pull-right" role="button"><span class="glyphicon glyphicon-off"></span> Salir</a>
  </div>
</div>

<div class="container">
  
<?php
 include("menu-admin.php");
?>

<br/><br/><br/>

<?php
//paginacion

$url = "historial-semanas.php";

$consulta_noticias = "SELECT * FROM horas_trabajadas GROUP BY semana";
$rs_noticias = mysql_query($consulta_noticias, $con);
$num_total_registros = mysql_num_rows($rs_noticias);
//Si hay registros
if ($num_total_registros > 0) {
  //Limito la busqueda
  $TAMANO_PAGINA = 5;
        $pagina = false;

  //examino la pagina a mostrar y el inicio del registro a mostrar
        if (isset($_GET["pagina"]))
            $pagina = $_GET["pagina"];
        
  if (!$pagina) {
    $inicio = 0;
    $pagina = 1;
  }
  else {
    $inicio = ($pagina - 1) * $TAMANO_PAGINA;
  }
  //calculo el total de paginas
  $total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);

  $consulta = "SELECT semana, year, FORMAT(SUM(cantPagado),2) AS `pago` 
        FROM `horas_trabajadas` GROUP BY semana ORDER BY semana DESC LIMIT ".$inicio."," . $TAMANO_PAGINA;
  $rs = mysql_query($consulta, $con);

     echo "<table class='table table-hover'>
      <thead>
        <tr>
          <th>A&ntilde;o</th>
          <th>Semana</th>
          <th>Pago</th>
          <th>Ver Detalle</th>
        </tr>
      </thead>
      <tbody>";

       while ($row = mysql_fetch_array($rs)) {
        echo "<tr>";
          
          if($row["pago"]>0){
           echo "<td>".$row["year"]."</td><td>".$row["semana"]."</td><td>$ ".$row["pago"]."</td><td><a href='historial-semana-costo.php?semana=".$row["semana"]."&year=".$row["year"]."&pagina=".$pagina."'>Ver Detalle</a></td>";
         }else{
           echo "<td>".$row["year"]."</td><td>".$row["semana"]."</td><td>$ ".$row["pago"]."</td><td>Sin informaci&oacute;n</td>";
         }
        echo "</tr>";
       } 
        echo "</tbody>
        </table>";


      //indices paginas
      echo "<center><nav class=\"center-block\">
      <ul class=\"pagination\">
      <li>";

      if ($total_paginas > 1) {
      if ($pagina != 1)
      echo '<a href="'.$url.'?pagina='.($pagina-1).'" aria-label="Previous" ><span aria-hidden="true">&laquo;</span></a></li>';
      for ($i=1;$i<=$total_paginas;$i++) {
      if ($pagina == $i)
        //si muestro el �ndice de la p�gina actual, no coloco enlace
        echo "<li class=\"active\"><a href=\"#\">".$pagina."<span class=\"sr-only\">(current)</span></a></li>";
      else
        //si el �ndice no corresponde con la p�gina mostrada actualmente,
        //coloco el enlace para ir a esa p�gina
        echo ' <li> <a href="'.$url.'?pagina='.$i.'">'.$i.'</a></li>  ';
      }
      if ($pagina != $total_paginas)
      echo '<li><a href="'.$url.'?pagina='.($pagina+1).'" aria-label="Next" "><span aria-hidden="true">&raquo;</span></a>';
      }
      echo ' </li>
      </ul>
      </nav></center>';
}
?>



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