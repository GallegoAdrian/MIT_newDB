<?php
header('Content-Type: text/html; charset=utf-8');
require('../functions.php');

try
{
	session_start();
	$connect = connectDB();

	$idAlumno = getAlumnoId($_SESSION["username"], $connect);

	if($_GET["action"] == "list"){

		$consulta =  "SELECT al.id_alumno, asi.descripcion, ma.curso_esc, ma.convoc, ma.nota
						FROM usuario AS us
						INNER JOIN persona AS pe ON pe.id_persona = us.id_usuario
						INNER JOIN alumno AS al ON al.id_alumno = pe.id_persona
						INNER JOIN matricula AS ma ON ma.id_alumno = al.id_alumno
						INNER JOIN asignatura AS asi ON asi.id_asignatura = ma.id_asignatura
						WHERE  al.id_alumno = '$idAlumno'";

		$result = mysqli_query($connect, $consulta);
		$recordCount = mysqli_num_rows($result);
		$row = mysqli_fetch_array($result);

		$consulta =  "SELECT al.id_alumno, asi.descripcion, ma.curso_esc, ma.convoc, ma.nota
						FROM usuario AS us
						INNER JOIN persona AS pe ON pe.id_persona = us.id_usuario
						INNER JOIN alumno AS al ON al.id_alumno = pe.id_persona
						INNER JOIN matricula AS ma ON ma.id_alumno = al.id_alumno
						INNER JOIN asignatura AS asi ON asi.id_asignatura = ma.id_asignatura
						WHERE  al.id_alumno = '$idAlumno'
						ORDER BY ".$_GET["jtSorting"]. " LIMIT ".$_GET["jtStartIndex"]. ", ".$_GET["jtPageSize"].";";

		$result = mysqli_query($connect, $consulta);

		$rows = array();

		while($row = mysqli_fetch_array($result)){
			$rows[] = $row;
		}

		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['TotalRecordCount'] = $recordCount;
		$jTableResult['Records'] = $rows;
		print json_encode($jTableResult);
	}

	mysqli_close($connect);

}
catch(Exception $ex)
{

	$jTableResult = array();
	$jTableResult['Result'] = "ERROR";
	$jTableResult['Message'] = $ex->getMessage();
	print json_encode($jTableResult);
}

?>