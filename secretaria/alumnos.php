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
			<h1 class="page-header">Tabla Alumnos</h1>
			<div id="PeopleTableContainer"></div>
			<button id="mail" onclick="sendMail(dni);">Enviar Mail</button>
			<!-- <button id="pdf" onclick="downloadPDF(dni);">Descargar PDF</button> -->
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
var dni = [];
	$(document).ready(function () {

		$('#PeopleTableContainer').jtable({
			messages: spanishMessages,
			//title: 'Tabla de Alumnos',
			paging: true,
			pageSize: 5,
			sorting: true,
			//ALERTA!!!!! CAMBIAR ESTO PARA QUE FUNCIONE!
			defaultSorting: 'nombre ASC',
			selecting: true, //Enable selecting
            multiselect: true, //Allow multiple selecting
            selectingCheckboxes: true, //Show checkboxes on first column
            selectOnRowClick: false, //Enable this to only select using checkboxes
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
										title: 'Asignaturas '+staffData.record.nombre+' '+staffData.record.apellidos,
										sorting: true,
										messages: spanishMessages,
										defaultSorting: 'id_asignatura ASC',
										paging: true,
										pageSize: 3,
										actions: {
											listAction: 'actionsUnAlumno.php?action=list&alumnoid=' + staffData.record.id_alumno,
											createAction: 'actionsUnAlumno.php?action=create&alumnoid=' + staffData.record.id_alumno,
											updateAction: 'actionsUnAlumno.php?action=update&alumnoid=' + staffData.record.id_alumno,
											deleteAction: 'actionsUnAlumno.php?action=delete&alumnoid=' + staffData.record.id_alumno,
											},
										fields: {
											id_alumno: {
												defaultValue:staffData.record.id_alumno,
												create: false,
												edit: false,
												list: false,
											},
											id_asignatura: {
												title: 'Descripcion',
												width: '20%',
												options: 'actionsUnAlumno.php?action=getAssigId',
												list:true,
												edit: true,
												create:true,
											},
											curso_esc: {
												title: 'Curso',
												width: '20%',
												list:true,
												edit: true,
												create:true
											},
											convoc: {
												title: 'Convocatoria',
												width: '0%',
												list:true,
												edit: true,
												create:true
											},
											nota: {
												title: 'Nota',
												width: '0%',
												list:true,
												edit: true,
												create:true
											},
											baixa: {
												title: 'Baixa',
												width: '0%',
												list:true,
												edit: true,
                    							options: { '0': 'NO', '1': 'SI' },
												create:false
											},
											id_matricula: {
												key: true,
												title: 'id_matricula',
												width: '0%',
												visibility:'hidden',
												list:false,
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
				pdf: {
					title: '',
					width: '1%',
					sorting: false,
					edit: false,
					create: false,
					display: function (staffData) {
						//console.log(staffData);
					//Create an image that will be used to open child table
							var $img = $('<img class="child-opener-image" src="../images/pdf.png" title="Ver PDF" />');
							$img.click(function () {
								$.ajax({
							        type: "POST",
							        url: "../hash.php",
							        data: {string : staffData.record.dni}, 
							        cache: false,
							        success: function(response){
							    		window.open('../pdf.php?hash='+response,'_blank');
							        }
							    });
							});
						return $img;
					}
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
					title: 'Dirección',
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

		var jsonString = JSON.stringify(dni);
		console.log(jsonString);
	   $.ajax({
	        type: "POST",
	        url: "../mail.php",
	        data: {data : jsonString}, 
	        cache: false,
	        success: function(response){
	            alert('sent!');
	            console.log(response);
	        }
	    });
	}
	function downloadPDF(dni){
		alert('not implemented');
		// console.log('download PDF');
		// var jsonString = JSON.stringify(dni);
		//    $.ajax({
		//         type: "POST",
		//         url: "../mail.php",
		//         data: {data : jsonString}, 
		//         cache: false,
		//         success: function(response){
		//             alert('sent!');
		//         }
		//     });
	}
</script>
</html>