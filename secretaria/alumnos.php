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
			<button id="mail" onclick="sendMail(dni);">Enviar Mail</button>
			<button id="pdf" onclick="downloadPDF(dni);">Descargar PDF</button>
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
	var dni = [];
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
				}
			},
			selectionChanged: function () {
                //Get all selected rows
                var $selectedRows = $('#PeopleTableContainer').jtable('selectedRows');
                $('#SelectedRowList').empty();
                if ($selectedRows.length > 0) {
                    //Show selected rows
                    //console.log($selectedRows);
                    dni = [];
                    $selectedRows.each(function () {
                        var record = $(this).data('record');
                        dni.push(record.dni);
                        // delete dni[0];
                    });
                } else {
                	dni = [];
                    //No rows selected
                    $('#SelectedRowList').append('No row selected! Select rows to see here...');
                }
            }
		});
		//Load person list from server
		$('#PeopleTableContainer').jtable('load');
		});
	function sendMail(dni){
		console.log('send mail');
		var jsonString = JSON.stringify(dni);
		   $.ajax({
		        type: "POST",
		        url: "../mail.php",
		        data: {data : jsonString}, 
		        cache: false,
		        success: function(response){
		            alert('sent!');
		        }
		    });
	}
	function downloadPDF(dni){
		console.log('download PDF');
		var jsonString = JSON.stringify(dni);
		   $.ajax({
		        type: "POST",
		        url: "../mail.php",
		        data: {data : jsonString}, 
		        cache: false,
		        success: function(response){
		            alert('sent!');
		        }
		    });
	}

</script>
</html>