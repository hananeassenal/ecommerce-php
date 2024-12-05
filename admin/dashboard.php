<?php
include 'includes/session.php';
include 'includes/header.php';
require_once('includes/DashboardStats.php');

if(isset($_GET['graph'])) {
    ob_clean();
    
    $stats = new DashboardStats();
    
    switch($_GET['graph']) {
        case 'monthly':
            $stats->generateMonthlySalesGraph();
            break;
        case 'category':
            $stats->generateCategoryPieChart();
            break;
    }
    exit();
}

$stats = new DashboardStats();
$totalStats = $stats->getTotalSales();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Panel</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/menubar.php'; ?>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Tableau de bord
                <small>Vue d'ensemble</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Accueil</a></li>
                <li class="active">Tableau de bord</li>
            </ol>
        </section>

        <section class="content">
            <!-- Résumé des statistiques -->
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3><?php echo number_format($totalStats['total_amount'], 2, ',', ' '); ?> €</h3>
                            <p>Total des ventes</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-shopping-cart"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3><?php echo $totalStats['total_transactions']; ?></h3>
                            <p>Nombre de transactions</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-shopping-bag"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Graphique des ventes -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Ventes mensuelles</h3>
                        </div>
                        <div class="box-body">
                            <?php
                            $timestamp = time();
                            echo '<img src="dashboard.php?graph=monthly&t='.$timestamp.'" 
                                      alt="Ventes mensuelles" 
                                      class="img-responsive center-block">';
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Graphique des catégories -->
                <div class="col-md-6">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Répartition par catégorie</h3>
                        </div>
                        <div class="box-body">
                            <?php
                            echo '<img src="dashboard.php?graph=category&t='.$timestamp.'" 
                                      alt="Répartition par catégorie" 
                                      class="img-responsive center-block">';
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Top des ventes -->
                <div class="col-md-6">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Top des ventes</h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Produit</th>
                                            <th class="text-center">Quantité</th>
                                            <th class="text-right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($stats->getTopProducts() as $product): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                                            <td class="text-center"><?php echo number_format($product['total_quantity']); ?></td>
                                            <td class="text-right"><?php echo number_format($product['total_sales'], 2, ',', ' '); ?> €</td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    
</div>

<?php include 'includes/scripts.php'; ?>
<script>
$(function(){
    // Actualiser les graphiques toutes les 5 minutes
    function refreshGraphs(){
        var timestamp = new Date().getTime();
        $('img[src*="graph="]').each(function(){
            var newSrc = this.src.split('&t=')[0] + '&t=' + timestamp;
            $(this).attr('src', newSrc);
        });
    }
    setInterval(refreshGraphs, 300000); // 5 minutes
});
</script>
</body>
</html>