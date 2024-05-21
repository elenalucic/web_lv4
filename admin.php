<?php
session_start();
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = hash('sha256', $_POST['password']);
    $stmt = $con->prepare("SELECT * FROM admin WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: index.php?page=dashboard");
    } else {
        echo "<p>Neispravni podaci za prijavu!</p>";
    }
}
?>

<h1>Admin prijava</h1>
<form method="post" action="index.php?page=admin">
    <label for="email">Email:</label>
    <input type="email" name="email" required>
    <label for="password">Lozinka:</label>
    <input type="password" name="password" required>
    <button type="submit">Prijava</button>
</form>
