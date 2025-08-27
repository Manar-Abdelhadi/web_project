<?php
// Connect to database
include 'dbConnection.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $role = $_POST['role'];
    // Simple direct query
    $sql = "UPDATE users SET role = '$role' WHERE id = '$id'";    
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "error";
    }
    exit;
}

// Get all users with role
$query = "SELECT id, name, email, role FROM users";
$result = mysqli_query($conn, $query);
if (!$result) {
    // Display error directly in the browser for debugging (remove in production)
    echo "Error fetching users: " . mysqli_error($conn) . "<br>";
    $users = [];
} else {
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
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

        .status-active {
            background-color: #d4edda;
            color: #155724;
        }

        .status-inactive {
            background-color: #f8d7da;
            color: #721c24;
        }

        .status-banned {
            background-color: #fff3cd;
            color: #856404;
        }

        /* Action Buttons */
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

        .ban-btn {
            background-color: #f8d7da;
            color: #721c24;
        }

        .ban-btn:hover {
            background-color: #f78181;
        }

        .unban-btn {
            background-color: #d4edda;
            color: #155724;
        }

        .unban-btn:hover {
            background-color: #65f386;
        }

        .action-btn i {
            margin-right: 5px;
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
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
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

        .card-icon.users {
            background-color: #4e73df;
        }

        .card-icon.active {
            background-color: #1cc88a;
        }

        .card-icon.banned {
            background-color: #e74a3b;
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

        /* Role Dropdown Style */
        .role-dropdown {
            padding: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
            background-color: #fff;
            font-size: 14px;
            cursor: pointer;
            width: 100px; /* Adjusted width for better appearance */
        }

        .role-dropdown:focus {
            outline: none;
            border-color: #f7e815;
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
        <h1 class="page-title">USERS</h1>

        <!-- Dashboard Cards -->
        <div class="dashboard-cards">
            <div class="card">
                <div class="card-header">
                    <div class="card-icon users">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <p class="card-title">TOTAL USERS</p>
                        <p class="card-value"><?php echo count($users); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tables Section -->
        <div class="tables-section">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($users as $user) {
                            echo "<tr>";
                            echo "<td>" . $user['id'] . "</td>";
                            echo "<td>" . $user['name'] . "</td>";
                            echo "<td>" . $user['email'] . "</td>";
                            echo "<td>";
                            echo "<select onchange='updateRole(" . $user['id'] . ", this.value)'>";
                            if($user['role'] == 'admin') {
                                echo "<option value='admin' selected>Admin</option>";
                                echo "<option value='user'>User</option>";
                            } else {
                                echo "<option value='admin'>Admin</option>";
                                echo "<option value='user' selected>User</option>";
                            }
                            echo "</select>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
<script>
    // Highlight the active sidebar link based on current page
    document.addEventListener('DOMContentLoaded', function() {
        const navLinks = document.querySelectorAll('.nav-menu a');
        const currentPath = window.location.pathname.split('/').pop();
        navLinks.forEach(link => {
            const linkPath = link.getAttribute('href').split('/').pop();
            if (linkPath === currentPath) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
    });

    function updateRole(id, role) {
        fetch('', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'id=' + id + '&role=' + role
        })
        .then(response => response.text())
        .then(result => {
            if(result == 'success') {
                alert('Role updated successfully');
            } else {
                alert('Error updating role');
            }
        });
    }
</script>
</html>
<?php
mysqli_close($conn);
?>