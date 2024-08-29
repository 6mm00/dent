
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("sql110.infinityfree.com", "if0_37146993", " 2FdHIBSho3X", "if0_37146993_mywebsite");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT username, number, governorate, nearest_point, created_at FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $number, $governorate, $nearest_point, $created_at);
$stmt->fetch();
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental</title>
    <link rel="stylesheet" href="dental.css">
    <style>
        /* Styles for the user info box */
        .user-info {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            z-index: 1000;
            display: none;
        }

        .user-info p {
            margin: 10px 0;
        }

        .close-btn {
            background-color: #004a68;
            border: none;
            border-radius: 4px;
            color: #fff;
            padding: 10px 20px;
            cursor: pointer;
        }

        .close-btn:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>
    <div class="container">
        <nav>
            <a href="#" class="logo">1dental</a>
            <ul>
                <li><a href="Home.php">Home</a></li>
                <li><a href="Scrap.html">Scrap</a></li>
                <li><a href="Accessories.html">Accessories</a></li>
                <li><a href="Stethoscope.html">Stethoscope</a></li>
            </ul>
        </nav>
        <div class="menu">
            <li>
                <a href="#" class="line"><img src="menu.png" alt="menu" width="30px" height="30px"></a>
                <ul class="dropdown">
                    <li>
                        <?php
                        if (isset($_SESSION['username'])) {
                            echo '<a href="#" onclick="showUserInfo()">' . htmlspecialchars($_SESSION['username']) . '</a>';
                        }
                        ?>
                    </li>
                    <li><a href="cart.html" class="cart"><p><img src="shopping-bag.png" alt="cart" width="30px" height="30px"></p>Your Shopping</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact</a></li>
                    <li>
                        <?php
                        if (!isset($_SESSION['username'])) {
                            echo '<a href="login.php">Login</a>';
                        } else {
                            echo '<a href="logout.php">Logout</a>';
                        }
                        ?>
                    </li>
                    <li>
                        <?php
                        if (!isset($_SESSION['username'])) {
                            echo '<a href="signup.php">Sign Up</a>';
                        }
                        ?>
                    </li>
                </ul>
            </li>
        </div>
        <div class="text">
            <h1>Welcome to <br>1dental <br> store</h1>
            <p>where anything you need <br> on your medical journey</p>
        </div>
        <div class="photo">
            <img src="IMG_5830.PNG" alt="Dental Store">
        </div>
    </div>

    <!-- User info box -->
    <div class="user-info" id="user-info">
        <h2>User Information</h2>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
        <p><strong>Number:</strong> <?php echo htmlspecialchars($number); ?></p>
        <p><strong>Governorate:</strong> <?php echo htmlspecialchars($governorate); ?></p>


<p><strong>Nearest Point:</strong> <?php echo htmlspecialchars($nearest_point); ?></p>
        <p><strong>Member since:</strong> <?php echo htmlspecialchars($created_at); ?></p>
        <button class="close-btn" onclick="hideUserInfo()">Close</button>
    </div>

    <script>
        function showUserInfo() {
            document.getElementById('user-info').style.display = 'block';
        }

        function hideUserInfo() {
            document.getElementById('user-info').style.display = 'none';
        }
    </script>
</body>
</html>