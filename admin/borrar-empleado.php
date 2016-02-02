<?php 
ob_start();
session_start();
 if(isset($_SESSION['login'])){
 	include("../conexion.php");


	if(isset($_GET["clave"])){

		$clave=$_GET["clave"];

		    $sql="UPDATE empleados SET activo=0 WHERE clave=".$clave." ";
			if (mysql_query($sql,$con)) {
			Header("Location: ver-lista-empleados.php?ok=1");
			}else{
			Header("Location: ver-lista-empleados.php?error=1");
			}
			
	}
 

 }else{
  echo "Esta pagina necesita ser autentificada";
}
ob_end_flush();
?>
