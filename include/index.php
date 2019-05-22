<?php
	session_start();
	require('./php_files/DbUtils.php');
	$dbUtils = new DbUtils();
	$data = $dbUtils->getHospitals(9, 8, 5);
?>