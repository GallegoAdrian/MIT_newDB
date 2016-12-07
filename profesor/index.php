<?php
header ('Content-type: text/html; charset=utf-8');
session_start();
if(!isset($_SESSION["username"])){
  header("location:../");
}

if($_SESSION["user_type"] == "alumno"){
  header("location:../alumno/");
}

if($_SESSION["user_type"] == "coordinador"){
  header("location:../coordinador/");
}

if($_SESSION["user_type"] == "secretaria"){
  header("location:../secretaria/");
}

require('../functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Profesor</title>
	<meta charset="UTF-8">
	
	<link rel="stylesheet" href="../css/reset.css"> <!-- CSS reset -->
	<link rel="stylesheet" type="text/css" href="../css/menu.css">
    <link href="../css/styleLoginPage.css" rel="stylesheet" type="text/css" type="text/css">
	<link href="../css/styleTableAndMenu.css" rel="stylesheet" type="text/css" >
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="../js/main.js"></script> <!-- Resource jQuery -->
    
	<!--JTABLES: start-->
	<link href="../themes/redmond/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
	<link href="../scripts/jtable/themes/metro/darkgray/jtable.css" rel="stylesheet" type="text/css" />
    <script src="../scripts/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>
    <script src="../scripts/jtable/jquery.jtable.js" type="text/javascript"></script>
	<!--JTABLES: end-->
</head>
<body>
	
	<?php 
	getHeader('../');
	?>
	<main id="general" class="cd-main-content">
		<section class="profile-content" >
			<h1 class="page-header">Tabla de Notas</h1>
			<div id="PeopleTableContainer"></div>
			<?php 
			header ('Content-type: text/html; charset=utf-8');
				$connect = connectDB();
				$result = getAsignaturasP($_SESSION["username"], $connect);
				echo '<h2>Preparadas</h2>';
				foreach ($result as $asignaturas) {
					echo '<div class="asig"><a href="preparadas.php?a='.$asignaturas['codigo'].'">'.$asignaturas['asignatura'].'</a></div>';
				}
				echo '<h2>Impartidas</h2>';
				$result = getAsignaturasI($_SESSION["username"], $connect);
				foreach ($result as $asignaturas) {
					echo '<div class="asig"><a href="impartidas.php?a='.$asignaturas['codigo'].'">'.$asignaturas['asignatura'].'</a></div>';
				}

			?>
		</section>
	</main>
	<?php
	header ('Content-type: text/html; charset=utf-8');
		getMenu(2, $connect);
		footer();
	?>
</body>
</html>