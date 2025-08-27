<?php
// Connect to the database
include 'dbConnection.php';

// Handle status update
if(isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];
    
    // Update status in database
    $update_sql = "UPDATE orders SET status = '$new_status' WHERE id = $order_id";
    mysqli_query($conn, $update_sql);
}

// Get all orders from the database
$sql = "SELECT * FROM orders";
$result = mysqli_query($conn, $sql);

// Get pending orders count
$pending_query = "SELECT * FROM orders WHERE status = 'pending'";
$pending_result = mysqli_query($conn, $pending_query);
$pending_count = mysqli_num_rows($pending_result);

// Get processing orders count
$processing_query = "SELECT * FROM orders WHERE status = 'processing'";
$processing_result = mysqli_query($conn, $processing_query);
$processing_count = mysqli_num_rows($processing_result);

// Get shipped orders count
$shipped_query = "SELECT * FROM orders WHERE status = 'shipped'";
$shipped_result = mysqli_query($conn, $shipped_query);
$shipped_count = mysqli_num_rows($shipped_result);

// Get delivered orders count
$delivered_query = "SELECT * FROM orders WHERE status = 'delivered'";
$delivered_result = mysqli_query($conn, $delivered_query);
$delivered_count = mysqli_num_rows($delivered_result);

// Get canceled orders count
$canceled_query = "SELECT * FROM orders WHERE status = 'canceled'";
$canceled_result = mysqli_query($conn, $canceled_query);
$canceled_count = mysqli_num_rows($canceled_result);

// Get all orders
$orders_query = "SELECT id, name, phone, address, created_at, total, paymentType, status FROM orders ORDER BY created_at DESC";
$orders_result = mysqli_query($conn, $orders_query);

// Fetch all orders into an array
$orders = mysqli_fetch_all($orders_result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>MultiShop - Orders</title>
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

        /* Dashboard Cards */
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 25px;
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: default;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            background-color: #f7e815;
        }

        .card-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .card-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: white;
            font-size: 20px;
        }

        .card-icon.pending {
            background-color: #ffc107;
        }

        .card-icon.processing {
            background-color: #17a2b8;
        }

        .card-icon.shipped {
            background-color: #007bff;
        }

        .card-icon.delivered {
            background-color: #28a745;
        }

        .card-icon.canceled {
            background-color: #dc3545;
        }

        .card-title {
            font-size: 14px;
            color: #6c757d;
            margin: 0;
        }

        .card-value {
            font-size: 24px;
            font-weight: 700;
            color: #343a40;
            margin: 5px 0 0 0;
        }

        .card-footer {
            margin-top: 10px;
            font-size: 13px;
            color: #6c757d;
        }

        /* Tables Section */
        .tables-section {
            margin-top: 30px;
        }

        .table-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 25px;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #000000;
            font-weight: 600;
            color: #ffffff;
        }

        tr:hover {
            background-color: #f7e815;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-processing {
            background-color: #cce5ff;
            color: #004085;
        }

        .status-shipped {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .status-delivered {
            background-color: #d4edda;
            color: #155724;
        }

        .status-canceled {
            background-color: #f8d7da;
            color: #721c24;
        }

        .action-btn {
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .show-items-btn {
            background-color: #6c757d;
            color: white;
        }

        .show-items-btn:hover {
            background-color: #95a2ac;
        }

        .no-data {
            text-align: center;
            color: #6c757d;
            padding: 20px;
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
            <a href="admin_add_prod.php"><i class="fas fa-chart-line"></i> ADD PRODUCT</a>
            <a href="admin_reports.php"><i class="fas fa-cog"></i> REPORTS</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </nav>

    <!-- Main Content Area -->
    <div class="main-content">
        <h1 class="page-title">ORDERS</h1>

        <!-- Dashboard Cards -->
        <div class="dashboard-cards">
            <div class="card">
                <div class="card-header">
                    <div class="card-icon pending">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <p class="card-title">PENDING ORDERS</p>
                        <p class="card-value"><?php echo $pending_count; ?></p>
                    </div>
                </div>
                <p class="card-footer">Waiting for processing</p>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-icon processing">
                        <i class="fas fa-cog"></i>
                    </div>
                    <div>
                        <p class="card-title">PROCESSING</p>
                        <p class="card-value"><?php echo $processing_count; ?></p>
                    </div>
                </div>
                <p class="card-footer">Being prepared for shipment</p>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-icon shipped">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div>
                        <p class="card-title">SHIPPED</p>
                        <p class="card-value"><?php echo $shipped_count; ?></p>
                    </div>
                </div>
                <p class="card-footer">On the way to customers</p>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-icon delivered">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <p class="card-title">DELIVERED</p>
                        <p class="card-value"><?php echo $delivered_count; ?></p>
                    </div>
                </div>
                <p class="card-footer positive">+8% from last month</p>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-icon canceled">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div>
                        <p class="card-title">CANCELED</p>
                        <p class="card-value"><?php echo $canceled_count; ?></p>
                    </div>
                </div>
                <p class="card-footer negative">2% of total orders</p>
            </div>
        </div>

        <!-- Table Section -->
        <div class="tables-section">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Created At</th>
                            <th>Total</th>
                            <th>Payment Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Check if there are any orders
                        $has_orders = false;
                        // Loop through all orders using foreach
                        foreach ($orders as $order) {
                            $has_orders = true;
                            // Simple total display
                            $total = $order['total'];
                            // Start table row
                            echo "<tr>";
                            echo "<td>" . $order['id'] . "</td>";
                            echo "<td>" . $order['name'] . "</td>";
                            echo "<td>" . $order['phone'] . "</td>";
                            echo "<td>" . $order['address'] . "</td>";
                            echo "<td>" . $order['created_at'] . "</td>";
                            echo "<td>$" . $total . "</td>";
                            echo "<td>" . $order['paymentType'] . "</td>";
                            echo "<td>";
                            echo "<form method='post'>";
                            echo "<input type='hidden' name='order_id' value='" . $order['id'] . "'>";
                            echo "<select name='new_status' onchange='this.form.submit()'>";
                            
                            // Check each status one by one
                            if($order['status'] == 'pending') {
                                echo "<option value='pending' selected>Pending</option>";
                            } else {
                                echo "<option value='pending'>Pending</option>";
                            }
                            
                            if($order['status'] == 'processing') {
                                echo "<option value='processing' selected>Processing</option>";
                            } else {
                                echo "<option value='processing'>Processing</option>";
                            }
                            
                            if($order['status'] == 'shipped') {
                                echo "<option value='shipped' selected>Shipped</option>";
                            } else {
                                echo "<option value='shipped'>Shipped</option>";
                            }
                            
                            if($order['status'] == 'delivered') {
                                echo "<option value='delivered' selected>Delivered</option>";
                            } else {
                                echo "<option value='delivered'>Delivered</option>";
                            }
                            
                            if($order['status'] == 'canceled') {
                                echo "<option value='canceled' selected>Canceled</option>";
                            } else {
                                echo "<option value='canceled'>Canceled</option>";
                            }
                            
                            echo "</select>";
                            echo "<input type='hidden' name='update_status' value='1'>";
                            echo "</form>";
                            echo "</td>";
                            echo "<td><a href='order1_items.php?order_id=" . $order['id'] . "' class='action-btn show-items-btn'><i class='fas fa-eye'></i>  Show Items</a></td>";
                            echo "</tr>";
                        }
                        // If no orders, show message
                        if (!$has_orders) {
                            echo "<tr><td colspan='9' class='no-data'>No orders found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- JavaScript for navigation active state -->
    <script>
        // When the page loads
        window.onload = function() {
            // Get all navigation links
            var navLinks = document.getElementsByClassName('nav-menu')[0].getElementsByTagName('a');
            // Get current page name (e.g., admin_orders.php)
            var currentPage = window.location.pathname.split('/').pop();

            // Loop through links
            for (var i = 0; i < navLinks.length; i++) {
                // Remove active class from all links
                navLinks[i].classList.remove('active');
                // Get link's page name
                var linkPage = navLinks[i].getAttribute('href').split('/').pop();
                // If link matches current page, add active class
                if (linkPage == currentPage) {
                    navLinks[i].classList.add('active');
                }
            }
        };
    </script>
</body>
</html>
<?php
// Close the database connection
mysqli_close($conn);
?>