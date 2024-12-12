<?php
// بدء الجلسة
session_start();

// تضمين ملف الاتصال بقاعدة البيانات
include('config.php');

// التأكد من أن المدير مسجل الدخول
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");  // إعادة التوجيه إلى صفحة تسجيل الدخول إذا لم يكن المدير مسجلاً
    exit();
}

// إضافة موظف جديد
if (isset($_POST['add_employee'])) {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $role = mysqli_real_escape_string($con, $_POST['role']);

    $query = "INSERT INTO employees (username, password, role) VALUES ('$username', '$password', '$role')";
    if (mysqli_query($con, $query)) {
        echo "تم إضافة الموظف بنجاح!";
    } else {
        echo "حدث خطأ أثناء إضافة الموظف!";
    }
}

// استعلام لجلب جميع الموظفين
$query = "SELECT * FROM employees";
$result = mysqli_query($con, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الموظفين</title>
    <link rel="stylesheet" href="style.css"> <!-- ضع رابط ملف CSS المناسب -->
</head>
<body>

<h1>إدارة الموظفين</h1>

<!-- نموذج إضافة موظف جديد -->
<h2>إضافة موظف جديد</h2>
<form method="POST" action="">
    <label for="username">اسم المستخدم:</label>
    <input type="text" name="username" required>
    <label for="password">كلمة المرور:</label>
    <input type="password" name="password" required>
    <label for="role">الدور:</label>
    <select name="role" required>
        <option value="employee">موظف</option>
        <option value="admin">مدير</option>
    </select>
    <button type="submit" name="add_employee">إضافة الموظف</button>
</form>

<!-- جدول عرض الموظفين -->
<h2>قائمة الموظفين</h2>
<table border="1">
    <tr>
        <th>اسم المستخدم</th>
        <th>الدور</th>
        <th>الإجراء</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo $row['username']; ?></td>
        <td><?php echo $row['role']; ?></td>
        <td><a href="delete_employee.php?id=<?php echo $row['id']; ?>">حذف</a></td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
