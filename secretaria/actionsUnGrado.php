<?php

session_start();
require('../functions.php');
//if(isset($_SESSION['type']) && $_SESSION['type'] === 2){

try
{
	$connect = connectDB();

	if($_GET["action"] == "list"){

			$consulta =	"SELECT gra.id_grado, per.nombre, gal.curso_esc,gal.baixa 
							FROM persona AS per, alumno AS alu, grados_alumnos AS gal, grados AS gra 
							WHERE per.id_persona = alu.id_alumno AND alu.id_alumno = gal.id_alumno AND gal.id_grado = gra.id_grado AND gra.id_grado = '{$_GET['gradoid']}'";

			$result = mysqli_query($connect, $consulta);

			$recordCount = mysqli_num_rows($result);

			$_GET["jtSorting"] = 2;
			$_GET["jtStartIndex"]= 1; 
			$_GET["jtPageSize"] = 2;

			$consulta =	"SELECT gra.id_grado, per.nombre, gal.curso_esc,gal.baixa 
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
	// else if($_GET["action"] == "update"){
	// 	if (isset($_GET['materia'])) {
	// 		//comprovar que materia existe
	// 		//comprovar que el professor la imparte

	// 		$consulta = 'UPDATE matricula, asignatura SET matricula.nota = "'.$_POST['nota'].'" 
	// 					 WHERE matricula.id_asignatura = asignatura.id_asignatura 
	// 					 AND asignatura.codigo = "'.$_GET['materia'].'"';

	// 		$result = mysqli_query($connect, $consulta);
	// 		//imprimirlos
	// 		$jTableResult = array();
	// 		$jTableResult['Result'] = "OK";
	// 		print json_encode($jTableResult);
	// 		mysqli_close($connect);
	// 	}
	// }


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
