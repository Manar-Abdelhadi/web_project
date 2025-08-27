<?php
include 'dbConnection.php';

// Get order ID from URL
$order_id = $_GET['order_id'];

// Get order information
$order_query = "SELECT * FROM orders WHERE id = $order_id";
$order_result = mysqli_query($conn, $order_query);
$order = mysqli_fetch_assoc($order_result);

// Get order items with product details
$items_query = "SELECT order_items.*, products.title, products.image, products.description 
                FROM order_items 
                JOIN products ON order_items.product_id = products.id 
                WHERE order_items.order_id = $order_id";
$items_result = mysqli_query($conn, $items_query);

// Count total items
$total_items = 0;
$order_items = array();

// Get all items
while($item = mysqli_fetch_assoc($items_result)) {
    $order_items[] = $item;
    $total_items = $total_items + $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - MultiShop</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .order-header {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .order-title {
            color: #343a40;
            border-bottom: 2px solid #f7e815;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .order-summary {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .summary-card {
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            border: 1px solid transparent;
            transition: all 0.3s ease;
        }

        .summary-card:hover {
            background-color: #f7e815;
            border: 1px solid #000000;
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .summary-label {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .summary-value {
            font-size: 18px;
            font-weight: 600;
            color: #343a40;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .items-table th {
            background-color: #000000;
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }

        .items-table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
            transition: all 0.3s ease;
        }

        .items-table tr:last-child td {
            border-bottom: none;
        }

        .items-table tr:hover td {
            background-color: #f7e815;
            border-color: #000000;
        }

        .items-table tr:hover td:first-child {
            border-left: 1px solid #000000;
        }

        .items-table tr:hover td:last-child {
            border-right: 1px solid #000000;
        }

        .product-photo {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #eee;
            transition: all 0.3s ease;
        }

        .items-table tr:hover .product-photo {
            border-color: #000000;
            transform: scale(1.05);
        }

        .back-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #000000;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
            transition: all 0.3s;
            border: 1px solid #000000;
        }

        .back-btn:hover {
            background-color: #f7e815;
            color: #000000;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
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

        .no-data {
            text-align: center;
            color: #6c757d;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="order-header">
            <h1 class="order-title">Order #<?php echo $order_id; ?> Details</h1>

            <?php if ($order): ?>
                <div class="order-summary">
                    <div class="summary-card">
                        <div class="summary-label">Order Status</div>
                        <!-- Display order status -->
                        <div class="status-badge status-<?php echo $order['status']; ?>">
                            <?php echo $order['status']; ?>
                        </div>
                    </div>

                    <div class="summary-card">
                        <div class="summary-label">Order Date</div>
                        <!-- Display order date -->
                        <div class="summary-value"><?php echo $order['created_at']; ?></div>
                    </div>

                    <div class="summary-card">
                        <div class="summary-label">Total Items</div>
                        <div class="summary-value"><?php echo $total_items; ?></div>
                    </div>

                    <div class="summary-card">
                        <div class="summary-label">Order Total</div>
                        <div class="summary-value">$<?php echo number_format($order['total'], 2); ?></div>
                    </div>
                </div>
            <?php else: ?>
                <div class="no-data">Order not found.</div>
            <?php endif; ?>
        </div>

        <h2>Order Items</h2>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Photo</th>
                    <th>Quantity</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <!-- Check if order exists and has items -->
                <!-- $order contains order information from database -->
                <?php if ($order && !empty($order_items)): ?>
                    <?php foreach ($order_items as $item): ?>
                        <tr>
                            <td>#<?php echo $item['product_id']; ?></td>
                            <td><?php echo htmlspecialchars($item['title']); ?></td>
                            <td><img src="img/<?php echo $item['image']; ?>" alt="Product" class="product-photo"></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo htmlspecialchars($item['desc']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="no-data">No items found for this order.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="admin_orders.php" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Orders
        </a>
    </div>
</body>
</html>
<?php
mysqli_close($conn);
?>