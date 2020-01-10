<?php
// When the user clicks the submit form after filling in the email and password to login, check for post data and validate email
if (isset($_POST['email'], $_POST['password']) && filter_var($_POST['email'],  FILTER_VALIDATE_EMAIL))  {
    // Check if the account exists
    $stmt = $pdo->prepare('SELECT * FROM accounts WHERE email = ?');
    $stmt->execute([$_POST['email']]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);
    // If account exists verify password
    if ($account && password_verify($_POST['password'], $account['password'])) {
        // User has logged in, create session data
        session_regenerate_id();
        $_SESSION['account_loggedin'] = TRUE;
        $_SESSION['account_id'] = $account['id'];
        header('Location: index.php?page=myaccount');
    } else {
        $error = 'Incorrect Email/Password!';
    }
}
// If user is logged in
if (isset($_SESSION['account_loggedin'])) {
    // Select all the users transations, this will appear under "My Orders"
    $stmt = $pdo->prepare('SELECT
        p.img AS img,
        p.name AS name,
        p.price AS price,
        t.date AS transaction_date,
        t.quantity AS quantity
        FROM transactions t
        JOIN accounts a ON a.id = t.account_id
        JOIN products p ON p.id = t.product_id
        WHERE t.account_id = ?
        ORDER BY t.date DESC');
    $stmt->execute([$_SESSION['account_id']]);
    $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<?=template_header('My Account')?>



<?php if ($error): ?>
<p class="content-wrapper error"><?=$error?></p>
<?php else: ?>
<div class="myaccount content-wrapper">
    <?php if (!isset($_SESSION['account_loggedin'])): ?>
    <h1>Login</h1>
    <form action="index.php?page=myaccount" method="post">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="email@example.com" required>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Password" required>
        <input type="submit" value="Login">
    </form>
    <?php else: ?>
    <h1>My Account</h1>
    <h2>My Orders</h2>
    
    <table>
        <thead>
            <tr>
                <td colspan="2">Product</td>
                <td class="rhide">Date</td>
                <td class="rhide">Price</td>
                <td>Quantity</td>
                <td>Total</td>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($transactions)): ?>
            <tr>
                <td colspan="5" style="text-align:center;">You have no products added in your Shopping Cart</td>
            </tr>
            <?php else: ?>
            <?php foreach ($transactions as $transaction): ?>
            <tr>
                <td class="img">
                    <img src="imgs/<?=$transaction['img']?>" width="50" height="50" alt="<?=$transaction['name']?>">
                </td>
                <td><?=$transaction['name']?></td>
                <td class="rhide"><?=$transaction['transaction_date']?></td>
                <td class="price rhide">&pound;<?=$transaction['price']?></td>
                <td class="quantity"><?=$transaction['quantity']?></td>
                <td class="price">&pound;<?=$transaction['price'] * $transaction['quantity']?></td>
                
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <?php endif; ?>

    
</div>
<?php endif; ?>

<?=template_footer()?>
