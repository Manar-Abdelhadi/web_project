<?php
session_start();

// إضافة منتج
if (isset($_POST['add_to_cart'])) {
    $product = [
        'name' => $_POST['product_name'],
        'price' => $_POST['price'],
        'quantity' => 1
    ];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['name'] === $product['name']) {
            $item['quantity']++;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION['cart'][] = $product;
    }

    header('Location: shop.php');
    exit();
}

// حذف منتج بالكامل
if (isset($_POST['remove_item'])) {
    $index = $_POST['remove_index'];
    if (isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
    header('Location: cart_view.php');
    exit();
}

// زيادة كمية منتج
if (isset($_POST['increase'])) {
    $index = $_POST['item_index'];
    if (isset($_SESSION['cart'][$index])) {
        $_SESSION['cart'][$index]['quantity']++;
    }
    header('Location: cart_view.php');
    exit();
}

// تقليل كمية منتج
if (isset($_POST['decrease'])) {
    $index = $_POST['item_index'];
    if (isset($_SESSION['cart'][$index]) && $_SESSION['cart'][$index]['quantity'] > 1) {
        $_SESSION['cart'][$index]['quantity']--;
    }
    header('Location: cart_view.php');
    exit();
}