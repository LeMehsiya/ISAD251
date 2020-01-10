<?php

include 'CRUDfunction.php';

$pdo = pdo_connect_mysql();
$msg = '';

if (isset($_GET['id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $products = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$products) {
        die ('Product doesn\'t exist with that ID!');
    }
    // Confirmation prompt
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            //Yes = delete record
            $stmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'You have deleted the product!';
        } else {
            header('Location: read.php');
            exit;
        }
    }
} else {
    die ('No ID specified!');
}
?>
<link href="CRUDstyle.css" rel="stylesheet" type="text/css">


<div class="content delete">
	<h2>Delete product #<?=$products['id']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete product #<?=$products['id']?>?</p>
    <div class="yesno">
        <a href="delete.php?id=<?=$products['id']?>&confirm=yes">Yes</a>
        <a href="delete.php?id=<?=$products['id']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

