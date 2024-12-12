<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "telecom_store_management"; // اسم قاعدة البيانات

// إنشاء الاتصال بقاعدة البيانات
$con = mysqli_connect($host, $username, $password, $database);

// التحقق من الاتصال
if (mysqli_connect_errno()) {
    die("فشل الاتصال بقاعدة البيانات: " . mysqli_connect_error());
}
?>
