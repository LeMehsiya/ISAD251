<?php

if (!function_exists('pdo_connect_mysql')) {
	function pdo_connect_mysql() {
		$DATABASE_HOST = 'proj-mysql.uopnet.plymouth.ac.uk';
		$DATABASE_USER = 'ISAD251_SYates';
		$DATABASE_PASS = 'ISAD251_22214108';
		$DATABASE_NAME = 'shoppingcart';
		try {
			return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
		} catch (PDOException $exception) {
			die ('Failed to connect to database!');
		}
	} 
}


?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>CRUD</title>
		<link href="CRUDstyle.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body>
    <nav class="navtop">
    	<div>
    		<h1>CRUD</h1>
			<a href="index.php"><i class="fas fa-home"></i>Main Page</a>
			<a href="adminhome.php"><i class="fas fa-home"></i>Admin Home</a>
    		<a href="read.php"><i class="fas fa-pen"></i>Products</a>
    	</div>
	</nav>
	