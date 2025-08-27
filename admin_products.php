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
        /* Product Table */
        .product-table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        .product-table th {
            background-color: #000000;
            color: white;
            padding: 15px;
            text-align: left;
        }

        .product-table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }

        .product-table tr:hover {
            background-color: #f7e815;
        }

        .product-photo {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #eee;
        }

        .action-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
        }
        .edit-btn {
            background-color: #b6ad2b;
            color: white;
        }

        .edit-btn:hover {
            background-color: #9a0d0d;
        }
        .status-in-stock {
            color: #28a745;
            font-weight: 500;
        }

        .status-low-stock {
            color: #ffc107;
            font-weight: 500;
        }

        .status-out-of-stock {
            color: #dc3545;
            font-weight: 500;
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
            <a href="admin_products.php" class="active"><i class="fas fa-shopping-bag"></i> PRODUCTS</a>
            <a href="admin_users.php"><i class="fas fa-users"></i> USERS</a>
            <a href="admin_orders.php"><i class="fas fa-shopping-cart"></i> ORDERS</a>
            <a href="admin_add_prod.php"><i class="fas fa-chart-line"></i> ADD PRODUCT</a>
            <a href="admin_reports.php"><i class="fas fa-cog"></i> REPORTS</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </nav>

    <!-- Main Content Area -->
    <div class="main-content">
        <h1 class="page-title">PRODUCTS</h1>
        <!-- content goes here -->
        <table class="product-table">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Photo</th>
                    <th>Quantity</th>
                    <th>Details</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $statusClass = '';
    $stockText = '';

    if ($row['quantity'] > 10) {
        $statusClass = 'status-in-stock';
        $stockText = $row['quantity'] . ' in stock';
    } elseif ($row['quantity'] > 0) {
        $statusClass = 'status-low-stock';
        $stockText = $row['quantity'] . ' in stock';
    } else {
        $statusClass = 'status-out-of-stock';
        $stockText = 'Out of stock';
    }

    echo '<tr>';
    echo '<td>#' . $row['id'] . '</td>';


    echo '<td>' . htmlspecialchars($row['title']) . '</td>';
    echo '<td><img src="' . htmlspecialchars($row['image']) . '" alt="Product" class="product-photo"></td>';
    echo '<td><span class="' . $statusClass . '">' . $stockText . '</span></td>';
    echo '<td>' . htmlspecialchars($row['description']) . '</td>';
    echo '<td>
            <a href="edit_product.php?id=' . $row['id'] . '" class="action-btn edit-btn">Edit</a>
            <a href="delete_product.php?id=' . $row['id'] . '" class="action-btn edit-btn" onclick="return confirm(\'Are you sure you want to delete this product?\')">Delete</a>
          </td>';
    echo '</tr>';
}
?>
            </tbody>
        </table>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
</body>

</html>