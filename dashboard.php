<?php
// بدء الجلسة للتحقق من الدخول
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php"); // إعادة التوجيه إلى صفحة تسجيل الدخول إذا لم يكن مسجل دخول
    exit();
}

// الاتصال بقاعدة البيانات
include 'config.php';

// استعلام للحصول على إحصائيات عامة
$query = "SELECT COUNT(*) AS total_products FROM products";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
$total_products = $row['total_products'];

// استعلام للحصول على عدد المبيعات الشهرية
$query_sales = "SELECT SUM(total_price) AS monthly_sales FROM sales WHERE MONTH(sale_date) = MONTH(CURRENT_DATE())";
$result_sales = mysqli_query($con, $query_sales);
$row_sales = mysqli_fetch_assoc($result_sales);
$monthly_sales = $row_sales['monthly_sales'];

// استعلام للحصول على عدد الموظفين
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
    <title>لوحة التحكم</title>
    <link rel="stylesheet" href="style.css"> <!-- تأكد من إضافة ملف CSS -->
</head>
<body>
    <div class="container">
        <!-- القائمة الجانبية -->
        <div class="sidebar">
            <h2>لوحة التحكم</h2>
            <ul>
                <li><a href="dashboard.php">الصفحة الرئيسية</a></li>
                <li><a href="products.php">إدارة المنتجات</a></li>
                <li><a href="employees.php">إدارة الموظفين</a></li>
                <li><a href="sales_reports.php">تقارير المبيعات</a></li>
                <li><a href="logout.php">تسجيل الخروج</a></li>
            </ul>
        </div>

        <!-- المحتوى الرئيسي -->
        <div class="main-content">
            <h1>مرحبًا بك في لوحة التحكم</h1>
            <div class="statistics">
                <div class="stat-card">
                    <h3>عدد المنتجات</h3>
                    <p><?php echo $total_products; ?> منتج</p>
                </div>
                <div class="stat-card">
                    <h3>المبيعات الشهرية</h3>
                    <p><?php echo $monthly_sales; ?> ريال</p>
                </div>
                <div class="stat-card">
                    <h3>عدد الموظفين</h3>
                    <p><?php echo $total_employees; ?> موظف</p>
                </div>
            </div>

            <div class="quick-links">
                <h2>روابط سريعة</h2>
                <ul>
                    <li><a href="products.php">إضافة أو تعديل المنتجات</a></li>
                    <li><a href="employees.php">إضافة أو تعديل الموظفين</a></li>
                    <li><a href="sales_reports.php">عرض تقارير المبيعات</a></li>
                </ul>
            </div>
        </div>
    </div>

    
</body>
</html>
