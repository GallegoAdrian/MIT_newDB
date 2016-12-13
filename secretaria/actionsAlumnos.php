<?php

session_start();
require('../functions.php');
//if(isset($_SESSION['type']) && $_SESSION['type'] === 2){

try
{
	$connect = connectDB();

	if($_GET["action"] == "list"){

			$consulta =
			"SELECT al.id_alumno,
				per.nombre,
				per.apellidos,
				per.dni,
				al.direccion,
				per.telefono,
				per.email,
				us.id_rol,
				us.password,
				us.username,
				us.activo
			FROM usuario AS us, persona AS per, alumno AS al
			WHERE us.id_usuario = per.id_persona
			AND al.id_alumno = per.id_persona
			AND us.id_rol = '1'";

			$result = mysqli_query($connect, $consulta);
			$recordCount = mysqli_num_rows($result);

			$consulta =
			"SELECT al.id_alumno,
				per.nombre,
				per.apellidos,
				per.dni,
				al.direccion,
				per.telefono,
				per.email,
				us.id_rol,
				us.password,
				us.username,
				us.activo
			FROM usuario AS us, persona AS per, alumno AS al
			WHERE us.id_usuario = per.id_persona
			AND al.id_alumno = per.id_persona
			AND us.id_rol = '1'
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

			$consulta = 'UPDATE usuario AS us, persona AS per, alumno AS al
						SET per.nombre = "'.$_POST['nombre'].'",
						per.apellidos = "'.$_POST['apellidos'].'",
						per.dni = "'.$_POST['dni'].'",
						per.telefono = "'.$_POST['telefono'].'",
						per.email = "'.$_POST['email'].'",
						al.direccion = "'.$_POST['direccion'].'"
						WHERE us.id_usuario = per.id_persona
						AND per.id_persona = al.id_alumno
						AND us.id_rol = 1
						AND al.id_alumno = "'.$_POST['id_alumno'].'"';

			$result = mysqli_query($connect, $consulta);
			//imprimirlos
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			print json_encode($jTableResult);
			mysqli_close($connect);
	}

	else if($_GET["action"] == "create"){
			//Insert Usuario
			$consulta = "INSERT INTO usuario(password, username, activo, id_rol) 
						 VALUES('" . $_POST["password"] . "',
						 	'" . $_POST["username"] . "','1','1');";
			//Check
			$result = mysqli_query($connect, $consulta);

			//Insert persona
			$consulta = "INSERT INTO persona(nombre, apellidos, dni, telefono, email) 
						 VALUES('" . $_POST["nombre"] . "', 
						 	'" . $_POST["apellidos"] . "', 
						 	'" . $_POST["dni"] . "', 
						 	'" . $_POST["telefono"] . "',
						 	'" . $_POST["email"] . "');";
			//Check
			$result = mysqli_query($connect, $consulta);

			$result = mysqli_query($connect, "SELECT * FROM persona WHERE dni = '" . $_POST["dni"] . "'");

			$row = mysqli_fetch_array($result);

			//Check
			$consulta = "INSERT INTO alumno(id_alumno,direccion)
						 VALUES('" . $row['id_persona'] . "',
						 	'" . $_POST["direccion"] . "');";
			//Check
			$result2 = mysqli_query($connect, $consulta);

			//Check
			$result = mysqli_query($connect, "SELECT * FROM alumno WHERE id_alumno = LAST_INSERT_ID();");

			$row = mysqli_fetch_array($result);

			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			$jTableResult['Record'] = $row;
			print json_encode($jTableResult);
			mysqli_close($connect);
	}

	else if($_GET["action"] == "delete"){

			$consulta = 'DELETE al,us,per 
						 FROM usuario AS us, persona AS per, alumno AS al
						 WHERE al.id_alumno = "'.$_POST['id_alumno'].'" 
						 AND per.id_persona = "'.$_POST['id_alumno'].'" 
						 AND us.id_usuario = "'.$_POST['id_alumno'].'"';

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
