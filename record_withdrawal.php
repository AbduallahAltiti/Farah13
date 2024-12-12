<?php
session_start();
include 'config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $description = $_POST['description'];

    $query = "INSERT INTO withdrawals (amount, description) VALUES (?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ds", $amount, $description);
    $stmt->execute();

    echo "تم تسجيل السحب بنجاح.";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>السحب</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>تسجيل السحب</h1>
<form method="post">
    <label for="amount">المبلغ:</label>
    <input type="number" name="amount" step="0.01" required>
    <label for="description">الوصف:</label>
    <input type="text" name="description" required>
    <button type="submit">تسجيل</button>
</form>
</body>
</html>