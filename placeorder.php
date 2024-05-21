<?php
session_start();
if (!empty($_SESSION["shopping_cart"])) {
    // Ovdje možete dodati logiku za spremanje narudžbe u bazu podataka
    unset($_SESSION["shopping_cart"]);
    echo "<p>Hvala na narudžbi!</p>";
} else {
    echo "<p>Vaša košarica je prazna!</p>";
}
?>
