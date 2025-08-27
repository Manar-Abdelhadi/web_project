<?php
include 'dbConnection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $deleteSql = "DELETE FROM products WHERE id = $id";
         mysqli_query($conn, $deleteSql);
}

header("Location: admin_products.php");
exit;
?>