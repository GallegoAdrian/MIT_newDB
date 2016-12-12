<?php
$data = $_GET['data'];
// $codigo = $_GET['data'];

$notas = explode(",", $data);
$concat = "";

for ($i=0; $i < count($notas) ; $i++) { 
	//echo gettype($notas[2]);
	if(gettype($notas[2]) === "string" && $i===2){
		$concat.=$notas[$i]."\n";
	}else if($i%3===2 && $notas[$i] !== "nota"){
		$concat.= " "."\n";
	}else if($notas[$i] === ""){
		$concat.=$notas[$i];
	}else{
		$concat.=$notas[$i].",";
	}
}

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=notas.csv");
header("Pragma: no-cache");
header("Expires: 0");
print "$concat";
?>