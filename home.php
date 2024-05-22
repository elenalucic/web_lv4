<?php
$products = getProducts($con);
?>

<h1>Dobrodošli u našu trgovinu!</h1>
<h2>Novi proizvodi</h2>
<div class="products">
    <?php foreach ($products as $product): ?>
        <div class="product">
            <img src="imgs/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
            <h3><?php echo $product['name']; ?></h3>
            <p>Cijena: <?php echo $product['price']; ?> HRK</p>
            <form method="post" action="index.php?page=cart">
                <input type="hidden" name="code" value="<?php echo $product['code']; ?>">
                <button type="submit">Dodaj u košaricu</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>
