<?php 
session_start();
 if(isset($_SESSION['login'])){
 	include("../conexion.php");


//comprobacion de errores
$checkin=0;
if(isset($_GET["checkin"])){
    if($_GET["checkin"]=="ok"){
    $checkin=1;
  }
}

$checkout=0;
if(isset($_GET["checkout"])){
    if($_GET["checkout"]=="ok"){
    $checkout=1;
  }
}


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
    <title>Panel Empleados</title>

    <!-- Bootstrap -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>
  <body>


<?php
 	if($_SESSION['permiso']==3){
?>
<div class="jumbotron">
  <div class="container">
    <!-- <h1>GeoFel.Net</h1> -->
    <h3><?php echo "Bienvenido: ".ucwords($_SESSION['nombre']); ?></h3>
    <h3><?php echo "Puesto: ".strtoupper($_SESSION['puesto']); ?></h3>
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

if($checkin==0 && $checkout==0){
  echo "Ya registro su entrada y salida del dia.";
}
?>



<!-- CHECK IN-->
<?php
if($checkin==1){
?>
<div class="alert alert-success alert-success" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <span class="glyphicon glyphicon-ok"></span>  Se registro correctamente su hora de entrada.
</div>


    <?php //bucle sql 


    $sql1="SELECT DAYNAME(fecha) AS fecha, horasTrabajadas AS hora FROM horas_trabajadas WHERE idEmpleado=".$_SESSION['userID']." AND semana=".$numeroSemana." ";

      $rs1 = mysql_query($sql1,$con);

      if(@mysql_num_rows($rs1)==0){
        echo "No has acumulado horas en la seamana: ".$numeroSemana;
      }else{


        echo "<table class=\"table table-hover\" cellspacing=\"1\" id=\"TablaRes\">
    <thead>  
      <tr>  
        <th>Lunes</th>  
        <th>Martes</th>
        <th>Miercoles</th>
        <th>Jueves</th>
        <th>Viernes</th>
        <th>Sabado</th>
        <th>Domingo</th>
        <th>Horas Normales</th>
        <th>Horas Extra</th>
        <th>Total</th>       
      </tr>  
    </thead>  
    <tbody>";
        
        $HrMonday="";
        $HrTuesday="";
        $HrWednesday="";
        $HrThursday="";
        $HrFriday="";
        $HrSaturday="";
        $HrSunday="";

        echo "<tr>";

        while($row = mysql_fetch_assoc($rs1)) {
            
            if($row["fecha"]=="Monday"){
              $HrMonday=$row["hora"];
            }

            if($row["fecha"]=="Tuesday"){
              $HrTuesday=$row["hora"];
            }

            if($row["fecha"]=="Wednesday"){
              $HrWednesday=$row["hora"];
            }

            if($row["fecha"]=="Thursday"){
              $HrThursday=$row["hora"];
            }

            if($row["fecha"]=="Friday"){
              $HrFriday=$row["hora"];
            }

            if($row["fecha"]=="Saturday"){
              $HrSaturday=$row["hora"];
            }

            if($row["fecha"]=="Sunday"){
              $HrSunday=$row["hora"];
            }

        }

          $totalHrSemana1=0;

          $sqlHr1="SELECT SUM(horasTrabajadas) AS `totalHrNormal`
            FROM `horas_trabajadas`
            WHERE idEmpleado =".$_SESSION['userID']." AND semana =".$numeroSemana." ";

              $rs2 = mysql_query($sqlHr1,$con);
              if(mysql_num_rows($rs2)==0){
                       $totalHrNormal1=0;
              }else{
                while($row = mysql_fetch_assoc($rs2)) {
                      $totalHrNormal1=$row["totalHrNormal"]; 
                  }
              }
              
          $sqlHr2="SELECT SUM(horasExtra) AS `hrExtra`
          FROM `horas_trabajadas`
          WHERE idEmpleado =".$_SESSION['userID']." AND semana =".$numeroSemana." ";

            $rs3 = mysql_query($sqlHr2,$con);
            if(mysql_num_rows($rs3)==0){
                    $horasExtra1=0;
            }else{
              while($row = mysql_fetch_assoc($rs3)) {
                    $horasExtra1=$row["hrExtra"]; 
                }
            }

            $totalHrSemana1=$totalHrNormal1+$horasExtra1;

            echo "<td>".$HrMonday."</td>";
            echo "<td>".$HrTuesday."</td>";
            echo "<td>".$HrWednesday."</td>";
            echo "<td>".$HrThursday."</td>";
            echo "<td>".$HrFriday."</td>";
            echo "<td>".$HrSaturday."</td>";
            echo "<td>".$HrSunday."</td>";
            echo "<td>".$totalHrNormal1."</td>";
            echo "<td>".$horasExtra1."</td>";
            echo "<td>".$totalHrSemana1."</td>";
            echo "</tr>";
      }

    ?>
    </tbody>
</table>
<?php

echo "<br/><br/>";


}
?>


<!-- CHECK OUT -->
<?php
if($checkout==1){
?>
<div class="alert alert-success alert-success" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <span class="glyphicon glyphicon-ok"></span>  Se registro correctamente su hora de Salida.
</div>

<table class="table table-hover" cellspacing="1" id="TablaRes">
    <thead>  
      <tr>  
        <th>Lunes</th>  
        <th>Martes</th>
        <th>Miercoles</th>
        <th>Jueves</th>
        <th>Viernes</th>
        <th>Sabado</th>
        <th>Domingo</th>
        <th>Horas Normales</th>
        <th>Horas Extra</th>
        <th>Total</th>   
      </tr>  
    </thead>  
    <tbody>   
    <?php //bucle sql 


    $sql1="SELECT DAYNAME(fecha) AS fecha, horasTrabajadas AS hora FROM horas_trabajadas WHERE idEmpleado=".$_SESSION['userID']." AND semana=".$numeroSemana." ";
//$sql1="SELECT DAYNAME('fecha') AS fecha , horasTrabajadas AS hora , SUM('horasTrabajadas') AS totalHr FROM horas_trabajadas WHERE idEmpleado=".$_SESSION['userID']." AND semana=".$numeroSemana." ";

      $rs = mysql_query($sql1,$con);

      if(@mysql_num_rows($rs)==0){
        //echo "No se encontraron resultados suficientes para procesar";
      }else{
        
        $HrMonday="";
        $HrTuesday="";
        $HrWednesday="";
        $HrThursday="";
        $HrFriday="";
        $HrSaturday="";
        $HrSunday="";

        echo "<tr>";

        while($row = mysql_fetch_assoc($rs)) {
            
            if($row["fecha"]=="Monday"){
              $HrMonday=$row["hora"];
            }

            if($row["fecha"]=="Tuesday"){
              $HrTuesday=$row["hora"];
            }

            if($row["fecha"]=="Wednesday"){
              $HrWednesday=$row["hora"];
            }

            if($row["fecha"]=="Thursday"){
              $HrThursday=$row["hora"];
            }

            if($row["fecha"]=="Friday"){
              $HrFriday=$row["hora"];
            }

            if($row["fecha"]=="Saturday"){
              $HrSaturday=$row["hora"];
            }

            if($row["fecha"]=="Sunday"){
              $HrSunday=$row["hora"];
            }

        }

 
          $totalHrSemana2=0;

          $sqlHr2="SELECT SUM(horasTrabajadas) AS `totalHrNormal`
            FROM `horas_trabajadas`
            WHERE idEmpleado =".$_SESSION['userID']." AND semana =".$numeroSemana." ";

              $rs3 = mysql_query($sqlHr2,$con);
              if(mysql_num_rows($rs3)==0){
                       $totalHrNormal2=0;
              }else{
                while($row = mysql_fetch_assoc($rs3)) {
                      $totalHrNormal2=$row["totalHrNormal"]; 
                  }
              }
              
          $sqlHr3="SELECT SUM(horasExtra) AS `hrExtra`
          FROM `horas_trabajadas`
          WHERE idEmpleado =".$_SESSION['userID']." AND semana =".$numeroSemana." ";

            $rs4 = mysql_query($sqlHr3,$con);
            if(mysql_num_rows($rs4)==0){
                    $horasExtra2=0;
            }else{
              while($row = mysql_fetch_assoc($rs4)) {
                    $horasExtra2=$row["hrExtra"]; 
                }
            }

            $totalHrSemana2=$totalHrNormal2+$horasExtra2;

            echo "<td>".$HrMonday."</td>";
            echo "<td>".$HrTuesday."</td>";
            echo "<td>".$HrWednesday."</td>";
            echo "<td>".$HrThursday."</td>";
            echo "<td>".$HrFriday."</td>";
            echo "<td>".$HrSaturday."</td>";
            echo "<td>".$HrSunday."</td>";
            echo "<td>".$totalHrNormal2."</td>";
            echo "<td>".$horasExtra2."</td>";
            echo "<td>".$totalHrSemana2."</td>";
        echo "</tr>";

      }

    ?>
    </tbody>
</table>
<?php
}
?>

    <div class="center-block">

      <?php
      //VERIFICAR CHECK IN DEL DIA
      $sqlEntrada = mysql_query("SELECT idEmpleado, fechaEntrada, fechaSalida, horaEntrada, horaSalida FROM asistencia WHERE fechaEntrada='".$fechaAct."' AND idEmpleado='".$_SESSION['userID']."'", $con);
      //REGISTRO DE CHECKIN
      if(mysql_num_rows($sqlEntrada) == 0){
      ?>
      <!-- <a href="check-in.php" class="btn btn-success btn-lg" role="button">Checar Entrada</a>
      <a href="#" class="btn btn-danger btn-lg disabled" role="button">Checar Salida</a> -->
      <?php
      }else{
           while($row1 = mysql_fetch_assoc($sqlEntrada)) {
                   $Entrada=$row1["fechaEntrada"];
                   $Salida=$row1["fechaSalida"];
                   $hrEntrada=$row1["horaEntrada"];
                   $hrSalida=$row1["horaSalida"];
                }
           echo "<div><h1>Hora Entrada: <strong>".$hrEntrada."</strong>";
           if($hrSalida=="00:00:00"){
            echo " /  No ha registrado su salida";
           }else{
            echo " /  Hora Salida: <strong>".$hrSalida."</strong>";
           }
          
          echo "</h1></div>";
      }




      ?>
    </div>

</div>
<br/><br/><br/>
<?php
} //cierre 
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