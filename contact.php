<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> ecowebsite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }
        .contact-section {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            padding: 60px 0;
            margin-bottom: 30px;
        }
        .contact-info {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 30px;
        }
        .contact-form {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 30px;
        }
    </style>
</head>
<body>
    <div class="contact-section text-center">
    <?php include 'includes/navbar.php'; ?>
        <div class="container">
            <h1 class="display-4 mb-4">Contact Us</h1>
            <p class="lead">
                Have questions or need support? We're here to help!
            </p>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="contact-info">
                    <h3 class="mb-4">Contact Information</h3>
                    <div class="mb-3">
                        <h5><i class="fa fa-map-marker me-2"></i>Address</h5>
                        <p>123 Tech Lane, Innovation Park, City, Country</p>
                    </div>
                    <div class="mb-3">
                        <h5><i class="fa fa-phone me-2"></i>Phone</h5>
                        <p>+1 (555) 123-4567</p>
                    </div>
                    <div class="mb-3">
                        <h5><i class="fa fa-envelope me-2"></i>Email</h5>
                        <p>support@sourcecodesters.com</p>
                    </div>
                    <div>
                        <h5><i class="fa fa-clock-o me-2"></i>Business Hours</h5>
                        <p>Monday - Friday: 9 AM - 5 PM</p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="contact-form">
                    <h3 class="mb-4">Send us a Message</h3>
                    <form method="POST" action="submit_contact.php">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Your Message</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php include 'includes/scripts.php'; ?>
</html>