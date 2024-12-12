<?php
session_start();
include('config.php');

if ($_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

// استعلام للحصول على إحصائيات
$query_products = "SELECT COUNT(*) AS total_products FROM products";
$result_products = mysqli_query($con, $query_products);
$row_products = mysqli_fetch_assoc($result_products);
$total_products = $row_products['total_products'];

$query_sales = "SELECT SUM(total_price) AS monthly_sales FROM sales WHERE MONTH(sale_date) = MONTH(CURRENT_DATE())";
$result_sales = mysqli_query($con, $query_sales);
$row_sales = mysqli_fetch_assoc($result_sales);
$monthly_sales = $row_sales['monthly_sales'];

$query_employees = "SELECT COUNT(*) AS total_employees FROM employees";
$result_employees = mysqli_query($con, $query_employees);
$row_employees = mysqli_fetch_assoc($result_employees);
$total_employees = $row_employees['total_employees'];
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المسؤول</title>
    <link rel="stylesheet" href="admin_dashboard.css"> <!-- رابط لملف CSS مخصص -->
</head>
<body>

    <h1>مرحباً بك في لوحة تحكم المسؤول</h1>

    <div class="stats">
        <h2>إحصائيات عامة</h2>
        <ul>
            <li><strong>عدد المنتجات:</strong> <?php echo $total_products; ?></li>
            <li><strong>إجمالي المبيعات الشهرية:</strong> <?php echo $monthly_sales ? $monthly_sales : '0'; ?> ريال</li>
            <li><strong>عدد الموظفين:</strong> <?php echo $total_employees; ?></li>
        </ul>
    </div>

    <div class="actions">
        <h2>الإجراءات المتاحة</h2>
        <ul>
            <li><a href="add_product.php">إضافة منتج</a></li>
            <li><a href="manage_products.php">إدارة المنتجات</a></li>
            <li><a href="manage_employees.php">إدارة الموظفين</a></li>
            <li><a href="view_sales.php">عرض المبيعات</a></li>
            <li><a href="view_inventory.php">عرض المخزون</a></li>
        </ul>
    </div>

    <div class="logout">
        <a href="logout.php">تسجيل الخروج</a>
    </div>
    

</body>
</html>
