<?php 
ob_start();
session_start();
 if(isset($_SESSION['login'])){
 	include("../conexion.php");


$puesto=$_POST["puesto"];
$id=$_POST["idPuesto"];

//consulta en bd

if ($resultado = mysql_query("SELECT activo FROM puestos WHERE id=".$id." AND activo=1 ", $con)) {
   
	$act="";
    if(mysql_num_rows($resultado) == 0){
		$act=0;
    }else{
   		$act=1;
    }
}


	if($puesto=="" || $puesto==NULL){
		Header("Location: editar-puestos.php?id=".$id."&error=1");

	}elseif($act==0){
		Header("Location: editar-puestos.php?id=".$id."&error=2");

	}else{

	    $sql="UPDATE puestos SET puesto='".$puesto."' WHERE id=".$id." ";
		if (mysql_query($sql,$con)) {
		Header("Location: editar-puestos.php?id=".$id."&ok=1");
		}else{
		Header("Location: editar-puestos.php?id=".$id."&error=3");
		}
	}

 }else{
  echo "Esta pagina necesita ser autentificada";
}
ob_end_flush();
?>
