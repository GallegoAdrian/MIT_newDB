<?php

session_start();
require('../functions.php');
//if(isset($_SESSION['type']) && $_SESSION['type'] === 2){

try
{
	$connect = connectDB();

	if($_GET["action"] == "list"){

			$consulta =	"SELECT us.id_rol,us.password, us.username, us.activo, per.nombre,per.apellidos, per.dni, per.telefono, per.email, coor.id_coordinador, coor.dpto, coor.id_asignatura,asignatura.codigo 
						FROM usuario AS us, persona AS per, coordinador AS coor, asignatura 
						WHERE us.id_usuario = per.id_persona AND per.id_persona = coor.id_coordinador AND asignatura.id_asignatura = coor.id_asignatura AND us.id_rol = '3'";

			$result = mysqli_query($connect, $consulta);
			$recordCount = mysqli_num_rows($result);

			$consulta = "SELECT us.id_rol,us.password,us.username,us.activo,per.nombre,per.apellidos, per.dni, per.telefono, per.email, coor.id_coordinador, coor.dpto, coor.id_asignatura,asignatura.codigo 
						FROM usuario AS us, persona AS per, coordinador AS coor, asignatura 
						WHERE us.id_usuario = per.id_persona AND per.id_persona = coor.id_coordinador AND asignatura.id_asignatura = coor.id_asignatura AND us.id_rol = '3' ORDER BY " . $_GET["jtSorting"] . " LIMIT " . $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"] . ";";

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
						 SET coor.id_coordinador = "'.$_POST['id_coordinador'].'", coor.id_asignatura = "'.$_POST['id_asignatura'].'",
						 per.nombre = "'.$_POST['nombre'].'",per.apellidos = "'.$_POST['apellidos'].'",per.dni = "'.$_POST['dni'].'", coor.dpto = "'.$_POST['dpto'].'"
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


			$consulta = 'INSERT INTO usuario(password, username, activo, id_rol) 
						 VALUES("' . $_POST['password'] . '","' . $_POST['username'] . '",1,3);';
			
			$result = mysqli_query($connect, $consulta);

			$consulta = 'INSERT INTO persona(nombre, apellidos, dni, telefono, email) 
						 VALUES("' . $_POST['nombre'] . '", "' . $_POST['apellidos'] . '", "' . $_POST['dni'] . '", "' . $_POST['telefono'] . '","' . $_POST['email'] . '");';

			$result = mysqli_query($connect, $consulta);

			$result = mysqli_query($connect, "SELECT * FROM persona WHERE id_persona = LAST_INSERT_ID();");
			$row = mysqli_fetch_array($result);

			$consulta = 'INSERT INTO coordinador(id_coordinador, id_asignatura,dpto) 
						 VALUES("' . $row['id_persona'] . '","' . $_POST['id_asignatura'] . '", "' . $_POST['dpto'] . '");';

			$result2 = mysqli_query($connect, $consulta);

			$result = mysqli_query($connect, "SELECT * FROM coordinador WHERE id_coordinador = LAST_INSERT_ID();");


			$row = mysqli_fetch_array($result);

			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			$jTableResult['Record'] = $row;
			print json_encode($jTableResult);
			mysqli_close($connect);

	}else if($_GET["action"] == "delete"){

			$consulta = 'DELETE cor,us,per 
						 FROM coordinador AS cor, usuario AS us, persona AS per 
						 WHERE cor.id_coordinador = "'.$_POST['id_coordinador'].'" AND per.id_persona = "'.$_POST['id_coordinador'].'" AND us.id_usuario = "'.$_POST['id_coordinador'].'"';

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
