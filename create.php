<?php


include 'CRUDfunction.php';

$pdo = pdo_connect_mysql();

$msg = '';
if (!empty($_POST)) {
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $desc = isset($_POST['desc']) ? $_POST['desc'] : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';
    $rrp = isset($_POST['rrp']) ? $_POST['rrp'] : '';
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';
    $img = isset($_POST['img']) ? $_POST['img'] : '';
    $date_added = isset($_POST['date_added']) ? $_POST['date_added'] : date('Y-m-d H:i:s');  
    $stmt = $pdo->prepare('INSERT INTO products VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$id, $name, $desc, $price, $rrp, $quantity, $img, $date_added]);
    // Output message
    $msg = 'Created Successfully!';
}
?>

<div class="content update">
	<h2>Create Product</h2>
    <form action="create.php" method="post">
        <label for="id">ID</label>
        <label for="name">Name</label>
        <input type="text" name="id" placeholder="26" value="auto" id="id">
        <input type="text" name="name" placeholder="John Doe" id="name">
        <label for="desc">desc</label>
        <label for="price">desc</label>
        <label for="rrp">rrp</label>
        <input type="text" name="desc" placeholder="johndoe@example.com" id="desc">
        <input type="text" name="price" placeholder="2.48" id="price">

        <input type="text" name="rrp" placeholder="20.76" id="rrp">
        <label for="quantity">quantity</label>
        <input type="text" name="quantity" placeholder="40" id="quantity">
        <label for="img">img</label>
        <label for="date_added">date_added</label>
        <input type="text" name="img" placeholder="Photo" id="img">
        <input type="date_added" name="date_added" value="<?=date('Y-m-d\TH:i')?>" id="date_added">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

