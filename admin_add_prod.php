<?php 
include 'dbConnection.php';
// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    // Validate and sanitize input data
    $status = isset($_POST['status']) ? $conn->real_escape_string($_POST['status']) : '';
    $name = isset($_POST['name']) ? $conn->real_escape_string($_POST['name']) : '';
    $price = isset($_POST['price']) ? floatval($_POST['price']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;
    $category = isset($_POST['category']) ? $conn->real_escape_string($_POST['category']) : '';
    $brand = isset($_POST['brand']) ? $conn->real_escape_string($_POST['brand']) : '';
    $description = isset($_POST['description']) ? $conn->real_escape_string($_POST['description']) : '';
    // First, get the brand ID from the brands table
$brand_id = null;
$brand_query = "SELECT brand_id FROM brands WHERE brand_name = '$brand' LIMIT 1";
$brand_result = $conn->query($brand_query);

// Check if query was successful AND returned rows
if ($brand_result && $brand_result->num_rows > 0) {
    $brand_row = $brand_result->fetch_assoc();
    $brand_id = $brand_row['brand_id'];
} else {
    $error = "Invalid brand selected. Please choose a valid brand.";
    
    // Debug output - shows available brands
    $debug_query = $conn->query("SELECT brand_name FROM brands");
    $available_brands = [];
    while ($row = $debug_query->fetch_assoc()) {
        $available_brands[] = $row['brand_name'];
    }
    $error .= " Available brands: " . implode(", ", $available_brands);
}
// Get the category ID from the categories table
$category_id = null;
$category_query = "SELECT id FROM categories WHERE title = '$category' LIMIT 1";
$category_result = $conn->query($category_query);

if ($category_result && $category_result->num_rows > 0) {
    $category_row = $category_result->fetch_assoc();
    $category_id = $category_row['id'];
} else {
    $error = "Invalid category selected. Please choose a valid category.";
    
    // Debug output - shows available categories
    $debug_query = $conn->query("SELECT title FROM categories");
    $available_categories = [];
    while ($row = $debug_query->fetch_assoc()) {
        $available_categories[] = $row['title'];
    }
    $error .= " Available categories: " . implode(", ", $available_categories);
}
    // Handle file upload*/
    $imagePath = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $targetDir = "img/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $fileExtension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $newFileName = uniqid() . '.' . $fileExtension;
        $targetFile = $targetDir . $newFileName;
        
        // Check file type
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array(strtolower($fileExtension), $allowedTypes)) {
            // Try to upload file
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                $imagePath = $targetFile;
            } else {
                $error = "Error uploading file.";
            }
        } else {
            $error = "Invalid file type. Only JPG, JPEG, PNG, GIF are allowed.";
        }
    }
    
    // Only proceed if no errors
// Only proceed if we have valid IDs and no errors
if (!isset($error) && $brand_id && $category_id) {
    // Get current timestamp for created_at
    $created_at = date('Y-m-d H:i:s');
    
    // Prepare and execute SQL query
    $sql = "INSERT INTO products (`title`, `price`, `quantity`, `image`, `category_id`, `brand_id`, `description`, `status`, `created_at`)
            VALUES ('$name', $price, $quantity, '$imagePath', $category_id, $brand_id, '$description', '$status', '$created_at')";
    
    // Debug output - show the SQL query
    echo "<pre>SQL Query: " . htmlspecialchars($sql) . "</pre>";
    
    $sql_run = mysqli_query($conn, $sql);
    if ($sql_run === TRUE) {
        header("Location: admin_add_prod.php?success=1");
        exit();
    } else {
        $error = "Database error: " . $conn->error;
    }
} else {
    $error = $error ?? "Missing required brand or category selection";
}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>MultiShop</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        /* Vertical Navigation */
        .vertical-nav {
            width: 250px;
            background-color: #000000;
            color: white;
            height: 100vh;
            position: fixed;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }

        .nav-header {
            padding: 20px;
            background-color: #f7e815;
            text-align: center;
        }

        .nav-header .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: rgb(0, 0, 0);
            text-decoration: none;
            text-transform: uppercase;
        }

        .nav-menu {
            padding: 20px 0;
        }

        .nav-menu a {
            display: block;
            padding: 12px 20px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }

        .nav-menu a:hover {
            background-color: rgba(255,255,255,0.1);
            color: #f7e815;
            border-left: 3px solid #f7e815;
        }

        .nav-menu a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .nav-menu a.active {
            background-color: rgba(255,255,255,0.1);
            color: #f7e815;
            border-left: 3px solid #f7e815;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 20px;
        }

        .page-title {
            color: #343a40;
            margin-bottom: 20px;
        }

        /* Alert messages */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Product ADD Card */
        .add-card {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
            padding: 30px;
            max-width: 800px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #495057;
        }

        .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: #000000;
            outline: none;
            box-shadow: 0 0 15px rgba(247, 232, 21, 0.8), 
                        0 0 30px rgba(247, 232, 21, 0.4);
        }

        .form-row {
            display: flex;
            gap: 20px;
        }

        .form-col {
            flex: 1;
        }

        .product-image-container {
            text-align: center;
            margin-bottom: 20px;
            position: relative;
        }

        .product-image {
            max-width: 200px;
            max-height: 200px;
            border-radius: 4px;
            border: 1px solid #eee;
        }

        .image-placeholder {
            background-color: #f8f9fa;
            border: 2px dashed #ced4da;
            border-radius: 4px;
            padding: 30px;
            margin-bottom: 15px;
            color: #6c757d;
        }

        .image-placeholder i {
            display: block;
            margin-bottom: 10px;
        }

        .image-upload {
            margin-top: 10px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-primary {
            background-color: #D19C97;
            color: white;
        }

        .btn-primary:hover {
            background-color: #c58b85;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 30px;
        }

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        /* Status dropdown arrow */
        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23495057'%3e%3cpath d='M7 10l5 5 5-5z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 16px;
            padding-right: 30px;
        }

        /* Placeholder styling */
        ::placeholder {
            color: #adb5bd;
            opacity: 1;
        }

        :-ms-input-placeholder {
            color: #adb5bd;
        }

        ::-ms-input-placeholder {
            color: #adb5bd;
        }

        /* Required field indicators */
        .required-field::after {
            content: " *";
            color: #dc3545;
        }

        /* Validation styles */
        .form-control.error {
            border-color: #dc3545;
        }
        
        .error-message {
            color: #dc3545;
            font-size: 0.8rem;
            margin-top: 5px;
            display: none;
        }
        
        .error-message.show {
            display: block;
        }
        
        .form-group.has-error .form-control {
            border-color: #dc3545;
        }
        
        .form-group.has-error label {
            color: #dc3545;
        }
    </style>
</head>

<body>
    <!-- Vertical Navigation -->
    <nav class="vertical-nav">
        <div class="nav-header">
            <a href="customer_home.php" class="logo">MultiShop</a>
        </div>
        <div class="nav-menu">
            <a href="admin_home.php"><i class="fas fa-home"></i> HOME</a>
            <a href="admin_products.php"><i class="fas fa-shopping-bag"></i> PRODUCTS</a>
            <a href="admin_users.php"><i class="fas fa-users"></i> USERS</a>
            <a href="admin_orders.php"><i class="fas fa-shopping-cart"></i> ORDERS</a>
            <a href="admin_add_prod.php" class="active"><i class="fas fa-chart-line"></i> ADD PRODUCT</a>
            <a href="admin_reports.php"><i class="fas fa-cog"></i> REPORTS</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </nav>

    <!-- Main Content Area -->
    <div class="main-content">
        <h1 class="page-title">ADD PRODUCT DATA</h1>
        
        <!-- Display success/error messages -->
        <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
            <div class="alert alert-success">
                Product added successfully!
            </div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-error">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <!-- content goes here -->
        <div class="add-card">
            <form id="add-product-form" method="POST" enctype="multipart/form-data">
                <div class="product-image-container">
                    <div class="image-placeholder">
                        <i class="fas fa-camera fa-3x"></i>
                        <p>No image selected</p>
                    </div>
                    <div class="image-upload">
                        <input type="file" id="product-image" name="image" accept="image/*" style="display: none;" required>
                        <button type="button" class="btn btn-secondary" onclick="document.getElementById('product-image').click()">
                            <i class="fas fa-camera"></i> Select Image
                        </button>
                        <span class="error-message" id="product-image-error">Product image is required</span>
                    </div>
                </div>
        
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="product-id">Product ID</label>
                            <input type="text" class="form-control" id="product-id" placeholder="Will be generated automatically" readonly>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="product-status" class="required-field">Status</label>
                            <select class="form-control" id="product-status" name="status" required>
                                <option value="" disabled selected>Select status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="draft">Draft</option>
                            </select>
                            <span class="error-message" id="product-status-error">Status is required</span>
                        </div>
                    </div>
                </div>
        
                <div class="form-group">
                    <label for="product-name" class="required-field">Product Name</label>
                    <input type="text" class="form-control" id="product-name" name="name" placeholder="Enter product name" required>
                    <span class="error-message" id="product-name-error">Product name is required</span>
                </div>
        
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="product-price" class="required-field">Price ($)</label>
                            <input type="number" class="form-control" id="product-price" name="price" placeholder="0.00" step="0.01" min="0" required>
                            <span class="error-message" id="product-price-error">Valid price is required</span>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="product-quantity" class="required-field">Quantity</label>
                            <input type="number" class="form-control" id="product-quantity" name="quantity" placeholder="0" min="0" required>
                            <span class="error-message" id="product-quantity-error">Quantity is required</span>
                        </div>
                    </div>
                </div>
        
                <div class="form-group">
                    <label for="product-category" class="required-field">Category</label>
                    <select class="form-control" id="product-category" name="category" required>
                        <option value="" disabled selected>Select category</option>
                        <option value="men-clothing">Men's Clothing</option>
                        <option value="women-clothing">Women's Clothing</option>
                        <option value="electronics">Electronics</option>
                        <option value="accessories">Accessories</option>
                        <option value="footwear">Footwear</option>
                    </select>
                    <span class="error-message" id="product-category-error">Category is required</span>
                </div>

                <div class="form-group">
    <label for="product-brand" class="required-field">Brand</label>
    <select class="form-control" id="product-brand" name="brand" required>
        <option value="" disabled selected>Select brand</option>
        <option value="zara">zara</option>
        <option value="gucci">gucci</option>
        <!-- Add more brands as needed -->
    </select>
    <span class="error-message" id="product-brand-error">Brand is required</span>
</div>
        
                <div class="form-group">
                    <label for="product-description" class="required-field">Description</label>
                    <textarea class="form-control" id="product-description" name="description" placeholder="Enter product description" required></textarea>
                    <span class="error-message" id="product-description-error">Description is required</span>
                </div>
                
                <div class="action-buttons">
                    <button type="button" class="btn btn-secondary" id="reset-btn">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-primary" id="add-btn" name="add">
                        <i class="fas fa-plus-circle"></i> Add Product
                    </button>
                </div>
            </form>
        </div>
        
        <script>
            // Track form changes
            let formChanged = false;
            const form = document.getElementById('add-product-form');
            const formInputs = form.querySelectorAll('input, select, textarea');
            
            // Add change event listeners to all form inputs
            formInputs.forEach(input => {
                if (!input.readOnly && input.id !== 'product-id') {
                    input.addEventListener('input', function() {
                        formChanged = true;
                    });
                }
            });
            
            // Image preview when new image is selected
            document.getElementById('product-image').addEventListener('change', function(e) {
                const file = e.target.files[0];
                const imageContainer = document.querySelector('.product-image-container');
                
                if (file) {
                    // Remove placeholder if it exists
                    const placeholder = imageContainer.querySelector('.image-placeholder');
                    if (placeholder) {
                        placeholder.remove();
                    }
                    
                    // Create image element if it doesn't exist
                    let img = imageContainer.querySelector('.product-image');
                    if (!img) {
                        img = document.createElement('img');
                        img.className = 'product-image';
                        imageContainer.insertBefore(img, imageContainer.firstChild);
                    }
                    
                    // Preview image
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        img.src = event.target.result;
                        // Clear error if image is selected
                        document.getElementById('product-image-error').classList.remove('show');
                        document.getElementById('product-image').classList.remove('error');
                    };
                    reader.readAsDataURL(file);
                }
                formChanged = true;
            });
            
            // Validate individual field
            function validateField(field) {
                const errorElement = document.getElementById(`${field.id}-error`);
                const formGroup = field.closest('.form-group');
                
                if (field.validity.valid) {
                    field.classList.remove('error');
                    if (errorElement) errorElement.classList.remove('show');
                    if (formGroup) formGroup.classList.remove('has-error');
                } else {
                    field.classList.add('error');
                    if (errorElement) errorElement.classList.add('show');
                    if (formGroup) formGroup.classList.add('has-error');
                }
            }
            
            // Validate all fields
            function validateForm() {
                let isValid = true;
                const requiredFields = Array.from(document.querySelectorAll('[required]'));
                
                requiredFields.forEach(field => {
                    validateField(field);
                    if (!field.validity.valid) {
                        isValid = false;
                    }
                });
                
                return isValid;
            }
            console.log("Form validation result:", validateForm());
console.log("Form changed status:", formChanged);
            // Form submission - only prevent if validation fails
            document.getElementById('add-product-form').addEventListener('submit', function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                }
                // Let the form submit normally if validation passes
            });
            
            // Reset button functionality
            document.getElementById('reset-btn').addEventListener('click', function() {
                if (formChanged) {
                    if (confirm('Are you sure you want to reset the form? All entered data will be lost.')) {
                        form.reset();
                        
                        // Reset image preview
                        const imageContainer = document.querySelector('.product-image-container');
                        const img = imageContainer.querySelector('.product-image');
                        if (img) {
                            img.remove();
                        }
                        if (!imageContainer.querySelector('.image-placeholder')) {
                            const placeholder = document.createElement('div');
                            placeholder.className = 'image-placeholder';
                            placeholder.innerHTML = '<i class="fas fa-camera fa-3x"></i><p>No image selected</p>';
                            imageContainer.insertBefore(placeholder, imageContainer.firstChild);
                        }
                        
                        // Clear validation errors
                        const errorMessages = document.querySelectorAll('.error-message');
                        errorMessages.forEach(msg => msg.classList.remove('show'));
                        
                        const errorFields = document.querySelectorAll('.form-control.error');
                        errorFields.forEach(field => field.classList.remove('error'));
                        
                        const errorGroups = document.querySelectorAll('.form-group.has-error');
                        errorGroups.forEach(group => group.classList.remove('has-error'));
                        
                        formChanged = false;
                    }
                } else {
                    alert('No changes to reset.');
                }
            });
            
            // Real-time validation on blur for all required fields
            const requiredFields = Array.from(document.querySelectorAll('[required]'));
            requiredFields.forEach(field => {
                field.addEventListener('blur', function() {
                    validateField(this);
                });
            });
            
            // Warn before leaving page with unsaved changes
            window.addEventListener('beforeunload', function(e) {
                if (formChanged) {
                    e.preventDefault();
                    e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
                }
            });
        </script>
    </div>
    
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
</body>

</html>