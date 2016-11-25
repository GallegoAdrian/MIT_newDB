<?php

require('functions.php');

session_start();

$connect = connectDB();

if(isset($_POST["username"]) && isset($_POST["pass"])){

  $username = mysqli_real_escape_string($connect, $_POST["username"]);
  $pass = mysqli_real_escape_string($connect, $_POST["pass"]);

  $consultaUsuarioSql  = "SELECT * FROM usuario WHERE username='$username' AND password='$pass' AND activo=1";
  $resultUsuario = mysqli_query($connect, $consultaUsuarioSql);
  $numRowUsuario = mysqli_num_rows($resultUsuario);
  
  if ($numRowUsuario == "1") 
  {
	 $dataUsuario = mysqli_fetch_array($resultUsuario);
	 $rolUsuario = $dataUsuario["id_rol"];
	 if($rolUsuario == 1)
	 {
		$_SESSION["username"] = $dataUsuario["username"];
		$_SESSION["type"] = "location:alumno.php";
		echo "1";
	 }
	 else if($rolUsuario == 2)
	 {
		$_SESSION["username"] = $dataUsuario["username"];
		$_SESSION["type"] = "location:profesor.php";
		echo "2";
	 }
	 else if($rolUsuario == 3)
	 {
		$_SESSION["username"] = $dataUsuario["username"];
		$_SESSION["type"] = "location:coordinador.php";
		echo "3";
	 }
	 else if($dataUsuario["id_rol"]  == 4)
	 {
		 echo "Secretaria";
	 }
	 else 
	 {
		 echo "Tipo de usuario no dado de alta en el sistema";
	 }
  }
} 
?>
