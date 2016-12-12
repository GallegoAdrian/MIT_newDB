<?php

session_start();
require('../functions.php');
//if(isset($_SESSION['type']) && $_SESSION['type'] === 2){

try
{
	$connect = connectDB();

	if($_GET["action"] == "list"){

			$consulta =	"SELECT  im.id_imparte,pro.id_profesor, im.id_asignatura,asi.codigo FROM profesor AS pro, imparte AS im, asignatura AS asi WHERE pro.id_profesor = im.id_profesor AND im.id_asignatura = asi.id_asignatura AND pro.id_profesor = '{$_GET['profesorid']}'";

			$result = mysqli_query($connect, $consulta);

			$recordCount = mysqli_num_rows($result);

			$consulta = "SELECT  im.id_imparte,pro.id_profesor, im.id_asignatura,asi.codigo FROM profesor AS pro, imparte AS im, asignatura AS asi WHERE pro.id_profesor = im.id_profesor AND im.id_asignatura = asi.id_asignatura AND pro.id_profesor = '{$_GET['profesorid']}'
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
		
			//comprovar que materia existe
			//comprovar que el professor la imparte

			$consulta = "UPDATE imparte AS im SET im.id_asignatura = '".$_POST['id_asignatura']."'
					     WHERE im.id_profesor = " . $_GET["profesorid"] . ";";

			$result = mysqli_query($connect, $consulta);
			//imprimirlos
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			print json_encode($jTableResult);
			mysqli_close($connect);

	}else if($_GET["action"] == "delete"){

			$consulta = 'DELETE FROM imparte WHERE imparte.id_imparte = "'.$_POST['id_imparte'].'"';
			$result = mysqli_query($connect, $consulta);

			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			print json_encode($jTableResult);
			mysqli_close($connect);
	}
	else if($_GET["action"] == "create"){

			$consulta = "SELECT im.id_imparte FROM imparte AS im WHERE im.id_asignatura = '".$_POST["id_asignatura"]."' AND im.id_profesor = '".$_GET["profesorid"]."'";

			$result = mysqli_query($connect, $consulta);
			$numRow = mysqli_num_rows($result);

			if($numRow == 0){

				$consulta = "INSERT INTO imparte(id_profesor,id_asignatura) 
							 VALUES('" . $_GET["profesorid"] . "','" . $_POST["id_asignatura"] . "' );";

				$result = mysqli_query($connect, $consulta);

				$result = mysqli_query($connect, "SELECT * FROM imparte WHERE id_imparte  = LAST_INSERT_ID();");
				$row = mysqli_fetch_array($result);

				$jTableResult = array();
				$jTableResult['Result'] = "OK";
				$jTableResult['Record'] = $row;
				print json_encode($jTableResult);
				mysqli_close($connect);

			}else{
					$jTableResult = array();
					$jTableResult['Result'] = "ERROR";
					$jTableResult['Message'] = 'Este profesor ya está impartiendo la asignatura.';
					print json_encode($jTableResult);
					mysqli_close($connect);
			}

	}
	else if($_GET["action"] == "getAssigId"){

			$consulta = "SELECT id_asignatura, descripcion FROM asignatura";

			$result = mysqli_query($connect, $consulta);

			$rows = array();

			while($row = mysqli_fetch_array($result)){
				$arr = array();
				$arr['DisplayText'] = $row['descripcion'];
				$arr['Value'] = $row['id_asignatura'];
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
