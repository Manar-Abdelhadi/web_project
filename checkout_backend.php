<?php
include 'dbConnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // استلام البيانات من الفورم
    $username = mysqli_real_escape_string($conn, $_POST['fullname']);
    $useremail = mysqli_real_escape_string($conn, $_POST['email']);
    $shipping_address = mysqli_real_escape_string($conn, $_POST['shipping_address']);
    $billing_address = mysqli_real_escape_string($conn, $_POST['city']);
    $contact_phone = mysqli_real_escape_string($conn, $_POST['contact_phone']);
    $tracking_number = mysqli_real_escape_string($conn, $_POST['postal_code']);

    // التحقق من وجود المستخدم في جدول user
    $check_user_sql = "SELECT id FROM users WHERE name = '$username' AND email = '$useremail'";
    $user_result = mysqli_query($conn, $check_user_sql);

    if (mysqli_num_rows($user_result) > 0) {
        $user_row = mysqli_fetch_assoc($user_result);
        $user_id = $user_row['user_id'];
    } else {
        // إدخال مستخدم جديد
        $insert_user_sql = "INSERT INTO users (username, useremail) VALUES ('$username', '$useremail')";
        if (mysqli_query($conn, $insert_user_sql)) {
            $user_id = mysqli_insert_id($conn); // آخر ID تم إنشاؤه
        } else {
            die("❌ Error inserting user: " . mysqli_error($conn));
        }
    }

    // إدخال الطلب في جدول orders وربطه بـ user_id
    $insert_order_sql = "INSERT INTO orders (user_id, shipping_address, billing_address, contact_phone, tracking_number)
                                          VALUES ('$user_id', '$shipping_address', '$billing_address', '$contact_phone', '$tracking_number')";

    if (mysqli_query($conn, $insert_order_sql)) {
        echo "<h2>✅ Order Submitted Successfully!</h2>";
        echo "<p><strong>Name:</strong> $username</p>";
        echo "<p><strong>Email:</strong> $useremail</p>";
        echo "<p><strong>Phone:</strong> $contact_phone</p>";
        echo "<p><strong>Shipping:</strong> $shipping_address</p>";
        echo "<p><strong>Billing:</strong> $billing_address</p>";
        echo "<p><strong>Tracking:</strong> $tracking_number</p>";
    } else {
        echo "<h2>❌ Error inserting order: " . mysqli_error($conn) . "</h2>";
    }

    mysqli_close($conn);
} else {
    echo "<p>Invalid request method.</p>";
}
?>
