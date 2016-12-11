<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
if(!isset($_SESSION["username"])){
  header("location:../");
}

if($_SESSION["user_type"] == "profesor"){
  header("location:../profesor/");
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
	<title>Alumno</title>
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
    <script src="../scripts/jtable/localization/jquery.jtable.es.js" type="text/javascript"></script>
	<!--JTABLES: end-->	
</head>
<body>

	<?php
	getHeader('../');
	?>
	<div id="general" class="cd-main-content">
		<section class="profile-content" >
			<h1 class="page-header">Tabla de Notas</h1>
			<div id="PeopleTableContainer"></div>
		</section>
	</div>
	<?php
		$connect = connectDB();
		getMenu(1, $connect);
		footer();
	?>
</body>
<script type="text/javascript">
		$(document).ready(function () {

			$('#PeopleTableContainer').jtable({
				messages: spanishMessages,
				title: 'Tabla de tus notas',
				paging: true,
				pageSize: 2,
				sorting: true,
				defaultSorting: 'descripcion ASC',
				actions: {
					listAction: 'actions.php?action=list',
				},
				fields: {
					id_alumno: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
					descripcion: {
						title: 'Descripción',
						width: '40%'
					},
					curso_esc: {
						title: 'Curso escolar',
						width: '20%'
					},
					convoc: {
						title: 'Convocatoria',
						width: '20%'
					},
					nota: {
						title: 'Nota',
						width: '20%'
					}
				}
			});

			//Load person list from server
			$('#PeopleTableContainer').jtable('load');

		});

	</script>
</html>