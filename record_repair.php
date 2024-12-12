<?php
session_start();
include 'config.php';

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $device = $_POST['device'];
    $issue = $_POST['issue'];
    $cost = $_POST['cost'];
    $employee_id = $_SESSION['user_id'];

    $query = "INSERT INTO repairs (device, issue, cost, employee_id) VALUES (?, ?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ssdi", $device, $issue, $cost, $employee_id);
    $stmt->execute();

    echo "تم تسجيل عملية الإصلاح بنجاح.";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الصيانة</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>تسجيل إصلاح الأجهزة</h1>
<form method="post">
    <label for="device">الجهاز:</label>
    <input type="text" name="device" required>
    <label for="issue">المشكلة:</label>
    <input type="text" name="issue" required>
    <label for="cost">التكلفة:</label>
    <input type="number" name="cost" step="0.01" required>
    <button type="submit">تسجيل</button>
</form>
</body>
</html>