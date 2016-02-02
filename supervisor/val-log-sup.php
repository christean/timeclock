<?php
ob_start();
session_start();
include("../conexion.php");

//recibir datos
$userForm=$_POST["user"];
$passForm=md5($_POST["pass"]);

$logOrigen=$_POST["log"];


//consulta en bd
if ($resultado = mysql_query("SELECT user, pass, permiso FROM usuarios WHERE user='".$userForm."' AND pass='".$passForm."' AND permiso=2", $con)) {
   
	$val="";
    if(mysql_num_rows($resultado) == 0){
		$val=0;
    }else{
   		$val=1;
    }
}

if($userForm=="" || $userForm==NULL || $val==0){
	Header("Location: log-sup.php?error=1");
}elseif($passForm=="" || $passForm==NULL || $val==0){
	Header("Location: log-sup.php?error=1");
}else{
	//echo "ingreso al panel principal";
	  if ($sql = mysql_query("SELECT user, pass, permiso FROM usuarios WHERE user='".$userForm."' AND pass='".$passForm."' ",$con)) {
              
                while($row0 = mysql_fetch_assoc($sql)) {
                	$_SESSION['login']=$row0["user"];
                    $_SESSION['user']=$row0["user"];
                    $_SESSION['permiso']=$row0["permiso"];
                  }
                  mysql_free_result($sql);

                   Header("Location: panel-supervisor.php");
         }	
}
ob_end_flush();
?>