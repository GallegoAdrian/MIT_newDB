<?php

session_start();
require('../functions.php');
//if(isset($_SESSION['type']) && $_SESSION['type'] === 2){

try
{
	$connect = connectDB();
	if($_GET["action"] == "list"){

			$consulta =	"SELECT pro.id_profesor,
								pro.ingreso,
								pro.categoria,
								per.dni,
								per.nombre,
								per.apellidos,
								per.telefono,
								per.email,
								us.id_rol,
								us.password,
								us.username,
								us.activo
						FROM usuario AS us, persona AS per, profesor AS pro
						WHERE us.id_usuario = per.id_persona
						AND per.id_persona = pro.id_profesor
						AND us.id_rol = 2";

			$result = mysqli_query($connect, $consulta);
			$recordCount = mysqli_num_rows($result);

			$consulta =	"SELECT pro.id_profesor,
								pro.ingreso,
								pro.categoria,
								per.dni,
								per.nombre,
								per.apellidos,
								per.telefono,
								per.email,
								us.id_rol,
								us.password,
								us.username,
								us.activo
						FROM usuario AS us, persona AS per, profesor AS pro
						WHERE us.id_usuario = per.id_persona
						AND per.id_persona = pro.id_profesor
						AND us.id_rol = 2
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

			//Hacer update de DNI - NOMBRE - CATEGORIA- INGRESO
			$consulta = 'UPDATE usuario AS us,persona AS per,profesor AS pro
						SET per.dni = "'.$_POST['dni'].'",
						per.nombre = "'.$_POST['nombre'].'",
						pro.categoria = "'.$_POST['categoria'].'",
						pro.ingreso = "'.$_POST['ingreso'].'"
						WHERE us.id_usuario = per.id_persona
						AND per.id_persona = pro.id_profesor
						AND us.id_rol = 2
						AND pro.id_profesor = "'.$_POST['id_profesor'].'"';

			$result = mysqli_query($connect, $consulta);
			//imprimirlos
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			print json_encode($jTableResult);
			mysqli_close($connect);
	}
	else if($_GET["action"] == "create"){


			$consulta = 'INSERT INTO usuario(password, username, activo, id_rol) 
						 VALUES("' . $_POST['password'] . '","' . $_POST['username'] . '",1,2);';
			
			$result = mysqli_query($connect, $consulta);

			$consulta = 'INSERT INTO persona(nombre, apellidos, dni, telefono, email) 
						 VALUES("' . $_POST['nombre'] . '", "' . $_POST['apellidos'] . '", "' . $_POST['dni'] . '", "' . $_POST['telefono'] . '","' . $_POST['email'] . '");';

			$result = mysqli_query($connect, $consulta);

			$result = mysqli_query($connect, "SELECT * FROM persona WHERE id_persona = LAST_INSERT_ID();");
			$row = mysqli_fetch_array($result);

			$consulta = 'INSERT INTO profesor(id_profesor,ingreso,categoria) 
						 VALUES("' . $row['id_persona'] . '",
						 		"' . $_POST['ingreso'] . '",
						 		"' . $_POST['categoria'] . '");';

			$result = mysqli_query($connect, $consulta);

			$result = mysqli_query($connect, "SELECT * FROM profesor WHERE id_profesor = LAST_INSERT_ID();");


			$row = mysqli_fetch_array($result);

			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			$jTableResult['Record'] = $row;
			print json_encode($jTableResult);
			mysqli_close($connect);
	}
	else if($_GET["action"] == "delete"){

				$consulta = 'DELETE pro,us,per
							 FROM profesor AS pro, usuario AS us, persona AS per
							 WHERE pro.id_profesor = "'.$_POST['id_profesor'].'"
							 AND per.id_persona = "'.$_POST['id_profesor'].'"
							 AND us.id_usuario = "'.$_POST['id_profesor'].'"';

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
