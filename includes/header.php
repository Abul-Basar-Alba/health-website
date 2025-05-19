<?php
//session_start();
include 'db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Nutrition Guide</title>
    <!-- <link rel="stylesheet" href="/health-website/assets/css/style.css"> -->
    <link rel="stylesheet" href="/assets/css/style.css">
     
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header>
        <nav>
            <div class="main-nav">
            <!-- <a href="/health-website/home.php" ><i class="fas fa-home"></i> Home</a> -->
              <a href="/home.php" ><i class="fas fa-home"></i> Home</a>
            <!-- <a href="/health-website/pages/docs.php" ><i class="fas fa-book"></i> Docs</a> -->
              <a href="/pages/docs.php" ><i class="fas fa-book"></i> Docs</a>
            <!-- <a href="/health-website/pages/nutrition.php" ><i class="fas fa-apple-alt"></i> Nutrition</a> -->
             <a href="/pages/nutrition.php" ><i class="fas fa-apple-alt"></i> Nutrition</a>
            <!-- <a href="/health-website/pages/recommendations.php" ><i class="fas fa-clipboard-list"></i> Recommendations</a> -->
             <a href="/pages/recommendations.php" ><i class="fas fa-clipboard-list"></i> Recommendations</a>
            <!-- <a href="/health-website/pages/about.php" ><i class="fas fa-info-circle"></i> About</a> -->
              <a href="/pages/about.php" ><i class="fas fa-info-circle"></i> About</a>
            <!-- <a href="/health-website/pages/contact.php" ><i class="fas fa-envelope"></i> Contact</a> -->
                <a href="/pages/contact.php" ><i class="fas fa-envelope"></i> Contact</a>
            <?php if (isset($_SESSION['id'])): ?>
                <!-- <a href="/health-website/logout.php" ><i class="fas fa-sign-out-alt"></i> Logout</a> -->
                 <a href="/logout.php" ><i class="fas fa-sign-out-alt"></i> Logout</a>
            <?php else: ?>
                <!-- <a href="/health-website/login.php" ><i class="fas fa-sign-in-alt"></i> Login</a> -->
                  <a href="/login.php" ><i class="fas fa-sign-in-alt"></i> Login</a>
                <!-- <a href="/health-website/signup.php" ><i class="fas fa-user-plus"></i> Sign Up</a> -->
                  <a href="/signup.php" ><i class="fas fa-user-plus"></i> Sign Up</a>
            <?php endif; ?>
            </div>
        </nav>
    </header>




    
