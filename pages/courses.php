<?php session_start(); ?>
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

        <div class="row">
            <!-- Strength Training -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <i class="fas fa-dumbbell fa-3x text-primary"></i>
                        </div>
                        <h4 class="card-title text-center">Strength Training</h4>
                        <p class="card-text">Build muscle, increase strength, and improve your overall fitness with our comprehensive strength training program.</p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i> Professional guidance</li>
                            <li><i class="fas fa-check text-success me-2"></i> Customized workout plans</li>
                            <li><i class="fas fa-check text-success me-2"></i> Progress tracking</li>
                        </ul>
                    </div>
                    <div class="card-footer text-center">
                        <h5>$50/month</h5>
                    </div>
                </div>
            </div>

            <!-- Cardio Fitness -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <i class="fas fa-running fa-3x text-danger"></i>
                        </div>
                        <h4 class="card-title text-center">Cardio Fitness</h4>
                        <p class="card-text">Improve your cardiovascular health and endurance with our specialized cardio programs.</p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i> Various cardio equipment</li>
                            <li><i class="fas fa-check text-success me-2"></i> Group classes</li>
                            <li><i class="fas fa-check text-success me-2"></i> Heart rate monitoring</li>
                        </ul>
                    </div>
                    <div class="card-footer text-center">
                        <h5>$40/month</h5>
                    </div>
                </div>
            </div>

            <!-- Weight Loss -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <i class="fas fa-weight-scale fa-3x text-success"></i>
                        </div>
                        <h4 class="card-title text-center">Weight Loss Program</h4>
                        <p class="card-text">Achieve your weight loss goals with our comprehensive program combining exercise and nutrition guidance.</p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i> Nutrition planning</li>
                            <li><i class="fas fa-check text-success me-2"></i> Regular assessments</li>
                            <li><i class="fas fa-check text-success me-2"></i> Support group</li>
                        </ul>
                    </div>
                    <div class="card-footer text-center">
                        <h5>$60/month</h5>
                    </div>
                </div>
            </div>

            <!-- Personal Training -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <i class="fas fa-user-tie fa-3x text-info"></i>
                        </div>
                        <h4 class="card-title text-center">Personal Training</h4>
                        <p class="card-text">Get one-on-one attention from our certified trainers to achieve your fitness goals faster.</p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i> Personalized attention</li>
                            <li><i class="fas fa-check text-success me-2"></i> Flexible scheduling</li>
                            <li><i class="fas fa-check text-success me-2"></i> Custom workout plans</li>
                        </ul>
                    </div>
                    <div class="card-footer text-center">
                        <h5>$30/session</h5>
                    </div>
                </div>
            </div>

            <!-- Yoga Classes -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <i class="fas fa-pray fa-3x text-warning"></i>
                        </div>
                        <h4 class="card-title text-center">Yoga Classes</h4>
                        <p class="card-text">Find balance and flexibility with our yoga classes suitable for all experience levels.</p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i> Expert instructors</li>
                            <li><i class="fas fa-check text-success me-2"></i> Multiple class types</li>
                            <li><i class="fas fa-check text-success me-2"></i> Meditation sessions</li>
                        </ul>
                    </div>
                    <div class="card-footer text-center">
                        <h5>$45/month</h5>
                    </div>
                </div>
            </div>

            <!-- Group Classes -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <i class="fas fa-users fa-3x text-secondary"></i>
                        </div>
                        <h4 class="card-title text-center">Group Classes</h4>
                        <p class="card-text">Join our energetic group classes for a fun and motivating workout experience.</p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i> Various class types</li>
                            <li><i class="fas fa-check text-success me-2"></i> Motivating atmosphere</li>
                            <li><i class="fas fa-check text-success me-2"></i> Social interaction</li>
                        </ul>
                    </div>
                    <div class="card-footer text-center">
                        <h5>$35/month</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Section -->
        <div class="row mt-4">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-body text-center">
                        <h4>Interested in our programs?</h4>
                        <p>Contact us for a free consultation and trial session!</p>
                        <a href="tel:+25261XXXXXXX" class="btn btn-primary me-2">
                            <i class="fas fa-phone"></i> Call Us
                        </a>
                        <a href="mailto:info@somalifitness.com" class="btn btn-secondary">
                            <i class="fas fa-envelope"></i> Email Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
