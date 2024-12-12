<?php
session_start();
include 'config.php';

// تحقق من صلاحية الوصول
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// جلب المخزون
$result = $con->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض المخزون</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="navbar">
        <h3>Farah Phone</h3>
        <div>
            <a href="admin_dashboard.php">الرئيسية</a>
            <a href="view_inventory.php">عرض المخزون</a>
            <a href="manage_products.php">إدارة المنتجات</a>
            <a href="logout.php">تسجيل الخروج</a>
        </div>
    </div>

    <div class="container mt-5">
        <h1>عرض المخزون</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>رقم المنتج</th>
                    <th>اسم المنتج</th>
                    <th>السعر</th>
                    <th>الكمية</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['price'] ?></td>
                    <td><?= $row['quantity'] ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
