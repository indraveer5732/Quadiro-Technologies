<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'car_inventory');
$result = $conn->query("SELECT * FROM cars");
$total_cars = $result->num_rows;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="text-center mt-5">Admin Dashboard</h2>
        <div class="mt-3">
            <a href="create_car.php" class="btn btn-success">Add New Car</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
        <div class="mt-3">
            <h4>Total Cars: <?php echo $total_cars; ?></h4>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Car Name</th>
                        <th>Manufacturing Year</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['car_name']; ?></td>
                            <td><?php echo $row['manufacturing_year']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                            <td>
                                <a href="update_car.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                                <a href="delete_car.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
