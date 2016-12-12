<?php
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
$connect = connectDB();
$asignatura = getAsignatura($_GET['a'], $connect);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Impartidas</title>
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
			<h1 class="page-header">Asignatura impartiendo: <?=$asignatura['descripcion']?></h1>
			<div id="PeopleTableContainer"></div>
		</section>
	</div>
	<?php
		getMenu(2, $connect);
		echo $_SESSION['type'];
		footer('../');
	?>
</body>
<script type="text/javascript">
	$(document).ready(function () {
		var materia = '<?=$asignatura['codigo']?>';
		
		$('#PeopleTableContainer').jtable({
			messages: spanishMessages,
			title: 'Tabla de Alumnos',
			paging: true,
			pageSize: 10,
			sorting: true,
			//ALERTA!!!!! CAMBIAR ESTO PARA QUE FUNCIONE!
			defaultSorting: 'nombre ASC',
			actions: {
				listAction: 'actions.php?action=list&materia='+materia,
				updateAction: 'actions.php?action=update&materia='+materia
			},
			fields: {
				id_alumno: {
					key: true,
					list: false
				},
				nombre: {
					title: 'Nombre',
					width: '20%',
					edit: false
				},
				apellidos: {
					title: 'Apellido',
					width: '20%',
					edit: false
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