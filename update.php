<?php


include 'CRUDfunction.php';


$pdo = pdo_connect_mysql();  
$msg = '';
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $desc = isset($_POST['desc']) ? $_POST['desc'] : '';
        $price = isset($_POST['price']) ? $_POST['price'] : '';
        $rrp = isset($_POST['rrp']) ? $_POST['rrp'] : '';
        $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';
        $img = isset($_POST['img']) ? $_POST['img'] : '';
        $date_added = isset($_POST['date']) ? $_POST['date'] : date('Y-m-d H:i:s');
        // Update the record
        $stmt = $pdo->prepare('UPDATE products SET id = ?, `name` = ?, `desc` = ?, price = ?, rrp = ?, quantity = ?, img = ?, date_added = ? WHERE id = ?');
        $stmt->execute([$id, $name, $desc, $price, $rrp, $quantity, $img,  $date_added, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $products = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$products) {
        die ('Products doesn\'t exist with that ID!');
    }
} else {
    die ('No ID specified!');
}
?>
<link href="CRUDstyle.css" rel="stylesheet" type="text/css">


<div class="content update">
	<h2>Update Product #<?=$products['id']?></h2>
    <form action="update.php?id=<?=$products['id']?>" method="post">
        <label for="id">ID</label>
        
        <label for="name">Name</label>
        <input type="text" name="id" placeholder="" value="<?=$products['id']?>" id="id">
        <input type="text" name="name" placeholder="" value="<?=$products['name']?>" id="name">
        <label for="desc">Desc</label>
        <label for="price">Price</label>
        <input type="text" name="desc" placeholder="" value="<?=$products['desc']?>" id="desc">
        <input type="text" name="price" placeholder="" value="<?=$products['price']?>" id="price">
        <label for="rrp">RRP</label>
        <label for="quantity">Quantity</label>
        <input type="text" name="rrp" placeholder="" value="<?=$products['rrp']?>" id="rrp">
        <input type="text" name="quantity" placeholder="" value="<?=$products['quantity']?>" id="quantity">
        <label for="img">IMG</label>
        <label for="date_added">Date Added</label>
        <input type="text" name="img" placeholder="" value="<?=$products['img']?>" id="img">
        <input type="date_added" name="date_added" value="<?=date('Y-m-d\TH:i', strtotime($products['date_added']))?>" id="date_added">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

