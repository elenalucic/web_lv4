<?php
// db.php
$con = mysqli_connect("localhost", "root", "", "shoppingcart");
if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    die();
}

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>
