<?php
session_start();

if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "admin") {
    // Redirect to login page or show unauthorized access message
    header("Location: login.php");
    exit();
}

include 'db.php';

// Retrieve property ID from the URL
$property_id = $_GET['id'];

// Validate and sanitize input data
$name = $description = $type = $price = "";
$name_err = $description_err = $type_err = $price_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Check for errors
    if (empty($name_err) && empty($description_err) && empty($type_err) && empty($price_err)) {
        // Prepare update query with parameterized values
        $update_sql = "UPDATE base_oils SET name=?, description=?, type=?, price=? WHERE id=?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("ssssi", $name, $description, $type, $price, $property_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header("Location: Adproducts.php");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }

} else {
    // Retrieve property details from the database
    $id = $_GET['id'];
    $select_sql = "SELECT * FROM base_oils WHERE id='$id'";
    $result = $conn->query($select_sql);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $description = $row['description'];
        $type = $row['type'];
        $price = $row['price'];

    } else {
        echo "Property not found";
    }
}

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Products</title>
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
                <h1>Update Products</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="admin.php">Admin Panel</a></li>
                    <li><a href="Adproducts.php">Back to Product List</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main content -->
    <main>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    
                    <h2>Update Product</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id; ?>" method="post">
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
                                <option value="base oils" <?php if ($type === "base oils") echo "selected"; ?>>base oils</option>

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
                        <button type="submit" class="btn btn-primary" name="submit">Update Product</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <p>&copy; 2024 Nancy Health Oils. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
