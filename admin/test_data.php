// Créez un fichier test_data.php dans admin/
<?php
include 'includes/session.php';
require_once('includes/DashboardStats.php');

$stats = new DashboardStats();

echo "<pre>";
echo "Total des ventes :\n";
print_r($stats->getTotalSales());

echo "\nProduits les plus vendus :\n";
print_r($stats->getTopProducts());
?>