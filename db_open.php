<?php

	$dbuser = "nicolemackin"; // Connect Login
	$dbpass = "yA754387"; // Password for ug.csit.carleton.ca

	$resLink = mysql_connect('localhost',$dbuser,$dbpass);
	if(!$resLink) 
	{
		echo "Connect failed<br/>"; 
		exit();
	}
	
	$resSelect = mysql_select_db($dbuser,$resLink);
	if(!$resSelect) 
	{
		echo "Select failed<br/>";
		exit();
	}

?>