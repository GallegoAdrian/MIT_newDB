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
	<div id="general" class="cd-main-content">
		<section class="profile-content" >
			<h1 class="page-header">Tabla Asignaturas</h1>
			<div id="PeopleTableContainer"></div>
		</section>
	</div>
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
			defaultSorting: 'descripcion ASC',
			actions: {
				listAction:   'actionsAsignaturas.php?action=list',
				updateAction: 'actionsAsignaturas.php?action=update',
				createAction: 'actionsAsignaturas.php?action=create',
				deleteAction: 'actionsAsignaturas.php?action=delete'
			},
			fields: {
				id_asignatura: {
					key: true,
					list: false,
					create: true
				},
				codigo: {
					title: 'Codigo',
					width: '20%',
					edit: true,
					create: true
				},
				descripcion: {
					title: 'Descripción',
					width: '20%',
					edit: true,
					create: true
				},
				excel: {
					title: '',
					width: '0.1%',
					sorting: false,
					edit: false,
					create: false,
					display: function (staffData) {
						var $img = $('<img class="child-opener-image" src="../images/csv2.png" title="Descargar CSV" />');
							$img.click(function () {
								$.ajax({
									type: "POST",
									url: "dataToExportCSV.php",
									data: { asignaturaID: staffData.record.id_asignatura,
											codigo: staffData.record.codigo
											},
									cache: false,
									success:function(data) {
									//console.log(data);
									window.open('downloadCSV.php?data='+data);
									}
								});
							});
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