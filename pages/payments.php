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
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $payment_type = mysqli_real_escape_string($conn, $_POST['payment_type']);
    $months = mysqli_real_escape_string($conn, $_POST['months']);
    
    // Start transaction
    mysqli_begin_transaction($conn);
    
    try {
        // Insert into receipts
        $sql = "INSERT INTO receipts (p_no, amount, payment_type) VALUES ('$member_id', '$amount', '$payment_type')";
        if (!mysqli_query($conn, $sql)) {
            throw new Exception("Error recording payment: " . mysqli_error($conn));
        }
        
        // Update member's membership end date
        $sql = "UPDATE people SET 
                membership_end = DATE_ADD(GREATEST(CURDATE(), COALESCE(membership_end, CURDATE())), INTERVAL $months MONTH),
                status = 'active'
                WHERE p_no = '$member_id'";
        if (!mysqli_query($conn, $sql)) {
            throw new Exception("Error updating membership: " . mysqli_error($conn));
        }
        
        mysqli_commit($conn);
        $success = "Payment recorded successfully!";
    } catch (Exception $e) {
        mysqli_rollback($conn);
        $error = $e->getMessage();
    }
}

// Fetch payment history
$payments = [];
if (!empty($member_id)) {
    $sql = "SELECT r.*, p.fname, p.lname 
            FROM receipts r 
            JOIN people p ON r.p_no = p.p_no 
            WHERE r.p_no = '$member_id' 
            ORDER BY r.created_at DESC";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $payments[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments - Somali Fitness</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-4">
        <h2>Payment Management</h2>

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
                        <h5 class="card-title mb-0">Record Payment</h5>
                    </div>
                    <div class="card-body">
                        <form action="payments.php" method="POST">
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
                                <label for="amount" class="form-label">Amount ($)</label>
                                <input type="number" step="0.01" name="amount" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="payment_type" class="form-label">Payment Type</label>
                                <select name="payment_type" class="form-control" required>
                                    <option value="cash">Cash</option>
                                    <option value="card">Card</option>
                                    <option value="mobile">Mobile Money</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="months" class="form-label">Membership Duration (Months)</label>
                                <select name="months" class="form-control" required>
                                    <option value="1">1 Month</option>
                                    <option value="3">3 Months</option>
                                    <option value="6">6 Months</option>
                                    <option value="12">12 Months</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Record Payment</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Payment History</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($payments)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Member</th>
                                            <th>Amount</th>
                                            <th>Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($payments as $p): ?>
                                        <tr>
                                            <td><?php echo date('M d, Y', strtotime($p['created_at'])); ?></td>
                                            <td><?php echo htmlspecialchars($p['fname'] . ' ' . $p['lname']); ?></td>
                                            <td>$<?php echo number_format($p['amount'], 2); ?></td>
                                            <td><?php echo ucfirst($p['payment_type']); ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">No payment history available.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
