<?php

require('../functions.php');

try
{
	session_start();
	$connect = connectDB();

	$idAlumno = getAlumnoId($_SESSION["username"], $connect);
	$username = $_SESSION["username"];

	if($_GET["action"] == "list"){

		$consulta =  "SELECT al.id_alumno, asi.descripcion, ma.curso_esc, ma.convoc, ma.nota
						FROM usuario us, persona pe, alumno al, matricula ma, asignatura asi
						WHERE us.id_usuario = pe.id_persona 
						AND pe.id_persona = al.id_alumno 
						AND al.id_alumno = ma.id_alumno 
						AND ma.id_asignatura = asi.id_asignatura
						AND us.username = '$username'";

		$result = mysqli_query($connect, $consulta);
		$recordCount = mysqli_num_rows($result);
		$row = mysqli_fetch_array($result);

		$consulta =  "SELECT al.id_alumno, asi.descripcion, ma.curso_esc, ma.convoc, ma.nota
						FROM usuario AS us 
						INNER JOIN persona AS pe ON pe.id_persona = us.id_usuario
						INNER JOIN alumno AS al ON al.id_alumno = pe.id_persona
						INNER JOIN matricula AS ma ON ma.id_alumno = al.id_alumno
						INNER JOIN asignatura AS asi ON asi.id_asignatura = ma.id_asignatura
						WHERE  us.username = '$username'
						ORDER BY ".$_GET["jtSorting"]." LIMIT ".$_GET["jtStartIndex"].",".$_GET["jtPageSize"].";";
						var_dump($consulta);
		/*
		$consulta =  "SELECT al.id_alumno, asi.descripcion, ma.curso_esc, ma.convoc, ma.nota
						FROM usuario us, persona pe, alumno al, matricula ma, asignatura asi
						WHERE us.id_usuario = pe.id_persona 
						AND pe.id_persona = al.id_alumno 
						AND al.id_alumno = ma.id_alumno 
						AND ma.id_asignatura = asi.id_asignatura
						AND us.username = '$username'
						ORDER BY ".$_GET["jtSorting"]." LIMIT ".$_GET["jtStartIndex"].",".$_GET["jtPageSize"].";";
						
						*/
						//var_dump($consulta);
/*
		$consulta = "SELECT alumno.id_alumno,asig.descripcion, asi.codigo,m.convoc,m.nota,m.baixa 
						FROM matricula AS m INNER JOIN asignaturas as asig on asig.codigo = m.codigo 
						INNER JOIN alumnos AS alumno ON alumno.id_alumno=m.id_alumno WHERE alumno.id_alumno='$idAlumno'
						ORDER BY " . $_GET["jtSorting"] . " LIMIT " . $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"] . ";";
*/
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