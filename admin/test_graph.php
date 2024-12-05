<?php
// admin/test_graphs.php
include 'includes/session.php';
require_once('includes/DashboardStats.php');

// Activer l'affichage des erreurs pour le débogage
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Créer une instance de DashboardStats
$stats = new DashboardStats();

// Tester en fonction du paramètre
if(isset($_GET['type'])) {
    try {
        switch($_GET['type']) {
            case 'monthly':
                $stats->generateMonthlySalesGraph();
                break;
            case 'category':
                $stats->generateCategoryPieChart();
                break;
            default:
                echo "Type de graphique invalide. Utilisez 'monthly' ou 'category'.";
        }
    } catch(Exception $e) {
        header('Content-Type: text/plain');
        echo "Erreur : " . $e->getMessage() . "\n";
        echo "Fichier : " . $e->getFile() . "\n";
        echo "Ligne : " . $e->getLine() . "\n";
    }
} else {
    echo "
    <h2>Tests des graphiques</h2>
    <p>Cliquez sur les liens pour tester chaque graphique :</p>
    <ul>
        <li><a href='?type=monthly'>Graphique des ventes mensuelles</a></li>
        <li><a href='?type=category'>Graphique des catégories</a></li>
    </ul>
    ";
}
?>