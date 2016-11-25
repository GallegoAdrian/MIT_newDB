<?php

require('../functions.php');

try
{
	session_start();
	$connect = connectDB();

	$idAlumno = $_SESSION["id_alumno"];
	
	if($_GET["action"] == "list"){

		$consulta = "SELECT alumno.id_alumno, asig.descripcion,m.codigo,m.convoc,m.nota,m.baixa 
						FROM matricula AS m INNER JOIN asignaturas as asig on asig.codigo = m.codigo 
						INNER JOIN alumnos AS alumno ON alumno.id_alumno=m.id_alumno WHERE alumno.id_alumno = '$idAlumno'";

		$result = mysqli_query($connect, $consulta);
		$recordCount = mysqli_num_rows($result);
		$row = mysqli_fetch_array($result);

		$consulta = "SELECT alumno.id_alumno,asig.descripcion,m.codigo,m.convoc,m.nota,m.baixa 
						FROM matricula AS m INNER JOIN asignaturas as asig on asig.codigo = m.codigo 
						INNER JOIN alumnos AS alumno ON alumno.id_alumno=m.id_alumno WHERE alumno.id_alumno='$idAlumno'
						ORDER BY " . $_GET["jtSorting"] . " LIMIT " . $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"] . ";";

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
