<?php 
ob_start();
session_start();
 if(isset($_SESSION['login'])){
 	include("../conexion.php");


$puesto=$_POST["puesto"];

//consulta en bd
if ($resultado = mysql_query("SELECT puesto, activo FROM puestos WHERE puesto='".$puesto."' ", $con)) {
   
	$val="";
    if(mysql_num_rows($resultado) == 0){
		$val=0;
    }else{
   		$val=1;
    }
}

	if($puesto=="" || $puesto==NULL){
		Header("Location: alta-puestos.php?error=1");

	}elseif($val==1){
		Header("Location: alta-puestos.php?error=2");

	}else{

	    $sql="INSERT INTO puestos (puesto, activo) VALUES ('".$puesto."', 1)";
		if (mysql_query($sql,$con)) {
		Header("Location: alta-puestos.php?ok=1");
		}else{
		Header("Location: alta-puestos.php?error=3");
		}
	}

 }else{
  echo "Esta pagina necesita ser autentificada";
}
ob_end_flush();
?>
