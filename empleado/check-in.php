<?php 
ob_start();
session_start();
 if(isset($_SESSION['login'])){
 	include("../conexion.php");
 	include("hora-login.php");


//Escribir Asistencia
date_default_timezone_set('America/Mexico_City');
$fechaAct=date("Y-m-d"); //Fecha Entrada
$horaAct=date("H:i:s"); //hora Entrada



		/*if($horaAct>=$horaEntrada && $horaAct<=$horaSalida){*/

			        //NO DUPLICAR FECHA ENTRADA - CONSULTAR BD ASISTENCIA
				    $sqlEntrada = mysql_query("SELECT idEmpleado, fechaEntrada FROM asistencia WHERE fechaEntrada='".$fechaAct."' AND idEmpleado='".$_SESSION['userID']."'", $con);
				    //REGISTRO DE CHECKIN
				    if(mysql_num_rows($sqlEntrada) == 0){

				    		$sql="INSERT INTO asistencia (id, idEmpleado, fechaEntrada, horaEntrada) VALUES (NULL, '".$_SESSION['userID']."', '".$fechaAct."', '".$horaAct."' )";
							if (mysql_query($sql,$con)) {
								mysql_free_result($sqlEntrada);

								// RESULTADO DE HORAS ACUMULADAS TRABAJADAS DURANTE LA SEMANA ACTUAL - REGRESAR AL PANEL EMPLEADOS
								Header("Location: panel-empleados.php?checkin=ok");

							} else {
								mysql_free_result($sqlEntrada);
							    echo "Existio un error al procesar el check in" . mysql_error($con);
							}
						
				    }else{
				    	//REDIRECCION PANEL EMPLEADOS POR EXISTENCIA DE LOG EN EL DIA
				    	mysql_free_result($sqlEntrada);
						Header("Location: panel-empleados.php");
				   	}


		/*}else{
		      Header("Location: log-emp.php");
		}//cierre validacion horario permitido
		*/

}else{//cierre login
  echo "Acceso Restringido: Favor de Iniciar Sesion";
}
ob_end_flush();
?>