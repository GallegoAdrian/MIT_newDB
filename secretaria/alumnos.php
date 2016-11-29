<?php
header ('Content-type: text/html; charset=utf-8');
session_start();
if(!isset($_SESSION["username"])){
  header("location:../");
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
			<h1 class="page-header">Tabla Alumnos</h1>
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
			pageSize: 5,
			sorting: true,
			//ALERTA!!!!! CAMBIAR ESTO PARA QUE FUNCIONE!
			defaultSorting: 'nombre ASC',
			selecting: true, //Enable selecting
            multiselect: true, //Allow multiple selecting
            selectingCheckboxes: true, //Show checkboxes on first column
            //selectOnRowClick: false, //Enable this to only select using checkboxes
			actions: {
				listAction:   'actionsAlumnos.php?action=list',
				updateAction: 'actionsAlumnos.php?action=update',
				createAction: 'actionsAlumnos.php?action=create',
				deleteAction: 'actionsAlumnos.php?action=delete'
			},
			fields: {
				id_alumno: {
					key: true,
					list: false
				},
				nombre: {
					title: 'Nombre',
					width: '20%',
					edit: true
				},
				apellidos: {
					title: 'Apellidos',
					width: '20%',
					edit: true
				},
				dni: {
					title: 'DNI',
					width: '8%',
					edit: true
				},
				direccion: {
					title: 'Direccion',
					width: '20%',
					edit: true
				},
				telefono: {
					title: 'Teléfono',
					width: '9%',
					edit: true
				},
				email: {
					title: 'e-mail',
					width: '15%',
					edit: true
				}
			}
		});

		//Load person list from server
		$('#PeopleTableContainer').jtable('load');

		});
</script>
</html>