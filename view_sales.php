<?php
include('config.php');
session_start();

// تأكد أن المستخدم قام بتسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// جلب البيانات من جدول المبيعات
$query = "SELECT * FROM sales";
$result = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض المبيعات</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            direction: rtl;
            text-align: right;
        }
        .card {
            margin-bottom: 20px;
        }
        .navbar {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Farah Phone</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">الرئيسية</a></li>
                    <li class="nav-item"><a class="nav-link active" href="view_sales.php">عرض المبيعات</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_products.php">إدارة المنتجات</a></li>
                    <li class="nav-item"><a class="nav-link" href="view_inventory.php">عرض المخزون</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">تسجيل الخروج</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h3 class="text-center">عرض المبيعات</h3>
        <div class="row">
            <?php
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // التحقق من القيم المفقودة أو الفارغة
                    $productName = !empty($row['product_name']) ? htmlspecialchars($row['product_name']) : 'غير محدد';
                    $quantity = !empty($row['quantity']) ? htmlspecialchars($row['quantity']) : 'غير متوفرة';
                    $total = isset($row['total']) ? htmlspecialchars($row['total']) : 'غير متوفر';
                    $saleDate = isset($row['sale_date']) ? htmlspecialchars($row['sale_date']) : 'غير محدد';

                    echo '<div class="col-md-3">';
                    echo '<div class="card">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">اسم المنتج: ' . $productName . '</h5>';
                    echo '<p class="card-text">الكمية: ' . $quantity . '</p>';
                    echo '<p class="card-text">الإجمالي: ' . $total . '</p>';
                    echo '<p class="card-text">التاريخ: ' . $saleDate . '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p class="text-center">لا توجد مبيعات مسجلة</p>';
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
