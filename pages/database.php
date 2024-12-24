<?php
session_start();
require_once "../includes/config.php";

// Check if the user is logged in and is an admin
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== 'admin') {
    header("location: login.php");
    exit;
}

// Fetch members list
$sql = "SELECT * FROM people WHERE role = 'member'";
$result = mysqli_query($conn, $sql);

// Handle delete member
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM people WHERE id = '$delete_id'";
    mysqli_query($conn, $delete_sql);
    header("Location: database.php");
    exit;
}

// Handle adding a new member
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_member'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $membership_type = $_POST['membership_type'];
    
    // Insert new member
    $insert_sql = "INSERT INTO people (name, email, membership_type, role) VALUES ('$name', '$email', '$membership_type', 'member')";
    mysqli_query($conn, $insert_sql);
    header("Location: database.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Database Management</h2>
        
        <!-- Add Member Form -->
        <h4>Add New Member</h4>
        <form method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="membership_type" class="form-label">Membership Type</label>
                <select class="form-control" id="membership_type" name="membership_type" required>
                    <option value="strength">Strength Training</option>
                    <option value="cardio">Cardio Fitness</option>
                    <option value="weight_loss">Weight Loss</option>
                    <option value="yoga">Yoga</option>
                </select>
            </div>
            <button type="submit" name="add_member" class="btn btn-primary">Add Member</button>
        </form>

        <h4 class="mt-5">Members List</h4>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Membership Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo ucfirst($row['membership_type']); ?></td>
                        <td>
                            <a href="?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
