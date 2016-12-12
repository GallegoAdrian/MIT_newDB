<?php

session_start();
require('../functions.php');
//if(isset($_SESSION['type']) && $_SESSION['type'] === 2){

try
{
	$connect = connectDB();

	if($_GET["action"] == "list"){

			$consulta =	"SELECT mat.id_asignatura,mat.curso_esc, mat.convoc, mat.nota, mat.baixa,mat.id_matricula 
						FROM matricula AS mat, asignatura AS asi, alumno AS alu
						WHERE  mat.id_asignatura = asi.id_asignatura  
						AND mat.id_alumno = alu.id_alumno
						and alu.id_alumno = '{$_GET['alumnoid']}'";

			$result = mysqli_query($connect, $consulta);

			$recordCount = mysqli_num_rows($result);

			$consulta =	"SELECT mat.id_asignatura,mat.curso_esc, mat.convoc, mat.nota, mat.baixa,mat.id_matricula 
						FROM matricula AS mat, asignatura AS asi, alumno AS alu
						WHERE  mat.id_asignatura = asi.id_asignatura  
						AND mat.id_alumno = alu.id_alumno
						and alu.id_alumno = '{$_GET['alumnoid']}'
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

	}else if($_GET["action"] == "getAssigId"){

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
	else if($_GET["action"] == "update"){

			$consulta = 'UPDATE matricula AS mat, asignatura AS asi 
						SET mat.id_asignatura = "'.$_POST['id_asignatura'].'",mat.curso_esc = "'.$_POST['curso_esc'].'", mat.convoc = "'.$_POST['convoc'].'",mat.nota = "'.$_POST['nota'].'",mat.baixa = "'.$_POST['baixa'].'" 
						WHERE asi.id_asignatura = mat.id_asignatura AND mat.id_matricula = "'.$_POST['id_matricula'].'" AND mat.id_alumno = "' . $_GET['alumnoid'] . '"';

			$result = mysqli_query($connect, $consulta);
			//imprimirlos
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			print json_encode($jTableResult);
			mysqli_close($connect);

	}else if($_GET["action"] == "delete"){

			$consulta = 'DELETE FROM matricula WHERE matricula.id_matricula = "'.$_POST['id_matricula'].'"';

			$result = mysqli_query($connect, $consulta);
			//imprimirlos
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			print json_encode($jTableResult);
			mysqli_close($connect);
	}
	else if($_GET["action"] == "create"){

			$consulta = "SELECT mat.id_alumno FROM matricula AS mat WHERE mat.id_asignatura = '".$_POST["id_asignatura"]."' AND mat.id_alumno = '".$_GET["alumnoid"]."'";

			$result = mysqli_query($connect, $consulta);
			$numRow = mysqli_num_rows($result);

			if($numRow == 0){

			$consulta = "INSERT INTO matricula(id_alumno,id_asignatura,curso_esc,convoc,nota,baixa) 
						 VALUES('" . $_GET["alumnoid"] . "','" . $_POST["id_asignatura"] . "','" . $_POST["curso_esc"] . "','" . $_POST["convoc"] . "','" . $_POST["nota"] . "','0' );";

			$result = mysqli_query($connect, $consulta);

			$result = mysqli_query($connect, "SELECT * FROM matricula WHERE id_matricula  = LAST_INSERT_ID();");
			$row = mysqli_fetch_array($result);

			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			$jTableResult['Record'] = $row;
			print json_encode($jTableResult);
			mysqli_close($connect);

		}else{
					$jTableResult = array();
					$jTableResult['Result'] = "ERROR";
					$jTableResult['Message'] = 'Este alumno ya está siendo evaluado de esta asignatura.';
					print json_encode($jTableResult);
					mysqli_close($connect);
			}
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