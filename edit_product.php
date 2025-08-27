<?php
include 'dbConnection.php';

if (!isset($_GET['id'])) {
    echo "No product ID provided.";
    exit;
}

$product_id = $_GET['id'];
$_SESSION['product_id'] = $product_id;

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Product not found.";
    exit;
}

$product = $result->fetch_assoc();

// جلب الفئات والبراندات
$categories = $conn->query("SELECT id, title FROM categories")->fetch_all(MYSQLI_ASSOC);
$brands = $conn->query("SELECT brand_id, brand_name FROM brands")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f8;
            padding: 30px;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        form {
            background-color: #ffffff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: auto;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        .btn {
            padding: 10px 20px;
            font-size: 15px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
            border: none;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
            border: none;
            margin-left: 10px;
        }

        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>

    <h2>Edit Product</h2>

    <form action="update.php" method="POST">
        <div class="form-group">
            <label for="product-id">Product ID</label>
            <input type="text" id="product-id" class="form-control" value="<?= htmlspecialchars($product['id']) ?>" readonly>
        </div>

        <div class="form-group">
            <label for="product-title">Product Title</label>
            <input type="text" id="product-title" name="title" value="<?= htmlspecialchars($product['title']) ?>" required>
        </div>

        <div class="form-group">
            <label for="product-price">Price ($)</label>
            <input type="number" id="product-price" name="price" step="0.01" min="0" value="<?= htmlspecialchars($product['price']) ?>" required>
        </div>

        <div class="form-group">
            <label for="product-quantity">Quantity</label>
            <input type="number" id="product-quantity" name="quantity" min="0" value="<?= htmlspecialchars($product['quantity']) ?>" required>
        </div>

        <div class="form-group">
            <label for="product-status">Status</label>
            <select id="product-status" name="status" required>
                <option value="active" <?= $product['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                <option value="inactive" <?= $product['status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                <option value="draft" <?= $product['status'] == 'draft' ? 'selected' : '' ?>>Draft</option>
            </select>
        </div>

        <div class="form-group">
            <label for="product-category">Category</label>
            <select id="product-category" name="category_id" required>
                <option value="" disabled>Select category</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= $product['category_id'] == $cat['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['title']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="product-brand">Brand</label>
            <select id="product-brand" name="brand_id" required>
                <option value="" disabled>Select brand</option>
                <?php foreach ($brands as $brand): ?>
                    <option value="<?= $brand['brand_id'] ?>" <?= $product['brand_id'] == $brand['brand_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($brand['brand_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="product-description">Description</label>
            <textarea id="product-description" name="description" required><?= htmlspecialchars($product['description']) ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="admin_products.php" class="btn btn-secondary">← Back to Products</a>
    </form>

</body>
</html>