<?php
session_start();
include('config.php');

// التحقق من صلاحيات الوصول
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'employee') {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // جلب البيانات من النموذج
    $device_name = isset($_POST['device_name']) ? trim($_POST['device_name']) : '';
    $problem_description = isset($_POST['problem_description']) ? trim($_POST['problem_description']) : '';
    $repair_cost = isset($_POST['repair_cost']) ? (float)$_POST['repair_cost'] : 0;

    // التحقق من صحة البيانات
    if (!empty($device_name) && !empty($problem_description) && $repair_cost > 0) {
        try {
            // تحضير استعلام الإدخال
            $query = "INSERT INTO repairs (device_name, problem_description, repair_cost, repair_status) 
                      VALUES (?, ?, ?, 'Pending')";
            $stmt = $con->prepare($query);
            $stmt->bind_param("ssd", $device_name, $problem_description, $repair_cost);
            $stmt->execute();

            // التحقق من نجاح الإدخال
            if ($stmt->affected_rows > 0) {
                $success_message = "تمت إضافة الإصلاح بنجاح.";
            } else {
                $error_message = "حدث خطأ أثناء إضافة الإصلاح.";
            }

            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            $error_message = "خطأ في قاعدة البيانات: " . $e->getMessage();
        }
    } else {
        $error_message = "يرجى ملء جميع الحقول بشكل صحيح.";
    }
}

?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة إصلاح</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            direction: rtl;
            margin: 20px;
            padding: 20px;
        }
        form {
            max-width: 500px;
            margin: auto;
            background-color: #f4f4f4;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        input, textarea, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #28a745;
            color: white;
            border: none;
        }
        .message {
            font-size: 16px;
            margin: 20px 0;
            text-align: center;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h1>إضافة إصلاح جديد</h1>

    <!-- عرض الرسائل -->
    <?php if (isset($success_message)) : ?>
        <div class="message success"><?= $success_message ?></div>
    <?php elseif (isset($error_message)) : ?>
        <div class="message error"><?= $error_message ?></div>
    <?php endif; ?>

    <!-- نموذج إدخال البيانات -->
    <form method="POST" action="">
        <label for="device_name">اسم الجهاز</label>
        <input type="text" id="device_name" name="device_name" required>

        <label for="problem_description">وصف المشكلة</label>
        <textarea id="problem_description" name="problem_description" rows="4" required></textarea>

        <label for="repair_cost">تكلفة الإصلاح</label>
        <input type="number" id="repair_cost" name="repair_cost" step="0.01" required>

        <button type="submit">إضافة</button>
    </form>
</body>
</html>
