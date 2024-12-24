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
    <style>
        /* Full Page Background Image */
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        .background-image {
            background-image: url('assets/gym.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        /* Dark Theme Styles */
        body {
            background-color: #121212;
            color: #e1e1e1;
        }

        .jumbotron {
            background-color: rgba(0, 0, 0, 0.6);
            color: white;
            padding: 80px 0;
            text-shadow: 2px 2px 5px rgba(0,0,0,0.7);
        }

        .jumbotron h1 {
            font-size: 3.5rem;
            font-weight: bold;
        }

        .jumbotron p {
            font-size: 1.5rem;
        }

        .card {
            background-color: #333;
            border: none;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .card-body {
            text-align: center;
            color: #fff;
        }

        .card-title {
            font-size: 1.5rem;
            color: #fff;
        }

        .section-title {
            text-align: center;
            margin-bottom: 40px;
            font-size: 2.5rem;
            font-weight: bold;
            color: #e1e1e1;
        }

        .testimonial {
            background-color: #222;
            padding: 40px 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            margin-top: 60px;
        }

        .testimonial .quote {
            font-size: 1.25rem;
            font-style: italic;
            color: #bbb;
        }

        .testimonial .author {
            font-size: 1rem;
            font-weight: bold;
            margin-top: 10px;
            color: #e1e1e1;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 15px 30px;
            font-size: 1.2rem;
            border-radius: 30px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .footer {
            position: relative;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 15px;
        }

        .footer a {
            color: #007bff;
            text-decoration: none;
            margin: 0 ;
            
        }

        .footer a:hover {
            color: #0056b3;
        }

        /* Service Icons */
        .service-card {
            transition: transform 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .service-icon {
            font-size: 3rem;
            color: #007bff;
        }

        /* Mobile Adjustments */
        @media (max-width: 768px) {
            .jumbotron h1 {
                font-size: 2.5rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .testimonial {
                margin-top: 30px;
            }
        }
    </style>
</head>
<body>
    <!-- Background Image -->
    <div class="background-image"></div>

    <?php include 'pages/navbar.php'; ?>

    <div class="container mt-4">
        <!-- Jumbotron Section -->
        <div class="jumbotron text-center">
            <h1 class="display-4">Welcome to Somali Fitness Gym</h1>
            <p class="lead">Your journey to fitness starts here!</p>
            <hr class="my-4">
            <p>Join us today and transform your life with our state-of-the-art facilities and expert trainers.</p>
            <a class="btn btn-primary btn-lg" href="pages/about.php" role="button">Learn More</a>
        </div>

        <!-- Features Section -->
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card service-card">
                    <div class="card-body">
                        <i class="fas fa-dumbbell service-icon"></i>
                        <h5 class="card-title">Modern Equipment</h5>
                        <p class="card-text">Access to the latest fitness equipment and facilities to enhance your workout experience.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card service-card">
                    <div class="card-body">
                        <i class="fas fa-user-friends service-icon"></i>
                        <h5 class="card-title">Expert Trainers</h5>
                        <p class="card-text">Our professional trainers are here to guide you through every step of your fitness journey.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card service-card">
                    <div class="card-body">
                        <i class="fas fa-clock service-icon"></i>
                        <h5 class="card-title">Flexible Hours</h5>
                        <p class="card-text">We’re open 7 days a week with hours that fit your busy schedule.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Testimonials Section -->
        <div class="testimonial">
            <h2 class="section-title">What Our Members Say</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <p class="quote">"Joining Somali Fitness has been the best decision I've made for my health. The trainers are exceptional!"</p>
                            <p class="author">- Amina Ali</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <p class="quote">"The gym is equipped with everything I need, and the staff are always so friendly and supportive!"</p>
                            <p class="author">- Ahmed Yusuf</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <p class="quote">"I love the flexibility of the hours! It's so easy to fit in a workout no matter how busy my schedule is."</p>
                            <p class="author">- Fatima Mohamud</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <div class="footer">
        <p>Contact Us | <a href="mailto:info@somalifitness.com">info@somalifitness.com</a> | +252 61 770555718</p>
        <p>Follow Us: <a href="#" target="_blank">Facebook</a> | <a href="#" target="_blank">Instagram</a> | <a href="#" target="_blank">Twitter</a></p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
