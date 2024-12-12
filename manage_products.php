<?php
session_start();
include 'config.php';

// تحقق من صلاحية الوصول
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// جلب المنتجات
$result = $con->query("SELECT * FROM products");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete'])) {
        $id = $_POST['product_id'];
        $con->query("DELETE FROM products WHERE id='$id'");
        header("Location: manage_products.php");
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المنتجات</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="navbar">
        <h3>Farah Phone</h3>
        <div>
            <a href="admin_dashboard.php">الرئيسية</a>
            <a href="record_sales.php">تسجيل المبيعات</a>
            <a href="record_withdrawal.php">تسجيل السحب</a>
            <a href="manage_products.php">إدارة المنتجات</a>
            <a href="logout.php">تسجيل الخروج</a>
        </div>
    </div>

    <div class="container mt-5">
        <h1>إدارة المنتجات</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>رقم المنتج</th>
                    <th>اسم المنتج</th>
                    <th>السعر</th>
                    <th>الكمية</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['price'] ?></td>
                    <td><?= $row['quantity'] ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                            <button type="submit" name="delete" class="btn btn-danger btn-sm">حذف</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
