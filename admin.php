<?php
session_start();

if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit();
}

// database connection
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="adminStyle.css?v=<?php echo time(); ?>">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
</head>

<body>
    <!-- Header -->
    <header>
        <div class="header-container">
            <div class="logo">
                <h1>Admin Panel</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="user.php">Users</a></li>
                    <li><a href="Adproducts.php">Products</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>


    <main>
    <main>
    <div class="container mt-5">
        <h2>Total Users</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Role</th>
                    <th>Total Users</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $user_count_sql = "SELECT role, COUNT(*) AS total_users FROM Users GROUP BY role";
                $user_count_result = $conn->query($user_count_sql);

                if ($user_count_result->num_rows > 0) {
                    while ($row = $user_count_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['role']}</td>";
                        echo "<td>{$row['total_users']}</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No users found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <h2>Total Products</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Total Products</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $product_count_sql = "SELECT type, COUNT(*) AS total_products FROM base_oils GROUP BY type";
                $property_count_result = $conn->query($product_count_sql);

                if ($property_count_result->num_rows > 0) {
                    while ($row = $property_count_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['type']}</td>";
                        echo "<td>{$row['total_products']}</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No Products found</td></tr>";
                }

                $product_count_sql = "SELECT type, COUNT(*) AS total_products FROM consumables GROUP BY type";
                $property_count_result = $conn->query($product_count_sql);

                if ($property_count_result->num_rows > 0) {
                    while ($row = $property_count_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['type']}</td>";
                        echo "<td>{$row['total_products']}</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No Products found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</main>

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

        <!-- Copyright -->
        <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
            © 2024 Nancy Health Oils Limited. All rights reserved.

        </div>
        <!-- Copyright -->
    </footer>
</body>

</html>