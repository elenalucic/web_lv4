<?php

include('db.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php?page=admin");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    if ($_POST['action'] == "add") {
  
        $name = $_POST['name'];
        $code = $_POST['code'];
        $price = $_POST['price'];
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "imgs/".$image);
        $stmt = $con->prepare("INSERT INTO products (name, code, price, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssds", $name, $code, $price, $image);
        $stmt->execute();
    } elseif ($_POST['action'] == "delete" && isset($_POST['id'])) {

        $id = $_POST['id'];
        $stmt = $con->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}

$products = getProducts($con);
?>

<h1>Administratorska ploča</h1>
<h2>Dodaj novi proizvod</h2>
<form method="post" action="index.php?page=dashboard" enctype="multipart/form-data">
    <input type="hidden" name="action" value="add">
    <label for="name">Naziv:</label>
    <input type="text" name="name" required>
    <label for="code">Kod:</label>
    <input type="text" name="code" required>
    <label for="price">Cijena:</label>
    <input type="number" step="0.01" name="price" required>
    <label for="image">Slika:</label>
    <input type="file" name="image" required>
    <button type="submit">Dodaj</button>
</form>

<h2>Popis proizvoda</h2>
<table>
    <thead>
        <tr>
            <th>Slika</th>
            <th>Naziv</th>
            <th>Kod</th>
            <th>Cijena</th>
            <th>Akcija</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><img src="imgs/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>"></td>
                <td><?php echo $product['name']; ?></td>
                <td><?php echo $product['code']; ?></td>
                <td><?php echo $product['price']; ?> HRK</td>
                <td>
                    <form method="post" action="index.php?page=dashboard">
                        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="action" value="delete">
                        <button type="submit">Ukloni</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
