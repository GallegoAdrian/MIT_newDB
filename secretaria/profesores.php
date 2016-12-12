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
	<!--link href="../scripts/jtable/themes/lightcolor/blue/jtable.css" rel="stylesheet" type="text/css" /-->
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
			<h1 class="page-header">Tabla Profesores</h1>
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
			//title: 'Tabla de Alumnos',
			paging: true,
			pageSize: 10,
			sorting: true,
			//ALERTA!!!!! CAMBIAR ESTO PARA QUE FUNCIONE!
			defaultSorting: 'nombre ASC',
			selecting: false, //Enable selecting
            multiselect: false, //Allow multiple selecting
            selectingCheckboxes: false, //Show checkboxes on first column
            //selectOnRowClick: false, //Enable this to only select using checkboxes
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
				asignatura: {
					title: '',
					width: '1%',
					sorting: false,
					edit: false,
					create: false,
					display: function (staffData) {
						console.log(staffData);
						//Create an image that will be used to open child table
						var $img = $('<img class="child-opener-image jtable-command-button" src="../images/list_metro.png" title="Ver las asignaturas" />');

						//Open child table when user clicks the image
						$img.click(function () {
								$('#PeopleTableContainer').jtable('openChildTable',
								//$('.jtable-child-row').slideUp(),
								$img.closest('tr'),

								{
									title:  'Profesor/a: '+ staffData.record.apellidos +', '+staffData.record.nombre,
									sorting: true,
									defaultSorting: 'codigo ASC',
									paging: true,
									pageSize: 3,
									messages: spanishMessages,
									actions: {
										listAction: 'actionsUnProfesor.php?action=list&profesorid=' + staffData.record.id_profesor,
										createAction: 'actionsUnProfesor.php?action=create&profesorid=' + staffData.record.id_profesor,
										updateAction: 'actionsUnProfesor.php?action=update&profesorid=' + staffData.record.id_profesor,
										deleteAction: 'actionsUnProfesor.php?action=delete&profesorid=' + staffData.record.id_profesor,
										},
									fields: {
										id_imparte: {
											key: true,
											create: false,
											edit: false,
											list: false
										},
										id_asignatura: {
											title: 'Asignaturas',
											width: '99%',
											options: 'actionsUnProfesor.php?action=getAssigId',
											list:true,
											edit: true,
											create:true,
										},
										codigo: {
											title: 'Codigo',
											width: '1%',
											visibility:'hidden',
											list: true,
											edit: false,
											create: false
										}
									}
								}, function (data) { //opened handler
								data.childTable.jtable('load');
							});
						});
						//Return image to show on the person row
						return $img;
					}
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
					create:true
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
					create: true
				},
				email: {
					title: 'e-mail',
					width: '15%',
					edit: true,
					create: true,
					inputClass: 'validate[required,custom[email]]'
				},
				ingreso: {
					title: 'Ingreso',
					width: '7%',
					type:'date',
					edit: true,
					create: true
				},
				categoria: {
					title: 'Categoria',
					width: '10%',
					edit: true,
					create: true
				},
				id_rol: {
					title: 'Rol',
					//width: '20%',
					edit: false,
					create: false,
					list: false
				},
				username: {
					title: 'Username',
					width: '10%',
					edit: false,
					create: true,
					list: false
				},
				password: {
					title: 'password',
					width: '10%',
					edit: false,
					create: true,
					list:false
				},
				activo: {
					title: 'Activo',
					//width: '2%',
					edit: true,
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