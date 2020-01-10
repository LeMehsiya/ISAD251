<?php
function pdo_connect_mysql() {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'shoppingcart';
    try {
    	return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
    	die ('Failed to connect to database!');
    }
}
function template_header($title) {
// Get the amount of items in the shopping cart
$num_items_in_cart = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;



echo <<<EOT
<!DOCTYPE html>



<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,minimum-scale=1">
        <title>$title</title>
        
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body>
        <header>
            <div class="content-wrapper">
                <h1>ChinaTown Tea</h1>
                <nav>
                    <a href="index.php">Home</a>
                    <a href="index.php?page=products">Products</a>
                    <a href="index.php?page=myaccount">My Account</a>
                    <a href="index.php?page=adminindex">My Admin</a>
                </nav>
                <div class="link-icons">
                    <div class="search">
						<i class="fas fa-search"></i>
						<input type="text" placeholder="Search...">
					</div>
                    <a href="index.php?page=cart">
						<i class="fas fa-shopping-cart"></i>
						<span>$num_items_in_cart</span>
					</a>
					<a class="responsive-toggle" href="#">
						<i class="fas fa-bars"></i>
					</a>
                </div>
            </div>
        </header>
        <main>
EOT;
}
// Template footer
function template_footer() {
echo <<<EOT
        </main>
        <footer>
            <div class="content-wrapper">
            </div>
        </footer>
        <script src="script.js"></script>
    </body>
</html>
EOT;
}
?>
