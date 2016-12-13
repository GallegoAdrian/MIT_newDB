<?php

session_start();
require('../functions.php');
//if(isset($_SESSION['type']) && $_SESSION['type'] === 2){

try
{
	$connect = connectDB();

	if($_GET["action"] == "list"){

			$consulta =	"SELECT DISTINCT asi.id_asignatura, asi.codigo, asi.descripcion FROM asignatura AS asi";

			$result = mysqli_query($connect, $consulta);
			$recordCount = mysqli_num_rows($result);

			$consulta = "SELECT DISTINCT asi.id_asignatura, asi.codigo, asi.descripcion FROM asignatura AS asi
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

	}else if($_GET["action"] == "update"){

			$consulta = 'UPDATE asignatura
						SET id_asignatura = "'.$_POST['id_asignatura'].'",
						codigo = "'.$_POST['codigo'].'" ,
						descripcion = "'.$_POST['descripcion'].'"
						WHERE id_asignatura = "'.$_POST['id_asignatura'].'"';

			$result = mysqli_query($connect, $consulta);
			//imprimirlos
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			print json_encode($jTableResult);
			mysqli_close($connect);

	}else if($_GET["action"] == "delete"){

		    $consulta = 'DELETE FROM asignatura WHERE id_asignatura = "'.$_POST['id_asignatura'].'"';

			$result = mysqli_query($connect, $consulta);
			//imprimirlos
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			print json_encode($jTableResult);
			mysqli_close($connect);

	}else if($_GET["action"] == "create"){

		    $consulta = "INSERT INTO asignatura(codigo, descripcion) 
						 VALUES('" . $_POST["codigo"] . "', '" . $_POST["descripcion"] . "');";

			$result = mysqli_query($connect, $consulta);

			$result = mysqli_query($connect, "SELECT * FROM asignatura WHERE id_asignatura = LAST_INSERT_ID();");
			$row = mysqli_fetch_array($result);

			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			$jTableResult['Record'] = $row;
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
