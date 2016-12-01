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
				ingreso: {
					title: 'Ingreso',
					width: '20%',
					type:'date',
					edit: true,
					create:true
				},
				categoria: {
					title: 'Categoria',
					width: '20%',
					edit: true,
					create:true
				},
				dni: {
					title: 'DNI',
					width: '20%',
					edit: true,
					create:true
				},
				nombre: {
					title: 'Nombre',
					width: '20%',
					edit: true,
					create:true
				},
				apellidos: {
					title: 'Apellidos',
					width: '20%',
					edit: false,
					create:true
				},
				telefono: {
					title: 'Telefono',
					width: '20%',
					edit: false,
					create:true
				},
				email: {
					title: 'email',
					width: '20%',
					edit: false,
					create:true
				},
				id_rol: {
					title: 'Rol',
					width: '20%',
					edit: false,
					create:false,
					list:false
				},
				username: {
					title: 'Username',
					width: '20%',
					edit: false,
					create:true
				},
				activo: {
					title: 'Activo',
					width: '20%',
					edit: false,
					create: false,
					list:false
				},
				password: {
					title: 'password',
					width: '20%',
					edit: false,
					create: true,
					list:false
				},
				asignatura: {
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
										title: 'Asignaturas '+staffData.record.nombre+' '+staffData.record.apellidos,
										sorting: true,
										defaultSorting: 'codigo ASC',
										paging: true,
										pageSize: 3,
										actions: {
											listAction: 'actionsUnProfesor.php?action=list&profesorid=' + staffData.record.id_profesor,
											// deleteAction: '/accionescursos.php?action=delete&PersonaID=' + staffData.record.PersonaID,
											updateAction: 'actionsUnProfesor.php?action=update&profesorid=' + staffData.record.id_profesor,
											// createAction: '/accionescursos.php?action=create&PersonaID=' + staffData.record.PersonaID,
											},
										fields: {
											id_profesor: {
												key: true,
												create: false,
												edit: false,
												list: false
											},
											id_asignatura: {
												title: 'Asignatura',
												width: '100%',
												list:true,
												edit: true,
												create:true,
												options: { '1': 'DISEÑO Y GESTION DE BASES DE DATOS', 
														   '2': 'FUNDAMENTOS DE LAS BASES DE DATOS',
														   '3': 'FUNDAMENTOS DE LA PROGRAMACION', 
														   '4': 'HISTORIA DE LA INFORMATICA', 
														   '5': 'PROGRAMACION CONCURRENTE' }
											},
											codigo: {
												title: 'Codigo',
												width: '0%',
												visibility:'hidden',
												list:true,
												edit: false,
												create:false
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
			}
		});

		//Load person list from server
		$('#PeopleTableContainer').jtable('load');

		});
	</script>
</html>