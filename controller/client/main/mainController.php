<?php 
    class mainController{
        private $conn;

        // Constructor để khởi tạo kết nối
        public function __construct() {
            require_once "./config/database.php";
            $this->conn = (new Database())->connectDB();
        }
        public function index() {
            $sql = "SELECT * FROM tours WHERE deleted = 0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pageTitle ="Trang chủ";
            include "views/client/pages/main/index.php";

        }
    }
?>