<?php

session_start();
require('../functions.php');
if(isset($_SESSION['type']) && $_SESSION['type'] === 2){

try
{
	$connect = connectDB();

	if($_GET["action"] == "list"){
		if (isset($_GET['materia'])) {
			//comprovar que materia existe
			//comprovar que el professor la imparte

			//cojer datos
			$idAlumno = 1;
			$consulta = "SELECT a.id_alumno, a.nombre, a.apellidos,m.nota
						FROM matricula m, alumnos a
						WHERE m.codigo = '{$_GET['materia']}'
						AND m.id_alumno = a.id_alumno
						";

			$result = mysqli_query($connect, $consulta);
			$recordCount = mysqli_num_rows($result);
				// foreach ($result as $row) {
				// 	var_dump($row);
				// }
				// $row = mysqli_fetch_array($result);
				// var_dump($row);

			$consulta = "SELECT a.id_alumno, a.nombre, a.apellidos, m.nota
						FROM matricula m, alumnos a
						WHERE m.codigo = '{$_GET['materia']}'
						AND m.id_alumno = a.id_alumno
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

			//cojer datos
			$idAlumno = 1;
			$consulta = 'UPDATE matricula 
				SET nota = "'.$_POST['nota'].'" 
				WHERE codigo = "'.$_GET['materia'].'"';

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
}

?>
