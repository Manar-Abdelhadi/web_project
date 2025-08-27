<?php
// Include database connection
include 'dbConnection.php';

$errors = array();
$success = "";

// Check if form was submitted
if (isset($_POST['signup'])) {
    // Get form inputs and trim
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    // Validate inputs
    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    if (empty($email)) {
        $errors[] = "Email is required.";
    }
    if (empty($password) || strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }
    if (empty($phone)) {
        $errors[] = "Phone number is required.";
    }

    // If no errors, continue
    if (empty($errors)) {
        // Check if email exists
        $checkQuery = "SELECT id FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($result) > 0) {
            $errors[] = "Email already exists.";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT); // keep password hidden
            $role = 'user'; 

            // Insert user
            $insertQuery = "INSERT INTO users (name, email, password, phone, address, role) 
                            VALUES ('$name', '$email', '$hashed_password', '$phone', '$address', '$role')";
            if (mysqli_query($conn, $insertQuery)) {
                $success = "Registration successful! <a href='login.php'>Login now</a>.";
            } else {
                $errors[] = "Error creating account.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f1f1f1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card {
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .btn-primary {
            background: #007bff;
            border: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card mt-4">
                <div class="card-body p-4">
                    <h3 class="text-center mb-3">Sign Up</h3>

                    <!-- Display errors -->
                    <?php if (!empty($errors)) { ?>
                        <div class="alert alert-danger">
                            <?php foreach ($errors as $error) { echo "<p>$error</p>"; } ?>
                        </div>
                    <?php } ?>

                    <!-- Display success -->
                    <?php if ($success) { ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php } ?>

                    <!-- Signup form -->
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="<?php if (isset($_POST['name'])) echo htmlspecialchars($_POST['name']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?php if (isset($_POST['email'])) echo htmlspecialchars($_POST['email']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="<?php if (isset($_POST['phone'])) echo htmlspecialchars($_POST['phone']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address (Optional)</label>
                            <input type="text" name="address" class="form-control" value="<?php if (isset($_POST['address'])) echo htmlspecialchars($_POST['address']); ?>">
                        </div>
                        <div class="text-center">
                            <button type="submit" name="signup" class="btn btn-primary w-100">Sign Up</button>
                        </div>
                        <p class="text-center mt-3">
                            Already have an account? <a href="login.php">Login</a>
                        </p>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>