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
			<h1 class="page-header">Tabla Grados</h1>
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
			pageSize: 5,
			sorting: true,
			//ALERTA!!!!! CAMBIAR ESTO PARA QUE FUNCIONE!
			defaultSorting: 'nombre ASC',
			actions: {
				listAction:   'actionsGrados.php?action=list',
				createAction: 'actionsGrados.php?action=create',
				updateAction: 'actionsGrados.php?action=update',
				deleteAction: 'actionsGrados.php?action=delete'
			},
			fields: {
				id_grado: {
					key: true,
					list: false
				},
				alumnos: {
					title: '',
					width: '1%',
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
										title: 'Grados '+staffData.record.nombre,
										sorting: true,
										defaultSorting: 'apellidos ASC',
										paging: true,
										pageSize: 3,
										messages: spanishMessages,
										actions: {
											listAction: 'actionsUnGrado.php?action=list&gradoid=' + staffData.record.id_grado,
											deleteAction: 'actionsUnGrado.php?action=delete&gradoid=' + staffData.record.id_grado,
											updateAction: 'actionsUnGrado.php?action=update&gradoid=' + staffData.record.id_grado,
											createAction: 'actionsUnGrado.php?action=create&gradoid=' + staffData.record.id_grado,
											},
										fields: {
											id_grd_alu: {
												key: true,
												list: false,
												edit: false,
												create: false
											},
											id_alumno:{
												options: 'actionsUnGrado.php?action=getAlumnoId',
												list: false,
												edit: false,
												create:true
											},
											nombre: {
												title: 'Nombre',
												width: '20%',
												list: true,
												edit: true,
												create: false
											},
											apellidos: {
												title: 'Apellidos',
												width: '30%',
												list: true,
												edit: true,
												create: false
											},
											curso_esc: {
												title: 'Curso',
												width: '10%',
												list: true,
												edit: true,
												create: false
											},
											baixa: {
												title: 'Baixa',
												width: '10%',
												list: true,
												edit: true,
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
					width: '30%',
					edit: true,
					create: true
				},
				duracion: {
					title: 'Duración',
					width: '5%',
					edit: true,
					create:true
				},
				creditos: {
					title: 'Creditos',
					width: '5%',
					edit: true,
					create:true
				},
				tipo_docencia: {
					title: 'Tipo de Docencia',
					width: '7%',
					edit: true,
					create:true
				},
				nota_corte_pau: {
					title: 'Nota de Corte',
					width: '7%',
					edit: true,
					create:true
				},
				precio_cre: {
					title: 'Precio',
					width: '5%',
					edit: true,
					create:true
				}
			}
		});

		//Load person list from server
		$('#PeopleTableContainer').jtable('load');

		});

</script>
</html>