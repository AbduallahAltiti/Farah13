<?php
// الاتصال بقاعدة البيانات باستخدام معلومات الاتصال الصحيحة
$conn = new mysqli("localhost", "root", "", "your_database_name");

// التحقق من الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// التحقق من أن النموذج تم إرساله
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // التحقق من أن الحقول موجودة في المصفوفة $_POST
    if (isset($_POST['name']) && isset($_POST['description']) && isset($_POST['price']) && isset($_POST['stock'])) {
        // استلام البيانات من النموذج
        $product_name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];

        // التأكد من أن جميع الحقول تم ملؤها
        if (!empty($product_name) && !empty($description) && !empty($price) && !empty($stock)) {
            // الاستعلام لإدخال المنتج في قاعدة البيانات
            $query = "INSERT INTO products (name, description, price, stock) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssdi", $product_name, $description, $price, $stock);

            // تنفيذ الاستعلام
            if ($stmt->execute()) {
                echo "تم إضافة المنتج بنجاح!";
            } else {
                echo "حدث خطأ أثناء إضافة المنتج: " . $conn->error;
            }

            $stmt->close();
        } else {
            echo "يرجى ملء جميع الحقول.";
        }
    } else {
        echo "يرجى التأكد من إرسال جميع الحقول.";
    }
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة منتج</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            direction: rtl;
            text-align: right;
            font-family: 'Arial', sans-serif;
        }
        .form-container {
            margin-top: 50px;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-header {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 8px 8px 0 0;
            margin-bottom: 20px;
            text-align: center;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="form-container">
                    <div class="form-header">
                        <h3>إضافة منتج جديد</h3>
                    </div>
                    <form action="add_product.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="product_name" class="form-label">اسم المنتج</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" placeholder="أدخل اسم المنتج" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">الوصف</label>
                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="أدخل وصف المنتج" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">السعر</label>
                            <input type="number" class="form-control" id="price" name="price" placeholder="أدخل سعر المنتج" required>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">الكمية</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" placeholder="أدخل الكمية المتوفرة" required>
                        </div>
                        <div class="mb-3">
                            <label for="product_image" class="form-label">صورة المنتج</label>
                            <input type="file" class="form-control" id="product_image" name="product_image" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">إضافة المنتج</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
