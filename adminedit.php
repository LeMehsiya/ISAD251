<?php
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'sort3';
$num_products_on_each_page = 4;
$current_page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
// Select products ordered by the date added
if ($sort == 'sort1') {
    // sort1 = Alphabetical A-Z
    $stmt = $pdo->prepare('SELECT * FROM products ORDER BY name ASC LIMIT ?,?');
} elseif ($sort == 'sort2') {
    // sort2 = Alphabetical Z-A
    $stmt = $pdo->prepare('SELECT * FROM products ORDER BY name DESC LIMIT ?,?');
} elseif ($sort == 'sort3') {
    // sort3 = Newest
    $stmt = $pdo->prepare('SELECT * FROM products ORDER BY date_added DESC LIMIT ?,?');
} elseif ($sort == 'sort4') {
    // sort4 = Oldest
    $stmt = $pdo->prepare('SELECT * FROM products ORDER BY date_added ASC LIMIT ?,?');
} else {
    $stmt = $pdo->prepare('SELECT * FROM products LIMIT ?,?');
}
$stmt->bindValue(1, ($current_page - 1) * $num_products_on_each_page, PDO::PARAM_INT);
$stmt->bindValue(2, $num_products_on_each_page, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of products
$total_products = $pdo->query('SELECT * FROM products')->rowCount();
?>

<?=template_header('Products')?>

<div class="products content-wrapper">
    <h1>Products</h1>
    <div class="products-header">
        <p><?=$total_products?> Products</p>
        <label class="sortby">
            Sort by
            <select>
                <option value="sort1"<?=($sort == 'sort1' ? ' selected' : '')?>>Alphabetical A-Z</option>
                <option value="sort2"<?=($sort == 'sort2' ? ' selected' : '')?>>Alphabetical Z-A</option>
                <option value="sort3"<?=($sort == 'sort3' ? ' selected' : '')?>>Newest</option>
                <option value="sort4"<?=($sort == 'sort4' ? ' selected' : '')?>>Oldest</option>
            </select>
        </label>
    </div>
    <div class="products-wrapper">
        <?php foreach ($products as $product): ?>
        <a href="index.php?page=product&id=<?=$product['id']?>" class="product">
            <img src="imgs/<?=$product['img']?>" width="200" height="200" alt="<?=$product['name']?>">
            <span class="name"><?=$product['name']?></span>
            <span class="price">
                &pound;<?=$product['price']?>
                <?php if ($product['rrp'] > 0): ?>
                <span class="rrp">&pound;<?=$product['rrp']?></span>
                <?php endif; ?>
            </span>
        </a>
        <?php endforeach; ?>
    </div>
    <div class="buttons">
        <?php if ($current_page > 1): ?>
        <a href="index.php?page=products&p=<?=$current_page-1?>">Prev</a>
        <?php endif; ?>
        <?php if ($total_products > ($current_page * $num_products_on_each_page) - $num_products_on_each_page + count($products)): ?>
        <a href="index.php?page=products&p=<?=$current_page+1?>">Next</a>
        <?php endif; ?>
    </div>
</div>

<?=template_footer()?>
