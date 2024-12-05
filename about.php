<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About ecowebsite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        /* Custom styles */
        body {
            background-color: #f4f6f9;
        }

        .navbar {
            margin-top: 0;
            padding-top: 0;
        }

        .about-section {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            padding: 60px 0;
            margin-bottom: 30px;
        }

        .about-section h1 {
            font-size: 3rem;
        }

        .about-section .lead {
            font-size: 1.25rem;
        }

        /* Mission and Vision Section */
        .mission-vision-section {
            margin-top: 30px;
        }

        .mission-vision-section h2 {
            font-size: 2rem;
        }

        .mission-vision-section p {
            font-size: 1.1rem;
        }

        /* Footer styling */
        .footer {
            background-color: #f8f9fa;
            padding: 20px 0;
            margin-top: 50px;
        }
    </style>
</head>
<body>

    <!-- About Section -->
    <div class="about-section text-center">
    <?php include 'includes/navbar.php'; ?>
        <div class="container">
            <h1 class="display-4 mb-4">About Us</h1>
            <p class="lead">
                We are a passionate team dedicated to delivering innovative materials  
                and exceptional e-commerce experiences.
            </p>
        </div>
    </div>

    <!-- Mission and Vision Section -->
    <div class="container mission-vision-section">
        <div class="row">
            <div class="col-md-6">
                <h2 class="mb-4">Our Mission</h2>
                <p>
                    At our website, we strive to create cutting-edge technological solutions 
                    that empower businesses and individuals. Our focus is on developing user-friendly, 
                    efficient, and scalable e-commerce platforms that transform the way people shop online.
                </p>
            </div>
            <div class="col-md-6">
                <h2 class="mb-4">Our Vision</h2>
                <p>
                    We envision a digital marketplace where technology meets creativity, 
                    making online shopping seamless, secure, and enjoyable. Our commitment 
                    is to continuously innovate and provide solutions that exceed customer expectations.
                </p>
            </div>
        </div>

        <!-- Team Section (without images) -->
        <div class="row mt-5">
            <div class="col-12 text-center mb-4">
                <h2>Our Team</h2>
            </div>
            <div class="col-md-4">
                <div class="team-member text-center">
                    <h4>Ibtissam Ech Chaibi</h4>
                    <p class="text-muted">Founder & CEO</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="team-member text-center">
                    <h4>Hanane Assendal</h4>
                    <p class="text-muted">Chief Technology Officer</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="team-member text-center">
                    <h4>Manar lmnour </h4>
                    <p class="text-muted">Lead Developer</p>
                </div>
            </div>
        </div>
    </div>

    

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php include 'includes/scripts.php'; ?>
</html>
