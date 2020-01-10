<?php
if (isset($_POST['firstname'], $_POST['lastname'], $_POST['address'], $_POST['city'], $_POST['county'], $_POST['postcode'], $_SESSION['cart'])) {
    $account_id = null;
    if (isset($_SESSION['account_loggedin'])) {
        // Update the users details (if changed)
        $stmt = $pdo->prepare('UPDATE accounts SET first_name = ?, last_name = ?, address = ?, city = ?, county = ?, postcode = ? WHERE id = ?');
        $stmt->execute([$_POST['firstname'], $_POST['lastname'], $_POST['address'], $_POST['city'], $_POST['county'], $_POST['postcode'], $_SESSION['account_id']]);
        $account_id = $_SESSION['account_id'];
    } else if (isset($_POST['email'], $_POST['password']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $stmt = $pdo->prepare('SELECT id FROM accounts WHERE email = ?');
        $stmt->execute([$_POST['email']]);
        $account = $stmt->fetch(PDO::FETCH_ASSOC);
    	if ($account) {
    		$error = 'Account already exists with this email, please login instead.';
    	} else {
            // Email doesnt exist, create new account
            $stmt = $pdo->prepare('INSERT INTO accounts VALUES (?,?,?,?,?,?,?,?,?)');
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt->execute([NULL, $_POST['email'], $password, $_POST['firstname'], $_POST['lastname'], $_POST['address'], $_POST['city'], $_POST['county'], $_POST['postcode']]);
            $account_id = $pdo->lastInsertId();
        }
    } else {
        $error = 'Please fill out the form correctly!';
    }
    if ($account_id != null) {
        foreach ($_SESSION['cart'] as $product_id => $product_qty) {
            $stmt = $pdo->prepare('INSERT INTO transactions VALUES (?,?,?,?,?,NOW())');
            // Unqiue transaction id, if you were to intagrate paypal etc you will be given a unique string ID
            $transaction_id = strtoupper(uniqid('SC' . $account_id . $product_id));
            $stmt->execute([NULL, $transaction_id, $product_id, $account_id, $product_qty]);
        }
        // Remove products in cart, no longer needed as the order has been processed
        unset($_SESSION['cart']);
        session_regenerate_id();
        // Log the user in with the details provided
        $_SESSION['account_loggedin'] = TRUE;
        $_SESSION['account_id'] = $account_id;
    }
} else {
    $error = 'Please fill out the form!';
}
?>

<?=template_header('Place Order')?>

<?php if ($error): ?>
<p class="content-wrapper error"><?=$error?></p>
<?php else: ?>
<div class="placeorder content-wrapper">
    <h1>Your Order Has Been Placed</h1>
    <p>Thank you for ordering with us, we'll contact you by email with your order details.</p>
</div>
<?php endif; ?>

<?=template_footer()?>
