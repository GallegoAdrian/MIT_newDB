<?php
if (isset($_POST)) {
	require_once('mailer/vendor/autoload.php');
	require_once('functions.php');

	$data = json_decode(stripslashes($_POST['data']));

	$m = new PHPMailer;

	$m->isSMTP();
	$m->SMTPAuth = true;
	$m->SMTPDebug = 2;

	$m->Host = 'smtp.gmail.com';
	$m->Username = 'webmonkeypd@gmail.com';
	$m->Password = 'piZzarra1617';
	$m->SMTPSecure = 'ssl';
	$m->Port = 465;

	$m->From = 'webmonkeypd@gmail.com';
	$m->FromName = 'Secretaria MIT';
	
	$conn = connectDB();
	foreach ($data as $alumnos) {
		$m->ClearAllRecipients();
		$m->clearAttachments();
		$row = getMail($conn, $alumnos);
		$m->addAddress($row['email'], $row['nombre'].' '.$row['apellidos']);
		$m->addStringAttachment(pdf($row['id'], 'email'), 'pdf.pdf');

		$m->Subject = 'NOTAS MIT';
		$m->Body = "Buenos dias ".$row['nombre']."!\nEn este correo le adjuntamos un archivo PDF con las notas de las asignaturas. Si tiene cualquier duda contacte con nosotros a través de webmonkeypd@gmail.com.\n Gracias\n\nSecretaria MIT";

		if($m->send()){
			echo 'email sent!';
		}
	}
}

// $m->addReplyTo('nicofviteri@gmail.com', 'Reply address');

// $m->addAddress('nicofviteri@gmail.com', 'Nico Figueroa');



//pdf(1, 'email');
?>