<?php
session_start();
include 'config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] === 'admin') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $employee_id = $_SESSION['user_id'];

    // احضار السعر
    $query_price = "SELECT price FROM products WHERE id = ?";
    $stmt_price = $con->prepare($query_price);
    $stmt_price->bind_param("i", $product_id);
    $stmt_price->execute();
    $price = $stmt_price->get_result()->fetch_assoc()['price'];

    $total_price = $price * $quantity;

    // تسجيل البيع
    $query = "INSERT INTO sales (employee_id, product_id, quantity, total_price) VALUES (?, ?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("iiid", $employee_id, $product_id, $quantity, $total_price);
    $stmt->execute();

    // تحديث المخزون
    $query_update = "UPDATE products SET stock = stock - ? WHERE id = ?";
    $stmt_update = $con->prepare($query_update);
    $stmt_update->bind_param("ii", $quantity, $product_id);
    $stmt_update->execute();

    echo "تم تسجيل البيع بنجاح.";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المبيعات</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>تسجيل المبيعات</h1>
<form method="post">
    <label for="product_id">رقم المنتج:</label>
    <input type="number" name="product_id" required>
    <label for="quantity">الكمية:</label>
    <input type="number" name="quantity" required>
    <button type="submit">تسجيل</button>
</form>
</body>
</html>