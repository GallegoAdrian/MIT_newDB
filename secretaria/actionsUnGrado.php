<?php

session_start();
require('../functions.php');
//if(isset($_SESSION['type']) && $_SESSION['type'] === 2){

try
{
	$connect = connectDB();

	if($_GET["action"] == "list"){

			$consulta =	"SELECT gal.id_grd_alu, per.nombre, per.apellidos, gal.curso_esc,gal.baixa, alu.id_alumno 
							FROM persona AS per, alumno AS alu, grados_alumnos AS gal, grados AS gra 
							WHERE per.id_persona = alu.id_alumno AND alu.id_alumno = gal.id_alumno AND gal.id_grado = gra.id_grado AND gra.id_grado = '{$_GET['gradoid']}'";

			$result = mysqli_query($connect, $consulta);

			$recordCount = mysqli_num_rows($result);

			$consulta =	"SELECT gal.id_grd_alu, per.nombre, per.apellidos, gal.curso_esc,gal.baixa, alu.id_alumno 
							FROM persona AS per, alumno AS alu, grados_alumnos AS gal, grados AS gra 
							WHERE per.id_persona = alu.id_alumno AND alu.id_alumno = gal.id_alumno AND gal.id_grado = gra.id_grado AND gra.id_grado = '{$_GET['gradoid']}'
					ORDER BY " . $_GET["jtSorting"] . " LIMIT " . $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"] . ";";

			$result = mysqli_query($connect, $consulta);

			$rows = array();

			while($row = mysqli_fetch_array($result)){
				$rows[] = $row;
			}
			
			//imprimirlos
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			$jTableResult['Records'] = $rows;
			$jTableResult['TotalRecordCount'] = $recordCount;
			print json_encode($jTableResult);
			mysqli_close($connect);

	}
	else if($_GET["action"] == "update"){

			$consulta = 'UPDATE persona AS per, alumno AS alu, grados_alumnos AS gal, grados AS gra
						SET per.nombre = "'.$_POST['nombre'].'",per.apellidos = "'.$_POST['apellidos'].'", gal.curso_esc = "'.$_POST['curso_esc'].'", 
						gal.baixa = "'.$_POST['baixa'].'"
						WHERE per.id_persona = alu.id_alumno AND alu.id_alumno = gal.id_alumno AND gal.id_grado = gra.id_grado 
						AND gal.id_grd_alu = "'.$_POST['id_grd_alu'].'"';

			$result = mysqli_query($connect, $consulta);
			//imprimirlos
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			print json_encode($jTableResult);
			mysqli_close($connect);

	}else if($_GET["action"] == "delete"){

			$consulta = 'DELETE FROM grados_alumnos WHERE grados_alumnos.id_grd_alu = "'.$_POST['id_grd_alu'].'"';

			$result = mysqli_query($connect, $consulta);
			//imprimirlos
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			print json_encode($jTableResult);
			mysqli_close($connect);
	}
	else if($_GET["action"] == "create"){

			$consulta = "INSERT INTO grados_alumnos(id_alumno,id_grado,curso_esc ,baixa) 
						 VALUES('" . $_POST["id_alumno"] . "','" . $_GET["gradoid"] . "','16-17','0' );";

			$result = mysqli_query($connect, $consulta);

			$result = mysqli_query($connect, "SELECT * FROM grados_alumnos WHERE id_grd_alu  = LAST_INSERT_ID();");
			$row = mysqli_fetch_array($result);

			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			$jTableResult['Record'] = $row;
			print json_encode($jTableResult);
			mysqli_close($connect);
	}
	else if($_GET["action"] == "getAlumnoId"){

			$consulta = "SELECT alu.id_alumno, per.nombre, per.apellidos FROM persona AS per,alumno AS alu WHERE alu.id_alumno = per.id_persona";

			$result = mysqli_query($connect, $consulta);

			$rows = array();

			while($row = mysqli_fetch_array($result)){
				$arr = array();
				$arr['DisplayText'] = $row['apellidos'].", ".$row['nombre'];
				$arr['Value'] = $row['id_alumno'];
				$rows[] = $arr;
			}

			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			$jTableResult['Options'] = $rows;
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
