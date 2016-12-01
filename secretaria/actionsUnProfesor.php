<?php

session_start();
require('../functions.php');
//if(isset($_SESSION['type']) && $_SESSION['type'] === 2){

try
{
	$connect = connectDB();

	if($_GET["action"] == "list"){

			$consulta =	"SELECT pro.id_profesor, im.id_asignatura,asi.codigo FROM profesor AS pro, imparte AS im, asignatura AS asi WHERE pro.id_profesor = im.id_profesor AND im.id_asignatura = asi.id_asignatura AND pro.id_profesor = '{$_GET['profesorid']}'";

			$result = mysqli_query($connect, $consulta);

			$recordCount = mysqli_num_rows($result);

			$consulta = "SELECT pro.id_profesor, im.id_asignatura,asi.codigo FROM profesor AS pro, imparte AS im, asignatura AS asi WHERE pro.id_profesor = im.id_profesor AND im.id_asignatura = asi.id_asignatura AND pro.id_profesor = '{$_GET['profesorid']}'
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
