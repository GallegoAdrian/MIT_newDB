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
	<link rel="icon" type="image/png" href="../images/mit.ico"/>
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
    <script src="../scripts/jtable/localization/jquery.jtable.es.js" type="text/javascript"></script>
	<!--JTABLES: end-->
</head>
<body>
	
	<?php 
	getHeader('../');
	?>
	<main id="general" class="cd-main-content">
		<section class="profile-content" >
			<h1 class="page-header">Tabla Coordinadores</h1>
			<div id="PeopleTableContainer"></div>
		</section>
	</main>
	<?php
	header ('Content-type: text/html; charset=utf-8');
		$connect = connectDB();
		getMenu(4, $connect);
		footer('../');
	?>
</body>
<script type="text/javascript">
	$(document).ready(function () {
		
		$('#PeopleTableContainer').jtable({
			messages: spanishMessages,
			//title: 'Tabla de Profesores',
			paging: true,
			pageSize: 15,
			sorting: true,
			//ALERTA!!!!! CAMBIAR ESTO PARA QUE FUNCIONE!
			defaultSorting: 'nombre ASC',
			selecting: true, //Enable selecting
            multiselect: false, //Allow multiple selecting
            selectingCheckboxes: false, //Show checkboxes on first column
            //selectOnRowClick: false, //Enable this to only select using checkboxes
			actions: {
				listAction:   'actionsCoordinadores.php?action=list',
				updateAction: 'actionsCoordinadores.php?action=update',
				createAction: 'actionsCoordinadores.php?action=create',
				deleteAction: 'actionsCoordinadores.php?action=delete'
			},
			fields: {
				id_coordinador: {
					key: true,
					list: false
				},
				nombre: {
					title: 'Nombre',
					width: '15%',
					edit: true,
					create:true
				},
				apellidos: {
					title: 'Apellidos',
					width: '20%',
					edit: false,
					create:true,
					list:true
				},
				dni: {
					title: 'DNI',
					width: '5%',
					edit: true,
					create:true
				},
				telefono: {
					title: 'Teléfono',
					width: '5%',
					edit: false,
					create:true,
					list:false
				},
				email: {
					title: 'e-mail',
					width: '15%',
					edit: false,
					create:true,
					list:false,
					inputClass: 'validate[required,custom[email]]'
				},
				dpto: {
					title: 'Dpto',
					width: '5%',
					edit: true,
					create:true
				},
				id_asignatura: {
					title: 'Codigo',
					width: '5%',
					list:true,
					edit: true,
					create:true,
					options: { '1': 'DGBD', '2': 'FBD','3': 'FP', '4': 'HI', '5': 'PC' }
				},
				id_rol: {
					title: 'Rol',
					width: '20%',
					edit: false,
					create:false,
					list: false
				},
				username: {
					title: 'Usuario',
					width: '20%',
					edit: false,
					create:true,
					list:false
				},
				password: {
					title: 'Password',
					width: '20%',
					list: false,
					edit: false,
					create:true
				},
				activo: {
					title: 'Activo',
					width: '20%',
					edit: false,
					create: true,
					list: false,
					type: 'checkbox',
                    values: { '0': 'NO', '1': 'SI' },
                    defaultValue: '1'
				}
			}
		});

		//Load person list from server
		$('#PeopleTableContainer').jtable('load');

		});
	</script>
</html>