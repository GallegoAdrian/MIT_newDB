<?php

session_start();
require('../functions.php');
//if(isset($_SESSION['type']) && $_SESSION['type'] === 2){

try
{
	$connect = connectDB();

	if($_GET["action"] == "list"){

			$consulta =	"SELECT id_grado, nombre, duracion, creditos, tipo_docencia, nota_corte_pau, precio_cre FROM grados";

			$result = mysqli_query($connect, $consulta);
			$recordCount = mysqli_num_rows($result);

			$consulta = "SELECT id_grado, nombre, duracion, creditos, tipo_docencia, nota_corte_pau, precio_cre FROM grados
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
			//comprovar que materia existe
			//comprovar que el professor la imparte
			$consulta = 'UPDATE grados 
						SET id_grado = "'.$_POST['id_grado'].'",nombre = "'.$_POST['nombre'].'", duracion = "'.$_POST['duracion'].'", creditos = "'.$_POST['creditos'].'",
						tipo_docencia = "'.$_POST['tipo_docencia'].'", nota_corte_pau = "'.$_POST['nota_corte_pau'].'", precio_cre = "'.$_POST['precio_cre'].'" 
						WHERE id_grado = "'.$_POST['id_grado'].'"';

			$result = mysqli_query($connect, $consulta);
			//imprimirlos
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			print json_encode($jTableResult);
			mysqli_close($connect);

	}else if($_GET["action"] == "delete"){

			$consulta = 'DELETE FROM grados WHERE id_grado = "'.$_POST['id_grado'].'"';

			$result = mysqli_query($connect, $consulta);
			//imprimirlos
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			print json_encode($jTableResult);
			mysqli_close($connect);

	}else if($_GET["action"] == "create"){

			$consulta = "INSERT INTO grados(nombre, duracion, creditos, tipo_docencia, nota_corte_pau, precio_cre) 
						 VALUES('" . $_POST["nombre"] . "', '" . $_POST["duracion"] . "', '" . $_POST["creditos"] . "', 
						 	    '" . $_POST["tipo_docencia"] . "', '" . $_POST["nota_corte_pau"] . "', '" . $_POST["precio_cre"] . "' );";

			$result = mysqli_query($connect, $consulta);

			$result = mysqli_query($connect, "SELECT * FROM grados WHERE id_grado = LAST_INSERT_ID();");
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
