<?php



include 'CRUDfunction.php';  


// Connect to MySQL database
    $pdo =  pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;
$stmt = $pdo->prepare('SELECT * FROM products ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of product, this is so we can determine whether there should be a next and previous button
$num_products = $pdo->query('SELECT COUNT(*) FROM products')->fetchColumn();
?>

<div class="content read">
	<h2>Read Product</h2>
	<a href="create.php" class="create-products">Create Product</a>
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>Name</td>
                <td>Desc</td>
                <td>Price</td>
                <td>RRP</td>
                <td>Quantity</td>
                <td>IMG</td>
                <td>Date Added</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $products): ?>
            <tr>
                <td><?=$products['id']?></td>
                <td><?=$products['name']?></td>
                <td><?=$products['desc']?></td>
                <td><?=$products['price']?></td>
                <td><?=$products['rrp']?></td>
                <td><?=$products['quantity']?></td>
                <td><?=$products['img']?></td>
                <td><?=$products['date_added']?></td>
                <td class="actions">
                    <a href="update.php?id=<?=$products['id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?id=<?=$products['id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_products): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

