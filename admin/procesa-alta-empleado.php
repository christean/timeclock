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


$nombre=$_POST["nombre"];
$apellidos=$_POST["apellidos"];
$puesto=$_POST["puesto"];
$sueldo=$_POST["sueldo"];
$sueldoExtra=$_POST["sueldoExtra"];


$Clave = numero();
$tipoPermiso=3;


	if($nombre=="" || $nombre==NULL){
		Header("Location: alta-empleado.php?error=1");
	}elseif($apellidos=="" || $apellidos==NULL){
		Header("Location: alta-empleado.php?error=2");
	}elseif($puesto=="" || $puesto==NULL || $puesto=="vacio"){
		Header("Location: alta-empleado.php?error=3");
	}elseif($sueldo=="" || $sueldo==NULL){
		Header("Location: alta-empleado.php?error=4");
	}elseif($sueldoExtra=="" || $sueldoExtra==NULL){
		Header("Location: alta-empleado.php?error=5");
	}else{

	    $sql="INSERT INTO empleados (id, clave, nombre, apellido, puesto, sueldo, sueldoExtra, permiso, activo) VALUES (NULL, '".$Clave."', '".$nombre."', '".$apellidos."', '".$puesto."', ".$sueldo.", ".$sueldoExtra.", ".$tipoPermiso.", 1)";
		if (mysql_query($sql,$con)) {
		Header("Location: alta-empleado.php?ok=1&clave=".$Clave);
		}else{
		Header("Location: alta-empleado.php?error=6");
		}
	}

 }else{
  echo "Esta pagina necesita ser autentificada";
}
ob_end_flush();
?>
