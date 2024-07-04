<?php
session_start();
include 'db.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}


if (isset($_GET['action']) && $_GET['action'] == 'add') {
    $id = intval($_GET['id']);
    if (!isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] = 1;
    } else {
        $_SESSION['cart'][$id]++;
    }
    header('Location: cart.php');
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'remove') {
    $id = intval($_GET['id']);
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }
    header('Location: cart.php');
    exit();
}

$base_oils_sql = "SELECT * FROM base_oils";
$base_oils_result = $conn->query($base_oils_sql);

$consumables_sql = "SELECT * FROM consumables";
$consumables_result = $conn->query($consumables_sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nancy Health Oil</title>

    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
    <script src="script.js"></script>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
</head>
<body>
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
        <section class="products-section">
            <div class="container">
                <h2>Base Oils</h2>
                <div class="row">
                    <?php
                    if ($base_oils_result->num_rows > 0) {
                        while ($row = $base_oils_result->fetch_assoc()) {
                            echo '
                            <div class="col-md-4">
                                <div class="product-card">
                                    <img src="' . $row["image"] . '" alt="' . $row["name"] . '" class="img-fluid">
                                    <h3>' . $row["name"] . '</h3>
                                    <p>' . $row["description"] . '</p>
                                    <p><strong>Price:</strong> £' . $row["price"] . '</p>
                                    <a href="products.php?action=add&id=' . $row["id"] . '" class="btn btn-primary">Add to Cart</a>
                                </div>
                            </div>';
                        }
                    } else {
                        echo "<p>No base oils available.</p>";
                    }
                    ?>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="text-center text-lg-start bg-body-tertiary text-muted">
        <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
            <div class="me-5 d-none d-lg-block">
                <span>Get connected with us on social networks:</span>
            </div>
            <div>
                <a href="#" class="me-4 text-reset"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="me-4 text-reset"><i class="fab fa-twitter"></i></a>
                <a href="#" class="me-4 text-reset"><i class="fab fa-google"></i></a>
                <a href="#" class="me-4 text-reset"><i class="fab fa-instagram"></i></a>
                <a href="#" class="me-4 text-reset"><i class="fab fa-linkedin"></i></a>
                <a href="#" class="me-4 text-reset"><i class="fab fa-github"></i></a>
            </div>
        </section>
        <section class="">
            <div class="container text-center text-md-start mt-5">
                <div class="row mt-3">
                    <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mb-4">
                        <h6 class="text-uppercase fw-bold mb-4">
                            <i class="fas fa-home me-3"></i>Useful Links
                        </h6>
                        <p><a href="products.php" class="text-reset">Products</a></p>
                        <p><a href="DOTERRA.php" class="text-reset">DOTERRA</a></p>
                        <p><a href="about.php" class="text-reset">About Us</a></p>
                        <p><a href="index.php" class="text-reset">Home</a></p>
                    </div>
                    <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mb-4">
                        <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
                        <p><i class="fas fa-home me-3"></i> New York, NY 10012, US</p>
                        <p><i class="fas fa-envelope me-3"></i> NHO@gmail.com</p>
                        <p><i class="fas fa-phone me-3"></i> + 01 234 567 88</p>
                        <p><i class="fas fa-print me-3"></i> + 01 234 567 89</p>
                    </div>
                </div>
            </div>
        </section>
        <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">© 2024 Nancy Health Oils Limited. All rights reserved.</div>
    </footer>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
