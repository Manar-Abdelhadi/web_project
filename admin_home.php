<?php include 'dbConnection.php';
$admin_id = $_SESSION['user_id'] ?? null;

if (!$admin_id) {
    // لو مفيش جلسة، رجعيه لصفحة تسجيل الدخول
    header("Location: login.php");
    exit;
}

$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();

$admin = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>MultiShop - Admin Profile</title>
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

        /* Profile Card */
        .profile-card {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
            padding: 30px;
            max-width: 800px;
            margin: 0 auto;
        }

        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }

        .profile-image-container {
            position: relative;
            margin-right: 20px;
        }

        .profile-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #f7e815;
        }

        .image-upload-btn {
            position: absolute;
            bottom: 5px;
            right: 5px;
            background-color: #D19C97;
            color: white;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .profile-info h2 {
            margin: 0;
            color: #343a40;
        }

        .profile-info p {
            margin: 5px 0;
            color: #6c757d;
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

        .form-control[readonly] {
            background-color: #f8f9fa;
        }

        .form-row {
            display: flex;
            gap: 20px;
        }

        .form-col {
            flex: 1;
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

        .btn-edit {
            background-color: #f7e815;
            color: black;
        }

        .btn-edit:hover {
            background-color: #e5d614;
        }

        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 30px;
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
            <a href="admin_home.php" class="active"><i class="fas fa-home"></i> HOME</a>
            <a href="admin_products.php"><i class="fas fa-shopping-bag"></i> PRODUCTS</a>
            <a href="admin_users.php"><i class="fas fa-users"></i> USERS</a>
            <a href="admin_orders.php"><i class="fas fa-shopping-cart"></i> ORDERS</a>
            <a href="admin_add_prod.php"><i class="fas fa-chart-line"></i> ADD PRODUCT</a>
            <a href="admin_reports.php"><i class="fas fa-cog"></i> REPORTS</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </nav>

    <!-- Main Content Area -->
    <div class="main-content">
        <h1 class="page-title">ADMIN PROFILE</h1> 
        <div class="profile-card" method="GET">
            <form id="admin-profile-form">
                <div class="profile-header">
                    <div class="profile-image-container">
                        <img src="img/admin-avatar.jpg" alt="Admin Avatar" class="profile-image">
                        <div class="image-upload-btn" onclick="document.getElementById('profile-image-upload').click()">
                            <i class="fas fa-camera"></i>
                            <input type="file" id="profile-image-upload" accept="image/*" style="display: none;" required>
                        </div>
                    </div>        
                    <div class="profile-info">
                               <h2 id="admin-fullname"><?php echo htmlspecialchars($admin['name']); ?></h2>
                               <p id="admin-position"><?php echo htmlspecialchars($admin['position']); ?></p>
                               <p id="admin-join-date">Member since: <?php echo date('d/m/Y', strtotime($admin['created_at'])); ?></p>
</div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="admin-id" class="required-field">Admin ID</label>
                            <input type="text" class="form-control" id="admin-id" name="admin-id" value="<?php echo htmlspecialchars($admin['id']); ?>" readonly>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="admin-status" class="required-field">Account Status</label>
                            <input type="text" class="form-control" id="admin-status" name="admin-status" value="<?php echo htmlspecialchars($admin['acc_status']); ?>" readonly>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="first-name" class="required-field">full Name</label>
                            <input type="text" class="form-control" id="first-name" name="first-name" value="<?php echo htmlspecialchars($admin['name']); ?>" required>
                            <span class="error-message" id="first-name-error">full name is required</span>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="email" class="required-field">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" required>
                            <span class="error-message" id="email-error">Please enter a valid email address</span>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="phone" class="required-field">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($admin['phone']); ?>" required>
                            <span class="error-message" id="phone-error">Phone number is required</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="address" class="required-field">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($admin['address']); ?>" required>
                    <span class="error-message" id="address-error">Address is required</span>
                </div>
                
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="department" class="required-field">Department</label>
                            <select class="form-control" id="department" name="department" required>
                                <option value="management" selected>Management</option>
                                <option value="operations">Operations</option>
                                <option value="technical">Technical</option>
                                <option value="customer-service">Customer Service</option>
                            </select>
                            <span class="error-message" id="department-error">Department is required</span>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="position" class="required-field">Position</label>
                            <input type="text" class="form-control" id="position" name="position" value="<?php echo htmlspecialchars($admin['position']); ?>" required>
                            <span class="error-message" id="position-error">Position is required</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="bio" class="required-field">Bio</label>
                    <textarea class="form-control" id="bio" name="bio" rows="3" required><?php echo htmlspecialchars($admin['bio']); ?></textarea>
                    <span class="error-message" id="bio-error">Bio is required</span>
                </div>
            </form>
        </div>
        
    
    </div>
</body>
</html>