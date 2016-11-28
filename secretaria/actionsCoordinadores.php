<?php

session_start();
require('../functions.php');
//if(isset($_SESSION['type']) && $_SESSION['type'] === 2){

try
{
	$connect = connectDB();

	if($_GET["action"] == "list"){

			$consulta =	"SELECT coor.id_coordinador, per.nombre,coor.dpto, per.dni,asignatura.descripcion,us.id_rol 
						FROM usuario AS us, persona AS per, coordinador AS coor, asignatura WHERE us.id_usuario = per.id_persona AND per.id_persona = coor.id_coordinador AND asignatura.id_asignatura = coor.id_asignatura AND us.id_rol = '3'";

			$result = mysqli_query($connect, $consulta);
			$recordCount = mysqli_num_rows($result);

			$consulta = "SELECT coor.id_coordinador, per.nombre,coor.dpto, per.dni,asignatura.descripcion,us.id_rol 
						FROM usuario AS us, persona AS per, coordinador AS coor, asignatura WHERE us.id_usuario = per.id_persona AND per.id_persona = coor.id_coordinador AND asignatura.id_asignatura = coor.id_asignatura AND us.id_rol = '3' ORDER BY " . $_GET["jtSorting"] . " LIMIT " . $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"] . ";";

			$result = mysqli_query($connect, $consulta);


			$rows = array();
			while($row = mysqli_fetch_array($result)){
				$rows[] = $row;
			}
			
			//imprimirlos
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			$jTableResult['TotalRecordCount'] = $recordCount;
			$jTableResult['Records'] = $rows;
			print json_encode($jTableResult);
			mysqli_close($connect);

	}
	else if($_GET["action"] == "update"){
			//comprovar que materia existe
			//comprovar que el professor la imparte

			$consulta = 'UPDATE matricula, asignatura SET matricula.nota = "'.$_POST['nota'].'" 
						 WHERE matricula.id_asignatura = asignatura.id_asignatura 
						 AND asignatura.codigo = "'.$_GET['materia'].'"';

			$result = mysqli_query($connect, $consulta);
			//imprimirlos
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			print json_encode($jTableResult);
			mysqli_close($connect);
	}


}
catch(Exception $ex)
{

	$jTableResult = array();
	$jTableResult['Result'] = "ERROR";
	$jTableResult['Message'] = $ex->getMessage();
	print json_encode($jTableResult);
}
//}

?>
