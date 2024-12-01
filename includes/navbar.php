<header class="main-header">
  <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);">
    <div class="container">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbar-collapse">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a href="index.php" class="nav-link" style="font-weight: bold;">HOME</a>
          </li>
          <li class="nav-item">
            <a href="about.php" class="nav-link">ABOUT US</a>
          </li>
          <li class="nav-item">
            <a href="contact.php" class="nav-link">CONTACT US</a>
          </li>
          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
              CATEGORY
            </a>
            <ul class="dropdown-menu">
              <?php
                $conn = $pdo->open();
                try {
                  $stmt = $conn->prepare("SELECT * FROM category");
                  $stmt->execute();
                  foreach($stmt as $row) {
                    echo "
                      <li><a class='dropdown-item' href='category.php?category=".$row['cat_slug']."'>".$row['name']."</a></li>
                    ";                   
                  }
                } catch(PDOException $e) {
                  echo "There is some problem in connection: " . $e->getMessage();
                }

                $pdo->close();
              ?>
            </ul>
          </li>
        </ul>

        <form method="POST" class="d-flex me-3" action="search.php">
          <div class="input-group">
            <input type="text" class="form-control" id="navbar-search-input" name="keyword" placeholder="Search for Product" required>
            <button type="submit" class="btn btn-outline-light">
              <i class="fa fa-search"></i>
            </button>
          </div>
        </form>

        <ul class="navbar-nav">
          <li class="nav-item dropdown me-3">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
              <i class="fa fa-shopping-cart"></i>
              <span class="badge bg-danger cart_count"></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li class="dropdown-header">You have <span class="cart_count"></span> item(s) in cart</li>
              <li><hr class="dropdown-divider"></li>
              <li id="cart_menu"></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="cart_view.php">Go to Cart</a></li>
            </ul>
          </li>

          <?php
            if(isset($_SESSION['user'])){
              $image = (!empty($user['photo'])) ? 'images/'.$user['photo'] : 'images/profile.jpg';
              echo '
                <li class="nav-item dropdown">
                  <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="'.$image.'" class="rounded-circle me-2" alt="User Image" style="width: 30px; height: 30px; object-fit: cover;">
                    '.$user['firstname'].' '.$user['lastname'].'
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li class="text-center py-2">
                      <img src="'.$image.'" class="rounded-circle mb-2" alt="User Image" style="width: 100px; height: 100px; object-fit: cover;">
                      <h6 class="mb-0">'.$user['firstname'].' '.$user['lastname'].'</h6>
                      <small class="text-muted">Member since '.date('M. Y', strtotime($user['created_on'])).'</small>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="profile.php"><i class="fa fa-user me-2"></i>Profile</a></li>
                    <li><a class="dropdown-item" href="logout.php"><i class="fa fa-sign-out me-2"></i>Sign out</a></li>
                  </ul>
                </li>
              ';
            }
            else {
              echo "
                <li class='nav-item'><a href='login.php' class='nav-link'>LOGIN</a></li>
                <li class='nav-item'><a href='signup.php' class='nav-link'>SIGNUP</a></li>
              ";
            }
          ?>
        </ul>
      </div>
    </div>
  </nav>
</header>

<!-- Include Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
