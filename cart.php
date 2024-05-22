<?php

include_once 'db.php'; // Uključivanje baze podataka
include_once 'functions.php'; // Uključivanje datoteke s funkcijama

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['code'])) {
    $product = getProductById($con, $_POST['code']);
    if ($product) {
        addProductToCart($product);
    } else {
        echo "Proizvod nije pronađen.";
    }
}
?>

<h1>Košarica</h1>
<?php if (!empty($_SESSION["shopping_cart"])): ?>
    <table>
        <thead>
            <tr>
                <th>Slika</th>
                <th>Naziv</th>
                <th>Količina</th>
                <th>Cijena</th>
                <th>Ukupno</th>
                <th>Akcija</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION["shopping_cart"] as $code => $product): ?>
                <tr>
                    <td><img src="imgs/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>"></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $product['quantity']; ?></td>
                    <td><?php echo $product['price']; ?> HRK</td>
                    <td><?php echo $product['price'] * $product['quantity']; ?> HRK</td>
                    <td>
                        <form method="post" action="index.php?page=cart&action=remove&code=<?php echo $code; ?>">
                            <button type="submit">Ukloni</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <p>Ukupno: <?php echo array_sum(array_map(function($product) { return $product['price'] * $product['quantity']; }, $_SESSION["shopping_cart"])); ?> HRK</p>
    <a href="index.php?page=placeorder">Naruči</a>
<?php else: ?>
    <p>Vaša košarica je prazna!</p>
<?php endif; ?>
