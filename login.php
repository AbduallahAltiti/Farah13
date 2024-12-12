<?php
session_start();
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $password = md5($password); // تأمين كلمة المرور بتشفير MD5

    // استعلام التحقق من المستخدم
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role']; // سواء كان Admin أو Employee

        if ($row['role'] == 'admin') {
            header('Location: admin_dashboard.php');
        } else {
            header('Location: employee_dashboard.php');
        }
    } else {
        $error_message = "بيانات الدخول غير صحيحة!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form method="POST" action="">
    <input type="text" name="username" placeholder="اسم المستخدم" required>
    <input type="password" name="password" placeholder="كلمة المرور" required>
    <button type="submit">تسجيل الدخول</button>
    <?php if (isset($error_message)) echo "<p>$error_message</p>"; ?>
</form>
</body>
</html>