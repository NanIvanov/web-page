<?php
session_start();
include 'db.php';

// Handle remove action
if (isset($_GET['action']) && $_GET['action'] == 'remove') {
    $id = intval($_GET['id']);
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }
    header('Location: cart.php'); // Redirect to the cart page to reflect changes
    exit();
}

// Fetch product details for items in the cart
$cart_items = [];
if (!empty($_SESSION['cart'])) {
    $ids = implode(",", array_keys($_SESSION['cart']));
    $cart_sql = "SELECT * FROM base_oils WHERE id IN ($ids)";
    $cart_result = $conn->query($cart_sql);

    while ($row = $cart_result->fetch_assoc()) {
        $cart_items[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
        <div class="container">
            <h2>Your Cart</h2>
            <?php if (!empty($cart_items)): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total_price = 0;
                        foreach ($cart_items as $item) {
                            $id = $item['id'];
                            $quantity = $_SESSION['cart'][$id];
                            $total = $item['price'] * $quantity;
                            $total_price += $total;

                            echo '
                            <tr>
                                <td>' . $item["name"] . '</td>
                                <td>' . $quantity . '</td>
                                <td>£' . $item["price"] . '</td>
                                <td>£' . $total . '</td>
                                <td><a href="cart.php?action=remove&id=' . $id . '" class="btn btn-danger">Remove</a></td>
                            </tr>';
                        }
                        ?>
                        <tr>
                            <td colspan="3" class="text-right"><strong>Total Price:</strong></td>
                            <td>£<?php echo $total_price; ?></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Your cart is empty.</p>
            <?php endif; ?>
        </div>
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
