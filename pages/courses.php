<?php 
session_start();
include 'db_connect.php'; // Add database connection

// Handle course addition (Admin only)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_course'])) {
    // Get form data
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $icon = $_POST['icon'];

    // Prepare the SQL statement to insert the new course
    $stmt = $conn->prepare("INSERT INTO courses (name, description, price, icon) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $name, $description, $price, $icon);

    // Execute the query
    if ($stmt->execute()) {
        $_SESSION['message'] = "Course added successfully!";
    } else {
        $_SESSION['message'] = "Failed to add course.";
    }

    $stmt->close();

    // Redirect to the courses page
    header("Location: courses.php");
    exit;
}

// Fetch all courses
$result = $conn->query("SELECT * FROM courses");



// Debugging: Check if courses are found
if ($result->num_rows > 0) {
    // Courses found
    $courses = $result->fetch_all(MYSQLI_ASSOC);
} else {
    // No courses found
    $courses = [];
    $_SESSION['message'] = "No courses found.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses - Somali Fitness</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-4">
        <h2 class="text-center mb-4">Our Fitness Programs</h2>

        <!-- Display Success/Failure Message -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-info">
                <?php echo $_SESSION['message']; ?>
                <?php unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>

        <!-- Courses List -->
        <div class="row">
            <?php if (!empty($courses)): ?>
                <?php foreach ($courses as $course): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="text-center mb-3">
                                    <i class="fas <?php echo htmlspecialchars($course['icon']); ?> fa-3x text-primary"></i>
                                </div>
                                <h4 class="card-title text-center"><?php echo htmlspecialchars($course['name']); ?></h4>
                                <p class="card-text"><?php echo htmlspecialchars($course['description']); ?></p>
                            </div>
                            <div class="card-footer text-center">
                                <h5>$<?php echo number_format($course['price'], 2); ?></h5>
                                <a href="apply.php?course_id=<?php echo $course['id']; ?>" class="btn btn-success">Apply Now</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p>No courses available at the moment.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Admin: Add New Course -->
        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
            <div class="card mt-4">
                <div class="card-body">
                    <h4>Add New Course</h4>
                    <form method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Course Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" name="price" id="price" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="icon" class="form-label">Icon (FontAwesome Class)</label>
                            <input type="text" name="icon" id="icon" class="form-control" required>
                        </div>
                        <button type="submit" name="add_course" class="btn btn-primary">Add Course</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
