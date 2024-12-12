<?php
session_start();
include('config.php');

// التحقق من صلاحية الموظف
if ($_SESSION['role'] != 'employee') {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// استعلام للحصول على إجمالي مبيعات الموظف
$query_sales = "SELECT SUM(total_price) AS total_sales FROM sales WHERE employee_id = '$user_id'";
$result_sales = mysqli_query($con, $query_sales);

// التحقق من أن الاستعلام قد رجع نتائج صحيحة
if ($result_sales) {
    $row_sales = mysqli_fetch_assoc($result_sales);
    $employee_sales = isset($row_sales['total_sales']) ? $row_sales['total_sales'] : 0; // تعيين قيمة افتراضية إذا كانت null
} else {
    $employee_sales = 0; // تعيين قيمة صفرية إذا فشل الاستعلام
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم الموظف</title>
    <link rel="stylesheet" href="employee_dashboard.css"> <!-- رابط لملف CSS مخصص -->
</head>
<body>

    <h1>مرحباً بك في لوحة تحكم الموظف</h1>

    <div class="stats">
        <h2>إحصائياتك الشهرية</h2>
        <ul>
            <li><strong>إجمالي المبيعات الشهرية:</strong> <?php echo $employee_sales ? $employee_sales : '0'; ?> دينار</li>
        </ul>
    </div>

    <div class="actions">
        <h2>الإجراءات المتاحة</h2>
        <ul>
            <li><a href="record_sales.php">تسجيل مبيعات</a></li>
            <li><a href="record_withdrawal.php">تسجيل سحب</a></li>
            <li><a href="repair_device.php">تسجيل إصلاح جهاز</a></li>
            <li><a href="apply_discount.php">تطبيق خصم</a></li>
        </ul>
    </div>

    <div class="logout">
        <a href="logout.php">تسجيل الخروج</a>
    </div>

</body>
</html>
