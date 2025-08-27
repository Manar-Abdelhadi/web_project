<?php
include 'dbConnection.php';

if (!isset($_SESSION['product_id'])) {
    echo "No product selected for update.";
    exit;
}

$product_id = $_SESSION['product_id'];

// التحقق من استقبال جميع البيانات
if (
    isset($_POST['title'], $_POST['price'], $_POST['quantity'], $_POST['status'],
          $_POST['category_id'], $_POST['brand_id'], $_POST['description'])
) {
    $title = trim($_POST['title']);
    $price = floatval($_POST['price']);
    $quantity = intval($_POST['quantity']);
    $status = $_POST['status'];
    $category_id = intval($_POST['category_id']);
    $brand_id = intval($_POST['brand_id']);
    $description = trim($_POST['description']);

    // تنفيذ التحديث
    $stmt = $conn->prepare("
        UPDATE products
        SET title = ?, price = ?, quantity = ?, status = ?, category_id = ?, brand_id = ?, description = ?
        WHERE id = ?
    ");
    $stmt->bind_param("sdissssi", $title, $price, $quantity, $status, $category_id, $brand_id, $description, $product_id);

    if ($stmt->execute()) {
        // جلب اسم الفئة
        $cat_result = $conn->query("SELECT title FROM categories WHERE id = $category_id");
        $category_name = $cat_result->fetch_assoc()['title'] ?? 'Unknown';

        // جلب اسم البراند
        $brand_result = $conn->query("SELECT brand_name FROM brands WHERE brand_id = $brand_id");
        $brand_name = $brand_result->fetch_assoc()['brand_name'] ?? 'Unknown';

        echo "<h3 style='color: green;'>✔ Product updated successfully.</h3>";
        echo "<p><strong>Title:</strong> " . htmlspecialchars($title) . "</p>";
        echo "<p><strong>Category:</strong> " . htmlspecialchars($category_name) . "</p>";
        echo "<p><strong>Brand:</strong> " . htmlspecialchars($brand_name) . "</p>";
        echo "<p><strong>Status:</strong> " . htmlspecialchars($status) . "</p>";
        echo "<a href='admin_products.php' class='btn btn-secondary'>← Back to Products</a>";
    } else {
        echo "<h3 style='color: red;'>✘ Error updating product: " . $stmt->error . "</h3>";
        echo "<a href='edit.php?id=$product_id' class='btn btn-secondary'>← Back to Edit</a>";
    }

    $stmt->close();
} else {
    echo "<h3 style='color: red;'>Missing required fields.</h3>";
    echo "<a href='edit.php?id=$product_id' class='btn btn-secondary'>← Back to Edit</a>";
}

$conn->close();
?>