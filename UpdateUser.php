<?php
session_start();

if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit();
}

include 'db.php';

if (!isset($_GET["id"]) || empty($_GET["id"])) {
    header("Location: user.php");
    exit();
}

$user_id = $_GET["id"];
$sql = "SELECT * FROM Users WHERE user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    header("Location: user.php");
    exit();
}

$user = $result->fetch_assoc();

$username = $email = $password = $role = "";
$username_err = $email_err = $password_err = $role_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $role = $_POST["role"];

    if (empty($username)) {
        $username_err = "Username is required";
    }

    if (empty($email)) {
        $email_err = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid email format";
    }

    if (empty($password)) {
        $password_err = "Password is required";
    }

    if (empty($role)) {
        $role_err = "Role is required";
    }

    if (empty($username_err) && empty($email_err) && empty($password_err) && empty($role_err)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $update_sql = "UPDATE Users SET username = '$username', email = '$email', password = '$hashed_password', role = '$role' WHERE user_id = $user_id";
        if ($conn->query($update_sql) === TRUE) {
            header("Location: user.php");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="stylesheet" href="adminStyle.css?v=<?php echo time(); ?>">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
</head>

<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <h1>Update User</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="user.php">Back to User List</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="container mt-5">
            <h2>Update User Details</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=$user_id"); ?>" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username']; ?>">
                    <span class="text-danger"><?php echo $username_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>">
                    <span class="text-danger"><?php echo $email_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" value="">
                    <span class="text-danger"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select class="form-control" id="role" name="role">
                        <option value="" disabled>Select Role</option>
                        <option value="user" <?php if ($user['role'] === "user") echo "selected"; ?>>User</option>
                        <option value="admin" <?php if ($user['role'] === "admin") echo "selected"; ?>>Admin</option>
                    </select>
                    <span class="text-danger"><?php echo $role_err; ?></span>
                </div>
                <button type="submit" class="btn btn-primary">Update User</button>
            </form>
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

        <!-- Copyright -->
        <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
            © 2024 Nancy Health Oils Limited. All rights reserved.

        </div>
        <!-- Copyright -->
    </footer>
</body>

</html>
