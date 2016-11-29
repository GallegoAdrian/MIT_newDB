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

if($_SESSION["user_type"] == "profesor"){
  header("location:../profesor/");
}

require('../functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Secretaria</title>
	<meta charset="UTF-8">
	
	<link rel="stylesheet" href="../css/reset.css"> <!-- CSS reset -->
	<link rel="stylesheet" type="text/css" href="../css/menu.css">
    <link href="../css/styleLoginPage.css" rel="stylesheet" type="text/css" type="text/css">
	<link href="../css/styleTableAndMenu.css" rel="stylesheet" type="text/css" >
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="../js/main.js"></script> <!-- Resource jQuery -->
    
	<!--JTABLES: start-->
	<script src="../scripts/jquery-1.6.4.min.js"></script>
	<link href="../themes/redmond/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
	<link href="../scripts/jtable/themes/metro/blue/jtable.css" rel="stylesheet" type="text/css" />
	<!--link href="../scripts/jtable/themes/lightcolor/blue/jtable.css" rel="stylesheet" type="text/css" /-->
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
			<h1 class="page-header">Tabla Profesores</h1>
			<div id="PeopleTableContainer"></div>
		</section>
	</main>
	<?php
	header ('Content-type: text/html; charset=utf-8');
		$connect = connectDB();
		getMenu(4, $connect);
		footer();
	?>
</body>
<script type="text/javascript">
	$(document).ready(function () {
		
		$('#PeopleTableContainer').jtable({
			title: 'Tabla de Alumnos',
			paging: true,
			pageSize: 3,
			sorting: true,
			//ALERTA!!!!! CAMBIAR ESTO PARA QUE FUNCIONE!
			defaultSorting: 'nombre ASC',
			actions: {
				listAction:   'actionsProfesores.php?action=list',
				updateAction: 'actionsProfesores.php?action=update',
				createAction: 'actionsProfesores.php?action=create',
				deleteAction: 'actionsProfesores.php?action=delete'
			},
			fields: {
				id_profesor: {
					key: true,
					list: false
				},
				nombre: {
					title: 'Nombre',
					width: '20%',
					edit: false
				},
				categoria: {
					title: 'Categoria',
					width: '20%',
					edit: false
				},
				ingreso: {
					title: 'Fecha Ingreso',
					width: '20%',
					type:'date',
					edit: false
				},
				dni: {
					title: 'dni',
					width: '20%',
					edit: false
				},
				id_rol: {
					title: 'Rol',
					width: '20%',
					edit: false
				}
			}
		});

		//Load person list from server
		$('#PeopleTableContainer').jtable('load');

		});
	</script>
</html>