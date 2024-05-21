<?php
include 'functions.php'; // Uključivanje datoteke s funkcijama
echo '<link rel="stylesheet" type="text/css" href="style.css">';

$products = getProducts();
?>

<h1>Proizvodi</h1>
<div class="products">
    <?php foreach ($products as $product): ?>
        <div class="product">
            <img src="images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
            <h3><?php echo $product['name']; ?></h3>
            <p>Cijena: <?php echo $product['price']; ?> HRK</p>
            <a href="index.php?page=product&id=<?php echo $product['id']; ?>">Detalji</a>
        </div>
    <?php endforeach; ?>
</div>
