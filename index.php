<?php
session_start();
include('db.php');
include_once('functions.php');

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

include('header.php'); // Kreirajte header.php koji sadrži HTML za zaglavlje stranice

if ($page == 'home') {
    include('home.php');
} elseif ($page == 'products') {
    include('products.php');
} elseif ($page == 'product') {
    include('product.php');
} elseif ($page == 'cart') {
    include('cart.php');
} elseif ($page == 'placeorder') {
    include('placeorder.php');
} elseif ($page == 'admin') {
    include('admin.php');
} elseif ($page == 'dashboard') {
    include('dashboard.php');
}

include('footer.php'); // Kreirajte footer.php koji sadrži HTML za podnožje stranice

