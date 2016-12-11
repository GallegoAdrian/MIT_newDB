<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
if(!isset($_SESSION["username"])){
  header("location:../");
}

if($_SESSION["user_type"] == "profesor"){
  header("location:../profesor/");
}

if($_SESSION["user_type"] == "coordinador"){
  header("location:../coordinador/");
}

if($_SESSION["user_type"] == "secretaria"){
  header("location:../secretaria/");
}

require('../functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Alumno</title>
	<meta charset="UTF-8">
	
	<link rel="stylesheet" href="../css/reset.css"> <!-- CSS reset -->
	<link rel="stylesheet" type="text/css" href="../css/menu.css">
    <link href="../css/styleLoginPage.css" rel="stylesheet" type="text/css" type="text/css">
	<link href="../css/styleTableAndMenu.css" rel="stylesheet" type="text/css" >
	<link href="../css/styleHome.css" rel="stylesheet" type="text/css" >

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="../js/main.js"></script> <!-- Resource jQuery -->
    
	<!--JTABLES: start-->
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
			<h1 class="page-header">Inicio</h1>
				<div class="comming-events">
					<a href="https://www.raspberrypi.org/" target="_blank"><img src="../images/raspberry.jpg" height="100%" width="100%">
					<h2>Evento Dia 19 de Diciembre 2016</h2>
					<span>Taller con Raspberry Pi trae a la familia y amigos !</span>
					<p>Onhanger freehold bromargyrite yperite ravel paniscus anis 
						weathering disemplane wirr 
						raconid presubjection skeenyie themsel resolute 
						viewable birn springworm bafflingness songstress bromethylene. 
						</p></a>
				</div>
				<div class="recommend-courses">
					<a href="https://www.edx.org/school/mitx" target="_blank"><img src="../images/learn.jpg" height="185px" width="100%">
					<h2>MITx</h2>
					<span>Free online courses from Massachusetts Institute of Technology</span></a>
				</div>
				<div class="magazine">
					<a href="https://www.technologyreview.com" target="_blank"><img src="../images/review.jpg" height="145px" width="100%"></a>
				</div>
				<div class="facebook">
					<a href="https://www.facebook.com/MITnews" target="_blank"><img src="../images/facebook.png" height="145px" width="100%"></a>
				</div>
				<div class="twitter">
					<a href="https://twitter.com/MIT" target="_blank"><img src="../images/twitter.png" height="145px" width="100%"></a>
				</div>
				<div class="youtube">
					<a href="https://www.youtube.com/mit" target="_blank"><img src="../images/youtube2.png" height="145px" width="100%"></a>
				</div>
		</section>
	</div>
	<?php
	header ('Content-type: text/html; charset=utf-8');
		$connect = connectDB();
		getMenu(1, $connect);
		footer('../');
	?>
</body>
</html>