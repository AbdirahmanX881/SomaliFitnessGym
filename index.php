<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Somali Fitness Gym</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'pages/navbar.php'; ?>

    <div class="container mt-4">
        <div class="jumbotron text-center">
            <h1 class="display-4">Welcome to Somali Fitness Gym</h1>
            <p class="lead">Your journey to fitness starts here!</p>
            <hr class="my-4">
            <p>Join us today and transform your life with our state-of-the-art facilities and expert trainers.</p>
            <a class="btn btn-primary btn-lg" href="pages/about.php" role="button">Learn More</a>
        </div>

        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-dumbbell"></i> Modern Equipment</h5>
                        <p class="card-text">Access to the latest fitness equipment and facilities.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-user-friends"></i> Expert Trainers</h5>
                        <p class="card-text">Professional trainers to guide you through your fitness journey.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-clock"></i> Flexible Hours</h5>
                        <p class="card-text">Open 7 days a week with convenient hours.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
