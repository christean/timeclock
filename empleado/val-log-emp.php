<?php
ob_start();
session_start();
include("../conexion.php");

//recibir datos
$ClaveUser=$_POST["clave"];

//consulta en bd
if ($resultado= mysql_query("SELECT clave FROM empleados WHERE clave='".$ClaveUser."' AND permiso=3 AND activo=1", $con)) {

  $val="";
  if(mysql_num_rows($resultado) == 0){
     $val=0;
  }else{
     $val=1;
  }
}

$rutaLogOrigen="log-emp.php";

//Escribir Asistencia
date_default_timezone_set('America/Mexico_City');
$fechaAct=date("Y-m-d"); //Fecha Entrada
$horaAct=date("H:i:s"); //hora Entrada
$numeroSemana=date("W"); 
$year=date("Y");
$nomDia=strftime("%A");

if($ClaveUser=="" || $ClaveUser==NULL || $val==0){
	Header("Location: ".$rutaLogOrigen."?error=1");
	
}else{
	
	  if ($sql = mysql_query("SELECT id, clave, nombre, apellido, puesto, sueldo, sueldoExtra, permiso FROM empleados WHERE clave='".$ClaveUser."' AND activo=1 ",$con)) {
              
                while($row0 = mysql_fetch_assoc($sql)) {
                      $_SESSION['userID']=$row0["id"];
                      $_SESSION['login']=$row0["clave"];
                      $nombreEmp=$row0["nombre"]." ".$row0["apellido"];
                      $_SESSION['nombre']=$nombreEmp;
                      $_SESSION['puesto']=$row0["puesto"];
                      $_SESSION['sueldo']=$row0["sueldo"];
                      $_SESSION['sueldoExtra']=$row0["sueldoExtra"];
                      $_SESSION['permiso']=$row0["permiso"];
                  }
                   //NO DUPLICAR FECHA ENTRADA - CONSULTAR BD ASISTENCIA
                  $sqlEntrada = mysql_query("SELECT idEmpleado, fechaEntrada FROM asistencia WHERE fechaEntrada='".$fechaAct."' AND idEmpleado='".$_SESSION['userID']."'", $con);
                  //REGISTRO DE CHECKIN
                  if(mysql_num_rows($sqlEntrada) == 0){
                           $sql="INSERT INTO asistencia (id, idEmpleado, fechaEntrada, horaEntrada, status) VALUES (NULL, '".$_SESSION['userID']."', '".$fechaAct."', '".$horaAct."', 1)";
                        if (mysql_query($sql,$con)) {
                            mysql_free_result($sqlEntrada);
                            // RESULTADO DE HORAS ACUMULADAS TRABAJADAS DURANTE LA SEMANA ACTUAL - REGRESAR AL PANEL EMPLEADOS
                            Header("Location: panel-empleados.php?checkin=ok");
                        }else{
                            mysql_free_result($sqlEntrada);
                            echo "Existio un error al procesar el check in".mysql_error($con);
                        }
                  }else{
                  //REGISTRO DE CHECKOUT
                  //NO DUPLICAR FECHA Y HORAS SALIDA - CONSULTAR BD ASISTENCIA
                  $sqlSal = mysql_query("SELECT idEmpleado, fechaSalida FROM asistencia WHERE fechaSalida='".$fechaAct."' AND idEmpleado='".$_SESSION['userID']."'", $con);
               
                  if(mysql_num_rows($sqlSal) == 0){
                                //Obtener Hora de Entrada en BD
                                 $sql2 = "SELECT horaEntrada FROM asistencia WHERE fechaEntrada='".$fechaAct."' AND idEmpleado=".$_SESSION['userID']." ";
                                 $rsHora = mysql_query($sql2,$con);

                                     if(mysql_num_rows($rsHora)==0){
                                        echo "No se encontraron Resultados";
                                     }else{
                                              while($row1 = mysql_fetch_assoc($rsHora)) {
                                                    $HoraEntradaBD=$row1["horaEntrada"];
                                              }
                                              //Calcular Numero de horas trabajadas durante el dia
                                              $TotalHorasDia=$horaAct-$HoraEntradaBD;


                                                //leer total horas
                                                if($sql = mysql_query("SELECT SUM(horasTrabajadas) as hrNormal, SUM(horasExtra) AS hrExtra FROM horas_trabajadas WHERE idEmpleado=".$_SESSION['userID']." AND semana=".$numeroSemana." AND year=".$year." ",$con)){

                                                  while($row0 = mysql_fetch_assoc($sql)) {
                                                        $hrNormales=$row0["hrNormal"];
                                                        $hrExtra=$row0["hrExtra"];
                                                      }
                                                }else{
                                                      $hrNormales=0;
                                                      $hrExtra=0;
                                                }

                                                //calculo de horas acumuladas
                                                if(($TotalHorasDia+$hrNormales)<=48){
                                                        $totalHrNormal=$TotalHorasDia;
                                                        $horasExtra=0;
                                                }else{
                                                        $totalHrNormal=48-$hrNormales;
                                                        $horasExtra=$TotalHorasDia-$totalHrNormal;
                                                }


                                              //escribir horas en base de datos del dia en asistencia con el id del empleado, y calculo de horas
                                              $sql3 = "UPDATE asistencia SET fechaSalida='".$fechaAct."', horaSalida='".$horaAct."', horasDia=".$TotalHorasDia.", status=0 WHERE fechaEntrada='".$fechaAct."' AND idEmpleado=".$_SESSION['userID']." ";
                                              if (mysql_query($sql3,$con)) {

                                                $CantPagar=$totalHrNormal*$_SESSION['sueldo'];
                                                $CantPagarHrExtra=$horasExtra*$_SESSION['sueldoExtra'];
                                                //$CantPagarGlobal=$CantPagar+$CantPagarHrExtra;

                                                $sql4="INSERT INTO horas_trabajadas (idEmpleado, fecha, horasTrabajadas, cantPagado, horasExtra, cantPagadoHrExtra, semana, year) VALUES (".$_SESSION['userID'].", '".$fechaAct."', ".$totalHrNormal.", ".$CantPagar.", ".$horasExtra.", ".$CantPagarHrExtra.", ".$numeroSemana.", ".$year.")";
                                                      if (mysql_query($sql4,$con)) {

                                                              $horario=$HoraEntradaBD." hrs - ".$horaAct." hrs";
                                                              //reporte
                                                              $sql5="INSERT INTO reporte (idEmpleado, semana, year, dia, horario, hrNormal, hrExtra) VALUES (".$_SESSION['userID'].", ".$numeroSemana.", '".$year."', '".$nomDia."', '".$horario."', ".$totalHrNormal.", ".$horasExtra.")";
                                                              if (mysql_query($sql5,$con)) {
                                                                    Header("Location: panel-empleados.php?checkout=ok");
                                                              }else{
                                                                   echo "existio un error al actualizar la bd: reporte";
                                                              }

                                                      }else{
                                                        echo "existio un error al actualizar la bd: horas trabajadas";
                                                      }

                                              }else{
                                                       echo "error al actualizar el total de horas bd: asistencia<br/>";  
                                                       echo $sql3; 
                                              }
                                      }//cierre obtener hr entrada
                      }else{ //Regresar al panel por existir una salida previa
                        Header("Location: panel-empleados.php"); 
                      }
                  }//cierre else checkin
    } //cierre if datos user
}//cierre if general
ob_end_flush();
?>