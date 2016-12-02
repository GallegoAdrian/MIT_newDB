<?php

require_once('mailer/vendor/autoload.php');
require_once('functions.php');

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
$m->FromName = 'Web Monkey';
$m->addReplyTo('nicofviteri@gmail.com', 'Reply address');

$m->addAddress('francesc.edo.trias@gmail.com', 'Francesc Edo');
$m->addAddress('nicofviteri@gmail.com', 'Nico Figueroa');

$m->addStringAttachment(pdf(1, 'email'), 'pdf.pdf');

$m->Subject = 'YA FUNCIONA 2';
$m->Body = 'Por fin funciona!!!';
$m->AltBody = 'hola!';

if($m->send()){
	echo 'email sent!';
}

