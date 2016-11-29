<?php

session_start();
require('../functions.php');
//if(isset($_SESSION['type']) && $_SESSION['type'] === 2){

try
{
	$connect = connectDB();

	if($_GET["action"] == "list"){

			$consulta =	"SELECT al.id_alumno,per.nombre, per.apellidos, per.dni, al.direccion, per.telefono,per.email 
			FROM usuario AS us, persona AS per, alumno AS al 
			WHERE us.id_usuario = per.id_persona AND al.id_alumno = per.id_persona AND us.id_rol = '1'";

			$result = mysqli_query($connect, $consulta);
			$recordCount = mysqli_num_rows($result);

			$consulta = "SELECT al.id_alumno,per.nombre, per.apellidos, per.dni, al.direccion, per.telefono,per.email 
			FROM usuario AS us, persona AS per, alumno AS al 
			WHERE us.id_usuario = per.id_persona AND al.id_alumno = per.id_persona AND us.id_rol = '1' 
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
