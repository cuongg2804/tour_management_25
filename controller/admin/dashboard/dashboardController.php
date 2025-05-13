<?php 
    class dashboardController{
        protected $conn;

        public function __construct() {
            require_once "./config/database.php";
            $this->conn = (new Database())->connectDB();
        }
        public function index() {
            // 1. Thống kê sản phẩm
            $sqlProducts = "
                SELECT 
                    COUNT(*) AS total,
                    SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) AS active,
                    SUM(CASE WHEN status = 'inactive' THEN 1 ELSE 0 END) AS inactive
                FROM tours
            ";
            $products = $this->conn->query($sqlProducts)->fetch(PDO::FETCH_ASSOC);

            // 2. Thống kê danh mục sản phẩm
            $sqlCategories = "
                SELECT 
                    COUNT(*) AS total,
                    SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) AS active,
                    SUM(CASE WHEN status = 'inactive' THEN 1 ELSE 0 END) AS inactive
                FROM categories
            ";
            $products_category = $this->conn->query($sqlCategories)->fetch(PDO::FETCH_ASSOC);
           
            $user_id = $_SESSION['user']['id'] ?? 1; // hoặc thay bằng id test
            $sqlUser = "
                SELECT 
                    a.fullName, 
                    a.email, 
                    a.phone, 
                    r.title 
                FROM account a
                INNER JOIN roles r ON a.role_id = r.id
                WHERE a.id = ?
            ";
            $stmtUser = $this->conn->prepare($sqlUser);
            $stmtUser->execute([$user_id]);
            $user = $stmtUser->fetch(PDO::FETCH_ASSOC);
            $pageTitle = "Danh mục";
            include "views/admin/pages/dashboard/index.php";
        }


    }
?>