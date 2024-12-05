<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue layout-top-nav" style="background-color: #f4f7fc; font-family: 'Arial', sans-serif; color: #333;">
<div class="wrapper" style="display: flex; flex-direction: column; align-items: center; margin: 0;">

  <?php include 'includes/navbar.php'; ?>
  <div class="content-wrapper" style="width: 85%; margin: 20px auto;">
    <div class="container" style="width: 100%; padding: 0 10px;">
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <!-- Welcome Section -->
          <div class="col-sm-12" style="text-align: center; margin-bottom: 40px;">
            <h2 style="font-size: 36px; font-weight: bold; color: #333; margin-bottom: 20px;">Welcome to Our Store!</h2>
            <p style="font-size: 18px; color: #555;">Explore a variety of products tailored to your needs. We offer high-quality products at affordable prices. Take a look at our featured collection!</p>
			<p style="font-size: 18px; color: #555;">To buy things go to Category and take what you want </p>
          </div>

          <!-- Featured Products Section -->
          <div class="col-sm-12" style="margin-bottom: 40px;">
            <h3 style="font-size: 28px; color: #333; margin-bottom: 20px; text-align: center;">Featured Products</h3>
            <div class="row" style="display: flex; justify-content: space-between;">
              <?php
                $conn = $pdo->open();
                try {
                  // Fetch a few featured products (limit to 6 items)
                  $stmt = $conn->prepare("SELECT * FROM products ORDER BY RAND() LIMIT 6");
                  $stmt->execute();
                  foreach ($stmt as $row) {
                    $image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/noimage.jpg';
                    echo "
                      <div class='col-sm-4' style='margin-bottom: 20px;'>
                        <div class='box box-solid' style='border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); transition: all 0.3s ease;'>
                          <div class='box-body prod-body' style='padding: 20px;'>
                            <img src='".$image."' width='100%' height='230px' class='thumbnail' style='border-radius: 8px;'>
                            <h5><a href='product.php?product=".$row['slug']."' style='text-decoration: none; color: #333; font-weight: bold;'>".$row['name']."</a></h5>
                          </div>
                          <div class='box-footer' style='text-align: center; background-color: #f9f9f9; border-radius: 0 0 8px 8px;'>
                            <b style='color: #ff9f00; font-size: 18px;'>DH ".number_format($row['price'], 2)."</b>
                          </div>
                        </div>
                      </div>
                    ";
                  }
                } catch(PDOException $e){
                  echo "There is some problem in connection: " . $e->getMessage();
                }
                $pdo->close();
              ?> 
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>

  
</div>

<?php include 'includes/scripts.php'; ?>
</body>
</html>
