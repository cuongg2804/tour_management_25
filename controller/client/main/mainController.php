<?php 
    class mainController{
        private $conn;

        // Constructor để khởi tạo kết nối
        public function __construct() {
            require_once "./config/database.php";
            $this->conn = (new Database())->connectDB();
        }
        public function index() {
            $sql="select * from tours";
            $stmt= $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            print_r($result[0]);
            include "views/client/pages/main/index.php";
        }
    }
?>