<?php
if(isset($_POST)){
	require_once('functions.php');
	$data = json_decode(stripslashes($_POST['data']));
	
	$conn = connectDB();
	foreach ($data as $alumnos) {
		$result = select($conn, 'id_persona as id', 'persona', 'dni = "'.$alumnos.'" LIMIT 1');
		$row = mysqli_fetch_array($result);
		pdf($row['id'], 'download');
	}

}

