
<?php

// Initialize variable for database credentials
$DATABASE_HOST = 'proj-mysql.uopnet.plymouth.ac.uk';
$DATABASE_USER = 'ISAD251_SYates';
$DATABASE_PASS = 'ISAD251_22214108';
$DATABASE_NAME = 'isad251_syates';

//Create database connection
  $dblink = new mysqli($$DATABASE_HOST, $DATABASE_USER , $DATABASE_PASS, $DATABASE_NAME);

//Check connection was successful
  if ($dblink->connect_errno) {
     printf("Failed to connect to database");
     exit();
  }

  $result = $dblink->query("SELECT * FROM transactions LIMIT 25");

//Initialize array variable
  $dbdata = array();

//Fetch into associative array
  while ( $row = $result->fetch_assoc())  {
	$dbdata[]=$row;
  }

//Print array in JSON format
 echo json_encode($dbdata);
?>