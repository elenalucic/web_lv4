<?php

    function getProducts() {
        include 'db.php'; // Uključivanje datoteke za povezivanje s bazom podataka

        $sql = "SELECT * FROM products";
        $result = mysqli_query($con, $sql);

        $products = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }

        return $products;
    }


function getProductById($con, $id) {
    $stmt = $con->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function addProductToCart($product) {
    $code = $product['code'];
    if(empty($_SESSION["shopping_cart"])) {
        $_SESSION["shopping_cart"] = array();
    }

    if(isset($_SESSION["shopping_cart"][$code])) {
        $_SESSION["shopping_cart"][$code]['quantity']++;
    } else {
        $_SESSION["shopping_cart"][$code] = $product;
        $_SESSION["shopping_cart"][$code]['quantity'] = 1;
    }
}


function removeProductFromCart($code) {
    if(isset($_SESSION["shopping_cart"][$code])) {
        unset($_SESSION["shopping_cart"][$code]);
    }
}



