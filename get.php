<?php

	mysql_connect('localhost', 'username', 'password') or die("no connection");
	mysql_select_db('my_database') or die("no db");

	$wind = $_GET['wind'];
	$temp = $_GET['temp'];
	$pressure = $_GET['pressure'];
	$light = $_GET['light'];

	mysql_query("INSERT INTO data VAlUES ('', UNIX_TIMESTAMP(), '$wind', '$temp', '$pressure', '$light')");

	echo "Wind: $wind\n";
	echo "Temp: $temp\n";
	echo "Pressure: $pressure\n";
	echo "Light: $light";

?>