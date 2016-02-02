<?php 
ob_start();
session_start();
 if(isset($_SESSION['login'])){
 	include("../conexion.php");
 	//include("hora-login.php");


//Escribir Asistencia
date_default_timezone_set('America/Mexico_City');
$fechaAct=date("Y-m-d"); //Fecha Entrada
$horaAct=date("H:i:s"); //hora Entrada
$numeroSemana=date("W"); 



		/*if($horaAct>=$horaEntrada && $horaAct<=$horaSalida){*/

			//Obtener Hora de Entrada en BD
			 $sql = "SELECT horaEntrada FROM asistencia WHERE fechaEntrada='".$fechaAct."' AND idEmpleado=".$_SESSION['userID']." ";

			 $rsHora = mysql_query($sql,$con);

			     if(mysql_num_rows($rsHora)==0){
			        echo "No se encontraron Resultados.<br>";
			        //echo $sql;
			     }else{
				        while($row1 = mysql_fetch_assoc($rsHora)) {
				           $HoraEntradaBD=$row1["horaEntrada"];
				        }
			            //Calcular Numero de horas trabajadas durante el dia
			            $TotalHorasDia=$horaAct-$HoraEntradaBD;

			            //escribir horas en base de datos del dia en asistencia con el id del empleado, y calculo de horas
			            $sql1 = "UPDATE asistencia SET fechaSalida='".$fechaAct."', horaSalida='".$horaAct."', horasDia=".$TotalHorasDia." WHERE fechaEntrada='".$fechaAct."' AND idEmpleado=".$_SESSION['userID']." ";
						if (mysql_query($sql1,$con)) {

							        $CantPagar=$TotalHorasDia*$_SESSION['sueldo'];

									$sql2="INSERT INTO horas_trabajadas (idEmpleado, fecha, horasTrabajadas, cantPagado, semana) VALUES (".$_SESSION['userID'].", '".$fechaAct."', ".$TotalHorasDia.", ".$CantPagar.", ".$numeroSemana.")";
				                    if (mysql_query($sql2,$con)) {

				                    	Header("Location: panel-empleados.php?checkout=ok");

				                    }else{
				                    	echo "existio un error al actualizar la bd: horas trabajadas";
				                    }

						}else{
                             echo "error al actualizar el total de horas bd: asistencia<br>";
                             echo  $sql1;
						}
						echo "error al obtener hora entrada";

			      }//cierre obtener hr entrada


		/*}else{
		      Header("Location: log-emp.php");
		}//cierre validacion horario permitido
		*/

}else{//cierre login
  echo "Acceso Restringido: Favor de Iniciar Sesion";
}
ob_end_flush();
?>