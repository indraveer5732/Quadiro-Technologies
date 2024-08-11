<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'car_inventory');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $car_name = $_POST['car_name'];
    $manufacturing_year = $_POST['manufacturing_year'];
    $price = $_POST['price'];

    $stmt = $conn->prepare("INSERT INTO cars (car_name, manufacturing_year, price) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $car_name, $manufacturing_year, $price);

    if ($stmt->execute()) {
        $success = "Car added successfully!";
    } else {
        $error = "Failed to add car.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Car</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="text-center mt-5">Add New Car</h2>
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <form method="POST">
                    <div class="form-group">
                        <label for="car_name">Car Name</label>
                        <input type="text" name="car_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="manufacturing_year">Manufacturing Year</label>
                        <input type="number" name="manufacturing_year" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" step="0.01" name="price" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Add Car</button>
                </form>
                <?php if (isset($success)): ?>
                    <div class="alert alert-success mt-3"><?php echo $success; ?></div>
                <?php endif; ?>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
