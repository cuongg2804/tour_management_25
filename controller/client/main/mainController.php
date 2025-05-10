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

            $sql2 ='SELECT * FROM categories';
            $stmt2 = $this->conn->prepare($sql2);
            $stmt2->execute();
            $result2= $stmt2->fetchAll(PDO::FETCH_ASSOC);
            //print_r($result2[1]);
            include "views/client/pages/main/index.php";
        }
    }
?>