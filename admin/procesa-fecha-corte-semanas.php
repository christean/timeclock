<?php 
ob_start();
session_start();
 if(isset($_SESSION['login'])){
 	include("../conexion.php");


$semana=$_POST["semana"];
$year=$_POST["year"];
$fechaInicia=$_POST["fechaInicia"];
$fechaFin=$_POST["fechaFin"];


//consulta en bd
if ($resultado = mysql_query("SELECT semana, year FROM semana WHERE semana=".$semana." AND year=".$year." ", $con)) {
   
	$valSem="";
    if(mysql_num_rows($resultado) == 0){
		$valSem=0;
    }else{
   		$valSem=1;
    }
}


	if($semana=="" || $semana==NULL){
		Header("Location: fechas-corte-semanas.php?error=1");
	}elseif($year=="" || $year==NULL){
		Header("Location: fechas-corte-semanas.php?error=2");
	}elseif($fechaInicia=="" || $fechaInicia==NULL){
		Header("Location: fechas-corte-semanas.php?error=3");
	}elseif($fechaFin=="" || $fechaFin==NULL){
		Header("Location: fechas-corte-semanas.php?error=4");
	}elseif($valSem=1){
		Header("Location: fechas-corte-semanas.php?error=5");
	}else{

	    $sql="INSERT INTO semanas (id, semana, year, inicia, finaliza) VALUES (NULL, '".$semana."', '".$year."', '".$fechaInicia."', '".$fechaFin."' )";
		if (mysql_query($sql,$con)) {
		Header("Location: fechas-corte-semanas.php?ok=1");
		}else{
		Header("Location: fechas-corte-semanas.php?error=6");
		}
	}

 }else{
  echo "Esta pagina necesita ser autentificada";
}
ob_end_flush();
?>
