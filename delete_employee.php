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

// التحقق من وجود معرف الموظف المراد حذفه
if (isset($_GET['id'])) {
    $employee_id = $_GET['id'];

    // استعلام لحذف الموظف
    $query = "DELETE FROM employees WHERE id = '$employee_id'";
    if (mysqli_query($con, $query)) {
        echo "تم حذف الموظف بنجاح!";
    } else {
        echo "حدث خطأ أثناء حذف الموظف!";
    }
}
?>
