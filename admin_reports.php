<?php
include 'dbConnection.php';
// Get all reports
$sql = "SELECT r.*, u.name as admin_name 
        FROM reports r 
        JOIN users u ON r.admin_id = u.id 
        ORDER BY r.rep_id ASC";
$result = mysqli_query($conn, $sql);
$reports = mysqli_fetch_all($result, MYSQLI_ASSOC);


// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = $_POST['report-type'];
    $directed_to = 'Management';
    $content = $_POST['report-details'];
    $priority = $_POST['priority'];
    $admin_id = $_SESSION['user_id'];

    $sql = "INSERT INTO reports (subject, directed_to, content, priority, admin_id) 
            VALUES ('$subject', '$directed_to', '$content', '$priority', $admin_id)";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Report created successfully!');</script>";
    } else {
        echo "<script>alert('Error creating report: " . mysqli_error($conn) . "');</script>";
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

        /* Reports Table */
        .reports-table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        .reports-table th {
            background-color: #000000;
            color: white;
            padding: 15px;
            text-align: left;
        }

        .reports-table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }

        .reports-table tr:hover {
            background-color: #f7e815;
        }

        .action-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
        }

        .view-btn {
            background-color: #b6ad2b;
            color: white;
        }

        .view-btn:hover {
            background-color: #9a0d0d;
        }

        .status-high {
            color: #dc3545;
            font-weight: 500;
        }

        .status-medium {
            color: #ffc107;
            font-weight: 500;
        }

        .status-low {
            color: #28a745;
            font-weight: 500;
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
            <a href="admin_reports.php" class="active"><i class="fas fa-cog"></i> REPORTS</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </nav>

    <!-- Main Content Area -->
    <div class="main-content">
        <h1 class="page-title">REPORTS</h1>
        
        <!-- Add Report Form -->
        <div class="add-report-form" style="background: white; padding: 20px; margin-bottom: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.05);">
            <h2 style="margin-bottom: 20px;">Add New Report</h2>
            <form method="POST">
                <div style="display: flex; gap: 20px; margin-bottom: 20px;">
                    <div style="flex: 1;">
                        <label style="display: block; margin-bottom: 5px;">Report Type</label>
                        <select name="report-type" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" required>
                            <option value="">Select Type</option>
                            <option value="sales">Sales Report</option>
                            <option value="inventory">Inventory Report</option>
                            <option value="users">User Activity Report</option>
                            <option value="orders">Order Status Report</option>
                        </select>
                    </div>
                    <div style="flex: 1;">
                        <label style="display: block; margin-bottom: 5px;">Priority</label>
                        <select name="priority" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" required>
                            <option value="low">Low</option>
                            <option value="medium" selected>Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 5px;">Report Details</label>
                    <textarea name="report-details" rows="4" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" required></textarea>
                </div>
                <button type="submit" style="background: #b6ad2b; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer;">
                    <i class="fas fa-plus"></i> Add Report
                </button>
            </form>
        </div>

        <table class="reports-table">
            <thead>
                <tr>
                    <th>Report ID</th>
                    <th>Type</th>
                    <th>Created By</th>
                    <th>Date</th>
                    <th>Priority</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($reports)): ?>
                    <tr>
                        <td colspan="6" class="no-data">No reports found</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($reports as $report): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($report['rep_id']); ?></td>
                            <td><?php echo htmlspecialchars($report['subject']); ?></td>
                            <td><?php echo htmlspecialchars($report['admin_name']); ?></td>
                            <td><?php echo date('d/m/Y H', strtotime($report['created_at'])); ?></td>
                            <td>
                                <span class="status-<?php echo ucfirst($report['priority']); ?>">
                                    <?php echo ucfirst($report['priority']); ?>
                                </span>
                            </td>
                            <td>
                                <button class="action-btn view-btn" onclick="viewReport('<?php echo $report['rep_id']; ?>')">
                                    <i class="fas fa-eye"></i> View
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Report View Modal -->
    <div id="reportModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
        <div style="position: relative; background: white; width: 80%; max-width: 800px; margin: 50px auto; padding: 20px; border-radius: 5px;">
            <span onclick="closeModal()" style="position: absolute; right: 20px; top: 10px; font-size: 24px; cursor: pointer;">&times;</span>
            <h2 id="modalTitle" style="margin-bottom: 20px;"></h2>
            <div style="margin-bottom: 15px;">
                <strong>Report ID:</strong> <span id="modalReportId"></span>
            </div>
            <div style="margin-bottom: 15px;">
                <strong>Created By:</strong> <span id="modalCreatedBy"></span>
            </div>
            <div style="margin-bottom: 15px;">
                <strong>Date:</strong> <span id="modalDate"></span>
            </div>
            <div style="margin-bottom: 15px;">
                <strong>Priority:</strong> <span id="modalPriority"></span>
            </div>
            <div style="margin-bottom: 15px;">
                <strong>Content:</strong>
                <div id="modalContent" style="margin-top: 10px; padding: 15px; background: #f8f9fa; border-radius: 4px;"></div>
            </div>
        </div>
    </div>
    
    <script>
        function viewReport(reportId) {
            // Find the report data
            const report = <?php echo json_encode($reports); ?>.find(r => r.rep_id === reportId);
            if (!report) return;

            // Update modal content
            document.getElementById('modalTitle').textContent = report.subject;
            document.getElementById('modalReportId').textContent = report.rep_id;
            document.getElementById('modalCreatedBy').textContent = report.admin_name;
            document.getElementById('modalDate').textContent = new Date(report.created_at).toLocaleString();
            document.getElementById('modalPriority').textContent = report.priority;
            document.getElementById('modalContent').textContent = report.content;

            // Show modal
            document.getElementById('reportModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('reportModal').style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('reportModal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>

</html>