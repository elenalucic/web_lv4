<?php
echo '<link rel="stylesheet" type="text/css" href="style.css">';

if (isset($_GET['id'])) {
    $product = getProductById($con, $_GET['id']);
    if ($product):
?>

<h1><?php echo $product['name']; ?></h1>
<div class="product">
    <img src="images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
</div>
<p><?php echo $product['price']; ?> HRK</p>


<form method="post" action="index.php?page=cart">
    <input type="hidden" name="code" value="<?php echo $product['code']; ?>">
    <label for="quantity">Količina:</label>
    <input type="number" name="quantity" value="1" min="1" max="10">
    <button type="submit">Dodaj u košaricu</button>
</form>

<?php
    else:
        echo "<p>Proizvod nije pronađen!</p>";
    endif;
} else {
    echo "<p>ID proizvoda nije postavljen!</p>";
}
?>
