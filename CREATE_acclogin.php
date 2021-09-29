<?php
	require ("config.php");

	$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";

	try{
	$db= new PDO($connection_string, $dbuser, $dbpass);
	echo "should have connected";
	$stmt = $db->prepare("CREATE TABLE IF NOT EXISTS
			 `acc.login` (
				`UID` int auto_increment not null,
				`username` varchar(50) not null unique,
				`password` varchar(255) not null,
				`IsAdmin` bit not null default 0,
				PRIMARY KEY (`UID`)
				) CHARACTER SET utf8 COLLATE utf8_general_ci"
			);
	$stmt->execute();
	}
	catch(Exception $e){
	echo $e->getMessage();
	exit("It didn't work");
	}
?>
