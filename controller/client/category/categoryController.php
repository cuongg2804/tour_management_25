<?php 

    class categoryController {
        private $conn;

        // Constructor để khởi tạo kết nối
        public function __construct() {
            require_once "./config/database.php";
            $this->conn = (new Database())->connectDB();
        }
        public function index()
        {
            $sql ='SELECT * FROM categories';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $query = $stmt->fetchAll(PDO::FETCH_ASSOC);

            include "views/client/pages/category/index.php";
            
        }

        public function detail()
        {
            echo "detail category";
        }
        
    }
?>

