<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require_once "../includes/config.php";

// Initialize variables
$member_id = isset($_GET['member_id']) ? $_GET['member_id'] : '';
$error = '';
$success = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $member_id = mysqli_real_escape_string($conn, $_POST['member_id']);
    $weight = mysqli_real_escape_string($conn, $_POST['weight']);
    $height = mysqli_real_escape_string($conn, $_POST['height']);
    $chest = mysqli_real_escape_string($conn, $_POST['chest']);
    $waist = mysqli_real_escape_string($conn, $_POST['waist']);
    $arms = mysqli_real_escape_string($conn, $_POST['arms']);
    $legs = mysqli_real_escape_string($conn, $_POST['legs']);
    
    $sql = "INSERT INTO measurements (p_no, weight, height, chest, waist, arms, legs) 
            VALUES ('$member_id', '$weight', '$height', '$chest', '$waist', '$arms', '$legs')";
    
    if (mysqli_query($conn, $sql)) {
        $success = "Measurements recorded successfully!";
    } else {
        $error = "Error recording measurements: " . mysqli_error($conn);
    }
}

// Fetch member details
$member_name = '';
if (!empty($member_id)) {
    $sql = "SELECT CONCAT(fname, ' ', lname) as name FROM people WHERE p_no = '$member_id'";
    $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $member_name = $row['name'];
    }
}

// Fetch measurement history
$measurements = [];
if (!empty($member_id)) {
    $sql = "SELECT * FROM measurements WHERE p_no = '$member_id' ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $measurements[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Measurements - Somali Fitness</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-4">
        <h2>Member Measurements</h2>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Record New Measurements</h5>
                    </div>
                    <div class="card-body">
                        <form action="measurements.php" method="POST">
                            <div class="mb-3">
                                <label for="member_id" class="form-label">Member</label>
                                <select name="member_id" class="form-control" required>
                                    <option value="">Select Member</option>
                                    <?php
                                    $sql = "SELECT p_no, fname, lname FROM people WHERE role = 'member' ORDER BY fname, lname";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $selected = $row['p_no'] == $member_id ? 'selected' : '';
                                        echo "<option value='{$row['p_no']}' $selected>";
                                        echo htmlspecialchars($row['fname'] . ' ' . $row['lname']);
                                        echo "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="weight" class="form-label">Weight (kg)</label>
                                <input type="number" step="0.1" name="weight" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="height" class="form-label">Height (cm)</label>
                                <input type="number" step="0.1" name="height" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="chest" class="form-label">Chest (cm)</label>
                                <input type="number" step="0.1" name="chest" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="waist" class="form-label">Waist (cm)</label>
                                <input type="number" step="0.1" name="waist" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="arms" class="form-label">Arms (cm)</label>
                                <input type="number" step="0.1" name="arms" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="legs" class="form-label">Legs (cm)</label>
                                <input type="number" step="0.1" name="legs" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Record Measurements</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Measurement History</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($measurements)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Weight</th>
                                            <th>Height</th>
                                            <th>Chest</th>
                                            <th>Waist</th>
                                            <th>Arms</th>
                                            <th>Legs</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($measurements as $m): ?>
                                        <tr>
                                            <td><?php echo date('M d, Y', strtotime($m['created_at'])); ?></td>
                                            <td><?php echo $m['weight']; ?> kg</td>
                                            <td><?php echo $m['height']; ?> cm</td>
                                            <td><?php echo $m['chest']; ?> cm</td>
                                            <td><?php echo $m['waist']; ?> cm</td>
                                            <td><?php echo $m['arms']; ?> cm</td>
                                            <td><?php echo $m['legs']; ?> cm</td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">No measurement history available.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
