<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_id = $_POST['course_id'];
    $applicant_name = $_POST['applicant_name'];
    $applicant_email = $_POST['applicant_email'];
    $phone_number = $_POST['phone_number'];

    // Validate input
    if (empty($course_id) || empty($applicant_name) || empty($applicant_email) || empty($phone_number)) {
        $error = "All fields are required!";
    } else {
        // Insert application into the database
        $stmt = $conn->prepare("INSERT INTO applications (course_id, applicant_name, applicant_email, phone_number) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $course_id, $applicant_name, $applicant_email, $phone_number);

        if ($stmt->execute()) {
            $success = "Your application has been submitted successfully!";
        } else {
            $error = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Fetch available courses
$courses = $conn->query("SELECT * FROM courses");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for a Course</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h2 class="text-center">Apply for a Course</h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error; ?></div>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?= $success; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="course_id" class="form-label">Select Course</label>
                <select name="course_id" id="course_id" class="form-select" required>
                    <option value="">Choose a course</option>
                    <?php while ($row = $courses->fetch_assoc()): ?>
                        <option value="<?= $row['id']; ?>"><?= $row['name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="applicant_name" class="form-label">Full Name</label>
                <input type="text" name="applicant_name" id="applicant_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="applicant_email" class="form-label">Email Address</label>
                <input type="email" name="applicant_email" id="applicant_email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" name="phone_number" id="phone_number" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit Application</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
