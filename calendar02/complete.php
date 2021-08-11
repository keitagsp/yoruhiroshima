<?php
	$getYm = date('Y-m');
	if(isset($_GET['ym'])){
		$getYm = $_GET['ym'];
	}
	header("Location: ./admin.php?mode=complete&ym=$getYm");
	exit();
?>