<?php
session_start();
$DATABASE_HOST = 'proj-mysql.uopnet.plymouth.ac.uk';
$DATABASE_USER = 'ISAD251_SYates';
$DATABASE_PASS = 'ISAD251_22214108';
$DATABASE_NAME = 'shoppingcart';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}
//Check submitted data + isset() will check if the data exists.
if ( !isset($_POST['username'], $_POST['password']) ) {
	die ('Please fill both the username and password field!');
}
if ($stmt = $con->prepare('SELECT id, password FROM adminaccounts WHERE username = ?')) {
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
}
$stmt->store_result();
if ($stmt->num_rows > 0) {
	$stmt->bind_result($id, $password);
	$stmt->fetch();
	if (password_verify($_POST['password'], $password)) {
		// Verification success! User has loggedin!
		session_regenerate_id();
		$_SESSION['loggedin'] = TRUE;
		$_SESSION['name'] = $_POST['username'];
		$_SESSION['id'] = $id;
        header('Location: adminhome.php');
    } else {
		echo 'Incorrect password!';
	}
} else {
	echo 'Incorrect username!';
}
$stmt->close();
?>