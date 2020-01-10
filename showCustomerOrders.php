<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		
        <link href="tablestyle.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    </head>
    


</html>
<?php

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'shoppingcart';
$link = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Attempt select query execution
$sql = "SELECT * FROM accounts, transactions";
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        
        echo "<table>";
        
            echo "<tr>";
                echo "<th>Account ID</th>";
                echo "<th>First Name</th>";
                echo "<th>Last Name</th>";
                echo "<th>Order ID</th>";
                echo "<th>quantity</th>";
                echo "<th>Date</th>";
                
            echo "</tr>";
        while($row = mysqli_fetch_array($result)){
            echo "<tr>";
                echo "<td>" . $row['account_id'] . "</td>";
                echo "<td>" . $row['first_name'] . "</td>";
                echo "<td>" . $row['last_name'] . "</td>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['quantity'] . "</td>";
                echo "<td>" . $row['date'] . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
        mysqli_free_result($result);
    } else{
        echo "No records matching your query were found.";
    } 
}
?> 