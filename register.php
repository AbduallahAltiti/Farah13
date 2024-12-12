<?php
session_start();
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $password = md5($password); // تأمين كلمة المرور بتشفير MD5
    $role = $_POST['role']; // تحديد إذا كان Admin أو Employee

    // استعلام للتحقق إذا كان اسم المستخدم موجودًا بالفعل
    $check_query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($con, $check_query);
    if (mysqli_num_rows($result) == 0) {
        // إضافة المستخدم إلى قاعدة البيانات
        $insert_query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
        if (mysqli_query($con, $insert_query)) {
            header('Location: login.php');
        } else {
            echo "فشل في إضافة المستخدم!";
        }
    } else {
        echo "اسم المستخدم موجود بالفعل!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>انشاء حساب </title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form method="POST" action="">
    <input type="text" name="username" placeholder="اسم المستخدم" required>
    <input type="password" name="password" placeholder="كلمة المرور" required>
    <select name="role">
        <option value="admin">مدير</option>
        <option value="employee">موظف</option>
    </select>
    <button type="submit">إنشاء الحساب</button>
</form>
</body>
</html>