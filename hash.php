<?php
	if(isset($_POST)){
		echo $result = sha1($_POST['string']);
	}

?>