<?php
// admin/includes/DashboardStats.php

require_once(__DIR__ . '/../../jpgraph/src/jpgraph.php');
require_once(__DIR__ . '/../../jpgraph/src/jpgraph_bar.php');
require_once(__DIR__ . '/../../jpgraph/src/jpgraph_line.php');
require_once(__DIR__ . '/../../jpgraph/src/jpgraph_pie.php');
require_once(__DIR__ . '/../../includes/conn.php');

class DashboardStats {
    private $db;

    public function __construct() {
        global $pdo;
        $this->db = $pdo;
    }

    // Fetch all the required data first
    public function getTotalSales() {
        $conn = $this->db->open();
        try {
            $stmt = $conn->prepare("
                SELECT 
                    COALESCE(SUM(p.price * d.quantity), 0) as total_amount,
                    COUNT(DISTINCT s.id) as total_transactions
                FROM sales s
                LEFT JOIN details d ON s.id = d.sales_id
                LEFT JOIN products p ON d.product_id = p.id
            ");
            $stmt->execute();
            $result = $stmt->fetch();
            $this->db->close();
            return $result;
        } catch(PDOException $e) {
            $this->db->close();
            return array('total_amount' => 0, 'total_transactions' => 0);
        }
    }

    public function getTopProducts() {
        $conn = $this->db->open();
        try {
            $stmt = $conn->prepare("
                SELECT 
                    p.name,
                    SUM(d.quantity) as total_quantity,
                    SUM(p.price * d.quantity) as total_sales
                FROM products p
                INNER JOIN details d ON p.id = d.product_id
                GROUP BY p.id, p.name
                ORDER BY total_quantity DESC
                LIMIT 5
            ");
            $stmt->execute();
            $result = $stmt->fetchAll();
            $this->db->close();
            return $result;
        } catch(PDOException $e) {
            $this->db->close();
            return array();
        }
    }

    public function generateMonthlySalesGraph() {
        $conn = $this->db->open();
        try {
            // Récupérer les données
            $stmt = $conn->prepare("
                SELECT 
                    MONTH(s.sales_date) as month,
                    SUM(p.price * d.quantity) as total
                FROM sales s
                LEFT JOIN details d ON s.id = d.sales_id
                LEFT JOIN products p ON d.product_id = p.id
                WHERE YEAR(s.sales_date) = :year
                GROUP BY MONTH(s.sales_date)
                ORDER BY month
            ");
            $stmt->execute(['year' => date('Y')]);
            $data = $stmt->fetchAll();
            $this->db->close();

            // Préparer les données pour le graphique
            $months = array();
            $amounts = array();
            foreach($data as $row) {
                $months[] = date('M', mktime(0, 0, 0, $row['month'], 1));
                $amounts[] = (float)$row['total'];
            }

            // Si pas de données, retourner une image d'erreur
            if(empty($amounts)) {
                $this->generateErrorImage("Aucune donnée de vente disponible");
                return;
            }

            // Créer le graphique
            $graph = new Graph(800, 400);
            $graph->SetScale("textlin");
            $graph->img->SetMargin(60, 30, 40, 40);

            // Créer les barres
            $bplot = new BarPlot($amounts);
            $bplot->SetFillColor("#3498db");

            // Configuration
            $graph->title->Set("Ventes mensuelles " . date('Y'));
            $graph->xaxis->SetTickLabels($months);
            $graph->Add($bplot);

            // Afficher
            header("Content-type: image/png");
            $graph->Stroke();

        } catch(Exception $e) {
            $this->generateErrorImage("Erreur: " . $e->getMessage());
        }
    }

    public function generateCategoryPieChart() {
        $conn = $this->db->open();
        try {
            // Récupérer les données
            $stmt = $conn->prepare("
                SELECT 
                    c.name,
                    COUNT(d.id) as total
                FROM category c
                LEFT JOIN products p ON c.id = p.category_id
                LEFT JOIN details d ON p.id = d.product_id
                GROUP BY c.id, c.name
                HAVING total > 0
            ");
            $stmt->execute();
            $data = $stmt->fetchAll();
            $this->db->close();

            // Préparer les données
            $values = array();
            $legends = array();
            foreach($data as $row) {
                $values[] = (int)$row['total'];
                $legends[] = $row['name'] . " (" . $row['total'] . ")";
            }

            // Si pas de données, retourner une image d'erreur
            if(empty($values)) {
                $this->generateErrorImage("Aucune donnée de catégorie disponible");
                return;
            }

            // Créer le graphique
            $graph = new PieGraph(500, 400);
            
            // Configuration
            $graph->title->Set("Répartition par catégorie");
            
            // Créer le pie
            $p1 = new PiePlot($values);
            $p1->SetLegends($legends);
            $p1->SetCenter(0.4);
            
            // Ajouter et afficher
            $graph->Add($p1);
            header("Content-type: image/png");
            $graph->Stroke();

        } catch(Exception $e) {
            $this->generateErrorImage("Erreur: " . $e->getMessage());
        }
    }

    private function generateErrorImage($message) {
        header("Content-type: image/png");
        $width = 500;
        $height = 300;
        $im = imagecreatetruecolor($width, $height);
        $bgColor = imagecolorallocate($im, 255, 255, 255);
        $textColor = imagecolorallocate($im, 255, 0, 0);
        imagefill($im, 0, 0, $bgColor);
        imagestring($im, 5, 10, $height/2, $message, $textColor);
        imagepng($im);
        imagedestroy($im);
    }
}
?>