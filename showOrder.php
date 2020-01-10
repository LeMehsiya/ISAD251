<!DOCTYPE html>
<link href="tablestyle.css" rel="stylesheet" type="text/css">
</html>
<?php

		$DATABASE_HOST = 'proj-mysql.uopnet.plymouth.ac.uk';
		$DATABASE_USER = 'ISAD251_SYates';
		$DATABASE_PASS = 'ISAD251_22214108';
		$DATABASE_NAME = 'shoppingcart';
$link = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Attempt select query execution
$sql = "SELECT * FROM accounts,products, transactions";
$sql = "SELECT * FROM transactions, products, accounts ORDER BY transactions.id,account_id,date";
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        
        echo "<table>";
        
            echo "<tr>";
                echo "<th>img</th>";
                echo "<th>Order ID</th>";
                echo "<th>Product</th>";
                echo "<th>Product Name</th>";
                echo "<th>quantity</th>";
                echo "<th>First Name</th>";
                echo "<th>Last Name</th>";
                echo "<th>Date</th>";
                
            echo "</tr>";
        while($row = mysqli_fetch_array($result)){
            echo "<tr>";
                echo "<td>" . $row['img'] . "</td>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['product_id'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";

                echo "<td>" . $row['quantity'] . "</td>";
                echo "<td>" . $row['first_name'] . "</td>";
                echo "<td>" . $row['last_name'] . "</td>";
                echo "<td>" . $row['date'] . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
        mysqli_free_result($result);
    } else{
        echo "No records matching your query were found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
mysqli_close($link);
?> 
