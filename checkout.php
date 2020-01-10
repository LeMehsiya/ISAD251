<?php
$firstname = '';
$lastname = '';
$address = '';
$city = '';
$county = '';
$postcode = '';
// Check if user is logged in
if (isset($_SESSION['account_loggedin'])) {
    $stmt = $pdo->prepare('SELECT * FROM accounts WHERE id = ?');
    $stmt->execute([$_SESSION['account_id']]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);
    // Update the variables so the user doesn't need to fill out their details again
    $firstname = $account['first_name'];
    $lastname = $account['last_name'];
    $address = $account['address'];
    $city = $account['city'];
    $county = $account['county'];
    $postcode = $account['postcode'];
}
?>

<?=template_header('Checkout')?>

<div class="checkout content-wrapper">
    <h1>Checkout</h1>
    <?php if (!isset($_SESSION['account_loggedin'])): ?>
    <p>Do You already have an account? <a href="index.php?page=myaccount">Log In</a></p>
    <?php endif; ?>
    <form action="index.php?page=placeorder" method="post">
        <?php if (!isset($_SESSION['account_loggedin'])): ?>
        <h2>Account Details</h2>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="hey@example.com" required>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Password" required>
        <?php endif; ?>
        <h2>Order Details</h2>
        <div class="row1">
            <label for="firstname">First Name</label>
            <input type="text" value="<?=$firstname?>" name="firstname" id="firstname" placeholder="Simon" required>
        </div>
        <div class="row2">
            <label for="lastname">Last Name</label>
            <input type="text" value="<?=$lastname?>" name="lastname" id="lastname" placeholder="Yates" required>
        </div>
        <label for="address">Address</label>
        <input type="text" value="<?=$address?>" name="address" id="address" placeholder="10 Downing Street" required>
        <label for="city">City</label>
        <input type="text" value="<?=$city?>" name="city" id="city" placeholder="Plymouth" required>
        <div class="row1">
            <label for="county">county</label>
            <input type="text" value="<?=$county?>" name="county" id="county" placeholder="Devon" required>
        </div>
        <div class="row2">
            <label for="postcode">postcode</label>
            <input type="text" value="<?=$postcode?>" name="postcode" id="postcode" placeholder="PL3 8GF" required>
        </div>
        <input type="submit" value="Place Order">
    </form>
</div>

<?=template_footer()?>
