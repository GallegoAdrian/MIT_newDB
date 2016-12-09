<?php
//if(isset($_POST)){
	require_once('functions.php');
	$data = $_GET['hash'];
	// $data = array('13490884O');
	$conn = connectDB();
	// $result = select($conn, 'id_persona as id', 'persona', 'dni = "'.$data.'" LIMIT 1');
	$result = select($conn, 'id_persona as id, dni', 'persona' );
	foreach ($result as $row) {
		if ($data === sha1($row['dni'])) {
			pdf($row['id'], 'view');
			break;
		}
	}
//}

