<?php

session_start();
require('../functions.php');
//if(isset($_SESSION['type']) && $_SESSION['type'] === 2){

try
{
	$connect = connectDB();

	if($_GET["action"] == "list"){
		if (isset($_GET['materia'])) {

			$consulta =	"SELECT al.id_alumno,pe.nombre, pe.apellidos, ma.nota 
							FROM persona AS pe, matricula AS ma, alumno AS al, asignatura AS asi 
							WHERE pe.id_persona = al.id_alumno AND ma.id_alumno = al.id_alumno 
							AND ma.id_asignatura = asi.id_asignatura AND asi.codigo = '{$_GET['materia']}'";

			$result = mysqli_query($connect, $consulta);
			$recordCount = mysqli_num_rows($result);

			$consulta = "SELECT al.id_alumno, pe.nombre, pe.apellidos, ma.nota 
							FROM persona AS pe, matricula AS ma, alumno AS al, asignatura AS asi 
							WHERE pe.id_persona = al.id_alumno AND ma.id_alumno=al.id_alumno 
							AND ma.id_asignatura = asi.id_asignatura AND asi.codigo = '{$_GET['materia']}'
						ORDER BY " . $_GET["jtSorting"] . " LIMIT " . $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"] . ";";

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

	}
	else if($_GET["action"] == "update"){
		if (isset($_GET['materia'])) {
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
