<?php include 'dbConnection.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Welcome to MultiShop</title>
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

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="style.css" rel="stylesheet">

    <!-- Entrance Page Custom CSS -->
    <style>
        .entrance-hero {
            position: relative;
            height: 100vh;
            min-height: 600px;
            background-size: cover;
            background-color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: rgb(0, 0, 0);
        }
        
        .entrance-content {
            max-width: 800px;
            padding: 0 20px;
        }
        
        .entrance-logo {
            margin-bottom: 30px;
        }
        
        .entrance-logo .logo-text {
            font-size: 4rem;
            font-weight: 700;
            text-transform: uppercase;
        }
        
        .entrance-logo .logo-primary {
            color: #000000;
            background-color: #ffffff;
        }
        
        .entrance-logo .logo-secondary {
            color: #ffffff;
            background-color: #ffe100;
        }
        
        .entrance-actions {
            margin-top: 40px;
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        
        .btn-entrance {
            background-color: #f7e815;
            color: rgb(0, 0, 0);
            padding: 12px 30px;
            font-size: 1.2rem;
            font-weight: 600;
            border-radius: 0;
            text-transform: uppercase;
            transition: all 0.3s;
            border: none;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-entrance:hover {
            background-color: #000000;
            color: #f7e815;
            transform: translateY(-3px);
        }
        
        .btn-entrance-secondary {
            background-color: #000000;
            color: #f7e815;
            padding: 12px 30px;
            font-size: 1.2rem;
            font-weight: 600;
            border-radius: 0;
            text-transform: uppercase;
            transition: all 0.3s;
            border: none;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-entrance-secondary:hover {
            background-color: #f7e815;
            color: #000000;
            transform: translateY(-3px);
        }
    </style>
</head>

<body>
    <!-- Entrance Hero Section -->
    <div class="entrance-hero">
        <div class="entrance-content">
            <div class="entrance-logo">
                <span class="logo-text logo-primary">Multi</span>
                <span class="logo-text logo-secondary">Shop</span>
            </div>
            <h1 class="display-4 mb-4"><b>Welcome to Our Online Store</b></h1>
            <p class="lead mb-5"><b>Discover amazing products at unbeatable prices</b></p>
            
            <div class="entrance-actions">
                <a href="login.php" class="btn btn-entrance">Login</a>
                <a href="signup.php" class="btn btn-entrance btn-entrance-secondary">Sign Up</a>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container-fluid pt-5" style="background-color: #f8f9fa;">
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Quality Product</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">Free Shipping</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">14-Day Return</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">24/7 Support</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>