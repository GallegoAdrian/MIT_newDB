<?php

session_start();
require('../functions.php');
//if(isset($_SESSION['type']) && $_SESSION['type'] === 2){

try
{
	$connect = connectDB();

	if($_GET["action"] == "list"){

			$consulta =	"SELECT coor.id_coordinador, per.nombre,coor.dpto, per.dni,asignatura.id_asignatura,us.id_rol 
						FROM usuario AS us, persona AS per, coordinador AS coor, asignatura 
						WHERE us.id_usuario = per.id_persona AND per.id_persona = coor.id_coordinador AND asignatura.id_asignatura = coor.id_asignatura AND us.id_rol = '3'";

			$result = mysqli_query($connect, $consulta);
			$recordCount = mysqli_num_rows($result);

			$consulta = "SELECT coor.id_coordinador, per.nombre,coor.dpto, per.dni,asignatura.id_asignatura,us.id_rol 
						FROM usuario AS us, persona AS per, coordinador AS coor, asignatura WHERE us.id_usuario = per.id_persona AND per.id_persona = coor.id_coordinador AND asignatura.id_asignatura = coor.id_asignatura AND us.id_rol = '3' ORDER BY " . $_GET["jtSorting"] . " LIMIT " . $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"] . ";";

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

			$consulta = 'UPDATE persona as per, coordinador as coor, asignatura as asi 
						 SET coor.id_coordinador = "'.$_POST['id_coordinador'].'", asi.id_asignatura = "'.$_POST['id_asignatura'].'",
						 per.nombre = "'.$_POST['nombre'].'",per.dni = "'.$_POST['dni'].'", coor.dpto = "'.$_POST['dpto'].'"
						 WHERE per.id_persona = coor.id_coordinador
						 AND asi.id_asignatura = coor.id_asignatura 
						 AND coor.id_coordinador = "'.$_POST['id_coordinador'].'"';


			$result = mysqli_query($connect, $consulta);
			//imprimirlos
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			print json_encode($jTableResult);
			mysqli_close($connect);

	}else if($_GET["action"] == "create"){


			$consulta1 = "INSERT INTO persona(nombre, dni) 
						 VALUES('" . $_POST["nombre"] . "', '" . $_POST["dni"] . "');";
			$consulta2 = "INSERT INTO coordinador(dpto) 
						 VALUES('" . $_POST["dpto"] . "');";
			$consulta3 = "INSERT INTO asignatura(id_asignatura) 
						 VALUES('" . $_POST["id_asignatura"] . "');";
			$consulta4 = "INSERT INTO usuario(id_usuario, id_rol) 
						 VALUES('" . $_POST["id_coordinador"] . "','3');";

			$result1 = mysqli_query($connect, $consulta1);
			$result3 = mysqli_query($connect, $consulta3);
			$result4 = mysqli_query($connect, $consulta4);
			$result2 = mysqli_query($connect, $consulta2);

			//$result = mysqli_query($connect, "SELECT * FROM persona WHERE id_persona = LAST_INSERT_ID();");
			$result = mysqli_query($connect, "SELECT * FROM coordinador WHERE id_coordinador = LAST_INSERT_ID();");
			//$result = mysqli_query($connect, "SELECT * FROM persona WHERE id_persona = LAST_INSERT_ID();");


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
