<?php
session_start();
require_once "../includes/config.php";

// Check if the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Get the current user data
$user_id = $_SESSION['id'];
$sql = "SELECT username, email FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);
$user_data = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission
    $new_email = $_POST['email'];
    $new_password = $_POST['password'];
    
    // Update user info in database
    if (!empty($new_email)) {
        $update_sql = "UPDATE users SET email = '$new_email' WHERE id = '$user_id'";
        mysqli_query($conn, $update_sql);
    }
    
    if (!empty($new_password)) {
        $new_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_sql = "UPDATE users SET password = '$new_password' WHERE id = '$user_id'";
        mysqli_query($conn, $update_sql);
    }

    // Redirect to avoid resubmission
    header("Location: settings.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Settings</h2>
        <form method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $user_data['email']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <input type="password" class="form-control" id="password" name="password">
                <small class="form-text text-muted">Leave empty if you don't want to change the password.</small>
            </div>

            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
</body>
</html>
