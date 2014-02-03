<?php
	
	$dbHost = "localhost";
	$dbUser = "root";
	$dbPass = "";
	$dbname = "bookstore";
	$dbconnect = mysql_connect($dbHost,$dbUser,$dbPass)	or die("Unable to connect to MySQL");
	mysql_select_db($dbname,$dbconnect);
?>
