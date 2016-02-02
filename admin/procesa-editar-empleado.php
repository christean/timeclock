<?php 
ob_start();
session_start();
 if(isset($_SESSION['login'])){
 	include("../conexion.php");


function numero(){
  $Numero=array(1=> 1, 2, 3, 4, 5, 6, 7, 8, 9);
  $cad="";
  for($i=1;$i<=5;$i++){
    $clave=$cad.= @$Numero[$aleatorio2=rand(1,9)];
    }
  return $clave;
}

$Clave=$_POST["clave"];
$nombre=$_POST["nombre"];
$apellidos=$_POST["apellidos"];
$puesto=$_POST["puesto"];
$sueldo=$_POST["sueldo"];
$sueldoExtra=$_POST["sueldoExtra"];

$tipoPermiso=3;


	if($nombre=="" || $nombre==NULL){
		Header("Location: editar-empleado.php?error=1");
	}elseif($apellidos=="" || $apellidos==NULL){
		Header("Location: editar-empleado.php?error=2");
	}elseif($puesto=="" || $puesto==NULL || $puesto=="vacio"){
		Header("Location: editar-empleado.php?error=3");
	}elseif($sueldo=="" || $sueldo==NULL){
		Header("Location: editar-empleado.php?error=4");
	}elseif($sueldoExtra=="" || $sueldoExtra==NULL){
		Header("Location: editar-empleado.php?error=5");
	}else{

	    $sql="UPDATE empleados SET nombre='".$nombre."', apellido='".$apellidos."', puesto='".$puesto."', sueldo=".$sueldo.", sueldoExtra=".$sueldoExtra.", permiso=".$tipoPermiso." WHERE clave=".$Clave." ";
		if (mysql_query($sql,$con)) {
		Header("Location: editar-empleado.php?clave=".$Clave."&ok=1");
		}else{
		Header("Location: editar-empleado.php?clave=".$Clave."&error=6");
		}
	}

 }else{
  echo "Esta pagina necesita ser autentificada";
}
ob_end_flush();
?>
