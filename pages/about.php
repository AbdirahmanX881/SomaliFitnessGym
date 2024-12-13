<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Somali Fitness</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center mb-4">About Somali Fitness</h2>
                        
                        <div class="mb-4">
                            <h4>Our Mission</h4>
                            <p>At Somali Fitness, our mission is to promote health and wellness in our community through professional fitness training and guidance. We believe in making fitness accessible to everyone while maintaining the highest standards of service and equipment.</p>
                        </div>

                        <div class="mb-4">
                            <h4>Our Facilities</h4>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-dumbbell me-2"></i> State-of-the-art equipment</li>
                                <li><i class="fas fa-heart me-2"></i> Cardio zone</li>
                                <li><i class="fas fa-users me-2"></i> Group fitness classes</li>
                                <li><i class="fas fa-user-tie me-2"></i> Personal training</li>
                                <li><i class="fas fa-shower me-2"></i> Modern locker rooms</li>
                            </ul>
                        </div>

                        <div class="mb-4">
                            <h4>Our Team</h4>
                            <p>Our team consists of certified fitness trainers and nutrition experts who are passionate about helping our members achieve their fitness goals. Each trainer brings unique expertise and experience to provide personalized guidance and support.</p>
                        </div>

                        <div class="mb-4">
                            <h4>Operating Hours</h4>
                            <ul class="list-unstyled">
                                <li><strong>Monday - Friday:</strong> 6:00 AM - 10:00 PM</li>
                                <li><strong>Saturday:</strong> 7:00 AM - 8:00 PM</li>
                                <li><strong>Sunday:</strong> 8:00 AM - 6:00 PM</li>
                            </ul>
                        </div>

                        <div>
                            <h4>Contact Us</h4>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-phone me-2"></i> +252 61 XXX XXXX</li>
                                <li><i class="fas fa-envelope me-2"></i> info@somalifitness.com</li>
                                <li><i class="fas fa-map-marker-alt me-2"></i> Mogadishu, Somalia</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
