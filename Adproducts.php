<?php
session_start();

if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit();
}

// Include database connection
include 'db.php';

// Fetch properties from the database
$sql = "SELECT * FROM base_oils";
$properties_result = $conn->query($sql);

// Function to sanitize input data
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Process delete request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_property_id'])) {
    $property_id = sanitize_input($_POST['delete_property_id']);

    // Prepare SQL statement to delete property
    $delete_sql = "DELETE FROM base_oils WHERE id = $property_id";
    if ($conn->query($delete_sql) === TRUE) {
        // Redirect to same page to refresh property list
        header("Location: Adproducts.php");
        exit();
    } else {
        // Error handling if delete operation fails
        echo "Error deleting record: " . $conn->error;
    }
}

// Initialize variables for form validation
$name = $description = $type = $price = "";
$name_err = $description_err = $type_err = $price_err = "";

// Process form data when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Validate name
    if (empty($_POST["name"])) {
        $name_err = "Name is required";
    } else {
        $name = sanitize_input($_POST["name"]);
    }

    // Validate description
    if (empty($_POST["description"])) {
        $description_err = "Description is required";
    } else {
        $description = sanitize_input($_POST["description"]);
    }

    // Validate type
    if (empty($_POST["type"])) {
        $type_err = "Type is required";
    } else {
        $type = sanitize_input($_POST["type"]);
    }

    // Validate price
    if (empty($_POST["price"])) {
        $price_err = "Price is required";
    } else {
        $price = sanitize_input($_POST["price"]);
    }

    // Image upload handling
    $image_path = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_name = basename($_FILES['image']['name']);
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $target_dir = "uploads/";
        $image_path = $target_dir . $image_name;

        // Ensure the target directory exists
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Move the uploaded file to the target directory
        if (move_uploaded_file($image_tmp_name, $image_path)) {
            // File uploaded successfully
        } else {
            // Error uploading file
            echo "Error uploading image";
        }
    }

    // If all fields are filled then insert new property into database
    if (empty($name_err) && empty($description_err) && empty($type_err) && empty($price_err)) {
        // Prepare SQL statement to insert new property
        $insert_sql = "INSERT INTO base_oils (name, description, type, price, image) VALUES ('$name', '$description', '$type', '$price', '$image_path')";

        if ($conn->query($insert_sql) === TRUE) {
            // Redirect to same page to refresh property list
            header("Location: Adproducts.php");
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
    <title>Product Management - nancy_health_oils</title>
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
                <h1>Products Management</h1>
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
            <h2>Product List</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($properties_result->num_rows > 0) {
                        while ($row = $properties_result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>{$row['id']}</td>";
                            echo "<td>{$row['name']}</td>";
                            echo "<td>{$row['description']}</td>";
                            echo "<td>{$row['type']}</td>";
                            echo "<td>{$row['price']}</td>";
                            echo "<td><img src='{$row['image']}' height='100' width='100'></td>";
                            echo "<td>";
                            echo "<a href='UpdateProperty.php?id={$row['id']}' class='btn btn-primary'>Update</a>";
                            echo "<form method='post' style='display:inline-block'>";
                            echo "<input type='hidden' name='delete_property_id' value='{$row['id']}' />";
                            echo "<button type='submit' class='btn btn-danger'>Delete</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10'>No products found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <h2>Add New Product</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>">
                    <span class="text-danger"><?php echo $name_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description"><?php echo $description; ?></textarea>
                    <span class="text-danger"><?php echo $description_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="type">Type</label>
                    <select class="form-control" id="type" name="type">
                        <option value="base oils">Base Oils</option>
                    </select>
                    <span class="text-danger"><?php echo $type_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" class="form-control" id="price" name="price" value="<?php echo $price; ?>">
                    <span class="text-danger"><?php echo $price_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" class="form-control-file" id="image" name="image">
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Add Product</button>
            </form>
        </div>

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
