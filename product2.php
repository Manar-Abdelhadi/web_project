<?php include 'dbConnection.php';?>
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
        
        /* Product ADD Card */
        .edit-card {
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
        }

        .product-image {
            max-width: 200px;
            max-height: 200px;
            border-radius: 4px;
            border: 1px solid #eee;
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
            background-color: #7b5652;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #363b3f;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background-color: #75141d;
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
        
        /* Quantity Input Styles */
        .quantity-control {
            display: flex;
            align-items: center;
            margin-left: 15px;
        }
        
        .quantity-input {
            width: 60px;
            text-align: center;
            margin: 0 5px;
        }
        
        .quantity-btn {
            width: 30px;
            height: 30px;
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        
        .quantity-btn:hover {
            background-color: #e9ecef;
        }
        
        .quantity-btn:active {
            background-color: #dee2e6;
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
        
        .required-field::after {
            content: " *";
            color: #dc3545;
        }
    </style>
</head>

<body>
    <!-- Vertical Navigation -->
    <nav class="vertical-nav">
        <div class="nav-header">
            <a href="index.html" class="logo">MultiShop</a>
        </div>
        <div class="nav-menu">
            <a href="admin_home.php"><i class="fas fa-home"></i> HOME</a>
            <a href="admin_products.php" class="active"><i class="fas fa-shopping-bag"></i> PRODUCTS</a>
            <a href="admin_users.php"><i class="fas fa-users"></i> USERS</a>
            <a href="admin_orders.php"><i class="fas fa-shopping-cart"></i> ORDERS</a>
            <a href="admin_add_prod.php"><i class="fas fa-chart-line"></i>ADD PRODUCT DATA</a>
            <a href="admin_reports.php"><i class="fas fa-cog"></i> REPORTS</a>
            <a href="login.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </nav>

    <!-- Main Content Area -->
    <div class="main-content">
        <h1 class="page-title">PRODUCT 1</h1>
        <!-- content goes here -->
        <div class="edit-card">
            <form id="product-edit-form">
                <div class="product-image-container">
                    <img src="img/product-1.jpg" alt="Product Image" class="product-image">
                    <div class="image-upload">
                        <input type="file" id="product-image" accept="image/*" style="display: none;" required>
                        <button type="button" class="btn btn-secondary" onclick="document.getElementById('product-image').click()">
                            <i class="fas fa-camera"></i> Change Image
                        </button>
                        <span class="error-message" id="product-image-error">Product image is required</span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="product-id">Product ID</label>
                            <input type="text" class="form-control" id="product-id" value="PRD-1001" readonly>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="product-status" class="required-field">Status</label>
                            <select class="form-control" id="product-status" required>
                                <option value="" disabled>Select status</option>
                                <option value="active" selected>Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="draft">Draft</option>
                            </select>
                            <span class="error-message" id="product-status-error">Status is required</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="product-name" class="required-field">Product Name</label>
                    <input type="text" class="form-control" id="product-name" value="Men's Casual Shirt" required>
                    <span class="error-message" id="product-name-error">Product name is required</span>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="product-price" class="required-field">Price ($)</label>
                            <input type="number" class="form-control" id="product-price" value="49.99" step="0.01" min="0.01" required>
                            <span class="error-message" id="product-price-error">Valid price is required (minimum $0.01)</span>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="product-quantity" class="required-field">Quantity</label>
                            <div class="quantity-control">
                                <button type="button" class="quantity-btn" onclick="adjustQuantity('product-quantity', -1)">-</button>
                                <input type="number" class="form-control quantity-input" id="product-quantity" value="45" min="0" required>
                                <button type="button" class="quantity-btn" onclick="adjustQuantity('product-quantity', 1)">+</button>
                            </div>
                            <span class="error-message" id="product-quantity-error">Quantity is required (minimum 0)</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="product-category" class="required-field">Category</label>
                    <select class="form-control" id="product-category" required>
                        <option value="" disabled>Select category</option>
                        <option value="men-clothing" selected>Men's Clothing</option>
                        <option value="women-clothing">Women's Clothing</option>
                        <option value="electronics">Electronics</option>
                        <option value="accessories">Accessories</option>
                        <option value="footwear">Footwear</option>
                    </select>
                    <span class="error-message" id="product-category-error">Category is required</span>
                </div>

                <div class="form-group">
                    <label for="product-description" class="required-field">Description</label>
                    <textarea class="form-control" id="product-description" required>High-quality casual shirt made from 100% cotton. Available in various sizes and colors. Perfect for both casual and semi-formal occasions.</textarea>
                    <span class="error-message" id="product-description-error">Description is required</span>
                </div>

                <div class="form-group">
                    <label for="product-specs" class="required-field">Specifications</label>
                    <textarea class="form-control" id="product-specs" required>Material: 100% Cotton
Care Instructions: Machine wash cold, tumble dry low
Fit: Regular fit
Pattern: Solid color
Collar: Button-down collar</textarea>
                    <span class="error-message" id="product-specs-error">Specifications are required</span>
                </div>

                <div class="action-buttons">
                    <button type="button" class="btn btn-danger" id="delete-btn">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                    <button type="button" class="btn btn-secondary" id="cancel-btn">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" id="save-btn">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        // Track form changes
        let formChanged = false;
        const form = document.getElementById('product-edit-form');
        const formInputs = form.querySelectorAll('input, select, textarea');
        
        // Add change event listeners to all form inputs
        formInputs.forEach(input => {
            // Skip readonly fields
            if (!input.readOnly) {
                input.addEventListener('change', function() {
                    formChanged = true;
                });
            }
        });
        
        // Image preview when new image is selected
        document.getElementById('product-image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.querySelector('.product-image').src = event.target.result;
                    // Clear error if image is selected
                    document.getElementById('product-image-error').classList.remove('show');
                    document.getElementById('product-image').classList.remove('error');
                };
                reader.readAsDataURL(file);
            }
            // Always mark form as changed when interacting with image upload
            formChanged = true;
        });
        
        // Quantity adjustment function
        function adjustQuantity(inputId, change) {
            const input = document.getElementById(inputId);
            let value = parseInt(input.value) || 0;
            value += change;
            
            // Ensure quantity doesn't go below 0
            if (value < 0) value = 0;
            
            input.value = value;
            validateField(input);
            formChanged = true;
        }
        
        // Validate quantity input
        document.getElementById('product-quantity').addEventListener('change', function() {
            if (this.value < 0) {
                this.value = 0;
            }
            validateField(this);
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
        
        // Form submission
        document.getElementById('product-edit-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (validateForm()) {
                // Here you would handle the form submission to your backend
                const formData = new FormData(this);
                const formDataObj = {};
                formData.forEach((value, key) => {
                    formDataObj[key] = value;
                });
                
                console.log('Product data to be submitted:', formDataObj);
                
                // Show success alert regardless of whether image was changed or not
                alert('Product changes saved successfully!');
                formChanged = false;
            }
        });
        
        // Delete button functionality
        document.getElementById('delete-btn').addEventListener('click', function() {
            if (confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
                // Here you would handle the delete operation
                alert('Product deleted successfully!');
                // Redirect to products page after deletion
                window.location.href = 'admin_products.php';
            }
        });
        
        // Cancel button functionality
        document.getElementById('cancel-btn').addEventListener('click', function() {
            if (formChanged) {
                if (confirm('Are you sure you want to cancel? All unsaved changes will be lost.')) {
                    // Redirect to products page
                    window.location.href = 'admin_products.php';
                }
            } else {
                // No changes made, just go back
                window.location.href = 'admin_products.php';
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
    
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
</body>

</html>