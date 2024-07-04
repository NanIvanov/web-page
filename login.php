<?php
// database connection
include 'db.php';

$error_message = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username and password
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Prepare SQL statement to fetch user from database
    $sql = "SELECT * FROM Users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    // Check if user exists and password is correct
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $role = $row['role'];
        session_start();
        $_SESSION["username"] = $username;
        $_SESSION["role"] = $role;

        if ($role === 'admin') {
            header("Location: admin.php");
            exit();
        } else {
            header("Location: index.php");
            exit();
        }
    } else {
        $error_message = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Nancy Health Oils</title>
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
</head>

<body>
    <!-- Header -->
    <header>
        <div class="header-container">
            <div class="logo">
                <img src="Images/logo.png" alt="Logo">
                <h1>NANCY HEALTH OILS</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About us</a></li>
                    <li><a href="products.php">Products</a></li>
                    <li><a href="DOTERRA.php">DOTERRA</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                    <li><a href="admin.php">Admin</a></li>
                    <li><a href="cart.php">Cart</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="login-container">
            <h2>Login</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="username">Username:</label><br>
                <input type="text" id="username" name="username" required><br>
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" required><br><br>
                <input type="submit" value="Login">
            </form>
            <?php if (isset($error_message)) {
                echo "<p>$error_message</p>";
            } ?>
        </div>
    </main>

   <!-- Footer -->
   <footer class="text-center text-lg-start bg-body-tertiary text-muted">
        <!-- Section: Social media -->
        <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
            <!-- Left -->
            <div class="me-5 d-none d-lg-block">
                <span>Get connected with us on social networks:</span>
            </div>
            <!-- Left -->

            <!-- Right -->
            <div>
                <a href="#" class="me-4 text-reset">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="me-4 text-reset">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="me-4 text-reset">
                    <i class="fab fa-google"></i>
                </a>
                <a href="#" class="me-4 text-reset">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="me-4 text-reset">
                    <i class="fab fa-linkedin"></i>
                </a>
                <a href="#" class="me-4 text-reset">
                    <i class="fab fa-github"></i>
                </a>
            </div>
            <!-- Right -->
        </section>
        <!-- Section: Social media -->

        <!-- Section: Links  -->
        <section class="">
            <div class="container text-center text-md-start mt-5">
                <!-- Grid row -->
                <div class="row mt-3">
                    <!-- Grid column -->
                    <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mb-4">
                        <!-- Content -->
                        <h6 class="text-uppercase fw-bold mb-4">
                            <i class="fas fa-home me-3"></i>Useful Links
                        </h6>
                        <p>
                            <a href="products.php" class="text-reset">Products</a>
                        </p>
                        <p>
                            <a href="DOTERRA.php" class="text-reset">DOTERRA</a>
                        </p>
                        <p>
                            <a href="about.php" class="text-reset">About Us</a>
                        </p>
                        <p>
                            <a href="index.php" class="text-reset">Home</a>
                        </p>
                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mb-4">
                        <!-- Content -->
                        <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
                        <p><i class="fas fa-home me-3"></i> New York, NY 10012, US</p>
                        <p>
                            <i class="fas fa-envelope me-3"></i>
                            NHO@gmail.com
                        </p>
                        <p><i class="fas fa-phone me-3"></i> + 01 234 567 88</p>
                        <p><i class="fas fa-print me-3"></i> + 01 234 567 89</p>
                    </div>
                    <!-- Grid column -->
                </div>
                <!-- Grid row -->
            </div>
        </section>
        <!-- Section: Links  -->

        <!-- Copyright -->
        <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
            © 2024 Nancy Health Oils Limited. All rights reserved.

        </div>
        <!-- Copyright -->
    </footer>
    <!-- Footer -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="script.js"></script>


</body>

</html>
