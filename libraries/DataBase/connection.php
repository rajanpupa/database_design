<?php
	require_once('database_config.php');
	
	$db =mysql_connect($host, $username, $password);
	mysql_select_db($database,$db);//database name, above variable
	if($db==null){
		die("connection failed");
	}
?>
