<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'car_inventory');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM cars WHERE id = $id");
    $car = $result->fetch_assoc();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $car_name = $_POST['car_name'];
        $manufacturing_year = $_POST['manufacturing_year'];
        $price = $_POST['price'];

        $stmt = $conn->prepare("UPDATE cars SET car_name = ?, manufacturing_year = ?, price = ? WHERE id = ?");
        $stmt->bind_param("sssi", $car_name, $manufacturing_year, $price, $id);

        if ($stmt->execute()) {
            header('Location: dashboard.php');
            exit;
        } else {
            $error = "Failed to update car.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Car</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="text-center mt-5">Edit Car</h2>
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <form method="POST">
                    <div class="form-group">
                        <label for="car_name">Car Name</label>
                        <input type="text" name="car_name" class="form-control" value="<?php echo $car['car_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="manufacturing_year">Manufacturing Year</label>
                        <input type="number" name="manufacturing_year" class="form-control" value="<?php echo $car['manufacturing_year']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" step="0.01" name="price" class="form-control" value="<?php echo $car['price']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-warning btn-block">Update Car</button>
                </form>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
