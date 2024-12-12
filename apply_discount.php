<?php
session_start();
include('config.php');

if ($_SESSION['role'] != 'employee') {
    header('Location: login.php');
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = mysqli_real_escape_string($con, $_POST['product_id']);
    $discount_percentage = mysqli_real_escape_string($con, $_POST['discount_percentage']);

    // تحديث سعر المنتج
    $query = "UPDATE products 
              SET price = price - (price * $discount_percentage / 100) 
              WHERE id = '$product_id'";
    if (mysqli_query($con, $query)) {
        $message = "تم تطبيق الخصم بنجاح!";
    } else {
        $message = "حدث خطأ أثناء تطبيق الخصم: " . mysqli_error($con);
    }
}

// جلب المنتجات لعرضها في القائمة
$query_products = "SELECT id, name FROM products";
$result_products = mysqli_query($con, $query_products);
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تطبيق خصم</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>تطبيق خصم</h1>
    <form method="POST" action="">
        <label for="product_id">اختر المنتج:</label>
        <select id="product_id" name="product_id" required>
            <?php while ($row = mysqli_fetch_assoc($result_products)): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label for="discount_percentage">نسبة الخصم (%):</label>
        <input type="number" id="discount_percentage" name="discount_percentage" min="0" max="100" required><br><br>

        <button type="submit">تطبيق الخصم</button>
    </form>
    <p><?php echo $message; ?></p>
</body>
</html>
