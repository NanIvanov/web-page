<?php
session_start();

if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit();
}

// database connection
include 'db.php';

// Fetch users from the database
$sql = "SELECT * FROM Users";
$users_result = $conn->query($sql);

// Function to sanitize input data
function sanitize_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Process delete request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_user_id'])) {
    // Sanitize the user ID
    $user_id = sanitize_input($_POST['delete_user_id']);

    // Prepare SQL statement to delete user
    $delete_sql = "DELETE FROM Users WHERE user_id = $user_id";
    if ($conn->query($delete_sql) === TRUE) {
        // Redirect to same page to refresh user list
        header("Location: user.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}



// Initialize variables for form validation
$username = $email = $password = $role = "";
$username_err = $email_err = $password_err = $role_err = "";

// Process form data when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate username
    if (empty($_POST["username"])) {
        $username_err = "Username is required";
    } else {
        $username = sanitize_input($_POST["username"]);
    }

    // Validate email
    if (empty($_POST["email"])) {
        $email_err = "Email is required";
    } else {
        $email = sanitize_input($_POST["email"]);
        // Check if email is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email format";
        }
    }

    // Validate password
    if (empty($_POST["password"])) {
        $password_err = "Password is required";
    } else {
        $password = sanitize_input($_POST["password"]);
    }

    // Validate role
    if (empty($_POST["role"])) {
        $role_err = "Role is required";
    } else {
        $role = sanitize_input($_POST["role"]);
    }

    // If all fields are filled, insert new user into database
    if (empty($username_err) && empty($email_err) && empty($password_err) && empty($role_err)) {
        // Hash password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL statement to insert new user
        $insert_sql = "INSERT INTO Users (username, email, password, role) VALUES ('$username', '$email', '$hashed_password', '$role')";
        if ($conn->query($insert_sql) === TRUE) {
            // Redirect to same page to refresh user list
            header("Location: user.php");
            exit();
        } else {
            // Error handling if insert operation fails
            echo "Error: " . $insert_sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="adminStyle.css?v=<?php echo time(); ?>">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
</head>

<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <h1>User Management</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="admin.php">Admin Panel</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main content -->
    <main>
        <div class="container mt-5">
            <h2>User List</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($users_result->num_rows > 0) {
                        while ($row = $users_result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>{$row['user_id']}</td>";
                            echo "<td>{$row['username']}</td>";
                            echo "<td>{$row['email']}</td>";
                            echo "<td>{$row['role']}</td>";
                            echo "<td>";
                            echo "<a href='UpdateUser.php?id={$row['user_id']}' class='btn btn-primary'>Update</a>";
                            echo "<form method='post'>";
                            echo "<input type='hidden' name='delete_user_id' value='{$row['user_id']}' />";
                            echo "<button type='submit' class='btn btn-danger'>Delete</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No users found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>


            <h2>Add New User</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>">
                    <span class="text-danger"><?php echo $username_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
                    <span class="text-danger"><?php echo $email_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" value="<?php echo $password; ?>">
                    <span class="text-danger"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select class="form-control" id="role" name="role">
                        <option value="" selected disabled>Select Role</option>
                        <option value="user" <?php if ($role === "user") echo "selected"; ?>>User</option>
                        <option value="admin" <?php if ($role === "admin") echo "selected"; ?>>Admin</option>
                    </select>
                    <span class="text-danger"><?php echo $role_err; ?></span>
                </div>
                <button type="submit" class="btn btn-primary">Add User</button>
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