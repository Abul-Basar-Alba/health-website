<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Health Nutrition Guide</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            background: url('assets/images/diet-background.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #64ffda;
            overflow-y: auto; /* Make the page scrollable */
        }

        .bg-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.7; /* Reduce opacity */
            z-index: -1; /* Place the image behind the content */
        }

        .content {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
        }

        .welcome-text {
            font-size: 4rem;
            margin-bottom: 2rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
            animation: fadeInUp 1s ease-out;
            font-weight: bold;
        }

        .sub-text {
            font-size: 1.8rem;
            margin-bottom: 2rem;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
            animation: fadeInUp 1s ease-out 0.5s;
            opacity: 0;
            animation-fill-mode: forwards;
            color: #8892b0;
        }

        .code-text {
            font-family: 'Courier New', monospace;
            color: #8892b0;
            margin-bottom: 2rem;
            animation: fadeInUp 1s ease-out 0.7s;
            opacity: 0;
            animation-fill-mode: forwards;
        }

        .auth-buttons {
            animation: fadeInUp 1s ease-out 1s;
            opacity: 0;
            animation-fill-mode: forwards;
        }

        .auth-buttons .btn {
            margin: 0 10px;
            padding: 12px 35px;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            border-radius: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .auth-buttons .btn-light {
            background: #64ffda;
            color: #0a192f;
            border: none;
        }

        .auth-buttons .btn-outline-light {
            border-color: #64ffda;
            color: #64ffda;
        }

        .auth-buttons .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(100, 255, 218, 0.3);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .typing-effect::after {
            content: '|';
            animation: blink 1s infinite;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0; }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <img src="assets/index_image/download.jpeg" alt="Diet Background" class="bg-image">

    <!-- Content -->
    <div class="content">
        <h1 class="welcome-text">Welcome to Health Nutrition Guide</h1>
        <p class="sub-text typing-effect">Explore our resources on nutrition, diet, and healthy living</p>
        <div class="auth-buttons">
            <a href="login.php" class="btn btn-light">Login</a>
            <a href="signup.php" class="btn btn-outline-light">Sign Up</a>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>