<?php 
ob_start();
session_start();
 if(isset($_SESSION['login'])){
 	include("../conexion.php");

	if(isset($_GET["id"])){

		$id=$_GET["id"];

		    $sql="UPDATE puestos SET activo=0 WHERE id=".$id." ";
			if (mysql_query($sql,$con)) {
			Header("Location: alta-puestos.php?ok=2");
			}else{
			Header("Location: alta-puestos.php?error=1");
			}
	}
 
 }else{
  echo "Esta pagina necesita ser autentificada";
}
ob_end_flush();
?>
