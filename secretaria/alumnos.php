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
			//title: 'Tabla de Alumnos',
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
					width: '15%',
					edit: true,
					create: true
				},
				apellidos: {
					title: 'Apellidos',
					width: '20%',
					edit: true,
					create:true
				},
				dni: {
					title: 'DNI',
					width: '5%',
					edit: true,
					create: true
				},
				telefono: {
					title: 'Teléfono',
					width: '5%',
					edit: true,
					create: true
				},
				email: {
					title: 'e-mail',
					width: '15%',
					edit: true,
					create: true,
					inputClass: 'validate[required,custom[email]]'
				},
				direccion: {
					title: 'Direccion',
					width: '15%',
					edit: true,
					create: true
				},
				id_rol: {
					title: 'Rol',
					width: '5%',
					edit: false,
					create:false,
					list:false
				},
				username: {
					title: 'Usuario',
					//width: '7%',
					edit: true,
					create: true,
					list: false
				},
				password: {
					title: 'Password',
					//width: '9%',
					edit: true,
					create: true,
					list: false
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
				},
				alumnos: {
					title: '',
					width: '3%',
					sorting: false,
					edit: false,
					create: false,
					display: function (staffData) {

					//Create an image that will be used to open child table
							var $img = $('<img class="child-opener-image" src="../images/list_metro.png" title="Ver las asignaturas" />');
							//Open child table when user clicks the image
							$img.click(function () {
									$('#PeopleTableContainer').jtable('openChildTable',
									$img.closest('tr'),
									{
										title: staffData.record.nombre + ' - Matriculado en:',
										sorting: true,
										defaultSorting: 'nombre ASC',
										paging: true,
										pageSize: 3,
										actions: {
											listAction: 'actionsUnAlumno.php?action=list&alumnoid=' + staffData.record.id_alumno,
											// deleteAction: 'actionsUnGrado.php?action=delete&gradoid=' + staffData.record.id_grado,
											// updateAction: 'actionsUnGrado.php?action=update&gradoid=' + staffData.record.id_grado,
											// createAction: 'actionsUnGrado.php?action=create&gradoid=' + staffData.record.id_grado,
											},
										fields: {
											id_alumno: {
												key: true,
												list:false,
												edit: false,
												create:false
											},
											descripcion: {
												title: 'Descripcion',
												width: '20%',
												list:true,
												edit: true,
												create:false
											},
											curso_esc: {
												title: 'Curso esoclar',
												width: '20%',
												list:true,
												edit: true,
												create:false
											},
											convoc: {
												title: 'Convocatoria',
												width: '20%',
												list:true,
												edit: true,
												create:false
											},
											nota: {
												title: 'Nota',
												width: '20%',
												list:true,
												edit: true,
												create:false
											},
											baixa: {
												title: 'Baixa',
												width: '20%',
												list:true,
												edit: true,
												create:false
											},
										}
									}, function (data) { //opened handler
									data.childTable.jtable('load');
								});
							});
							//Return image to show on the person row
							return $img;
						}
					},
			}
		});

		//Load person list from server
		$('#PeopleTableContainer').jtable('load');

		});
</script>
</html>