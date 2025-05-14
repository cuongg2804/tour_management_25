<?php 
    class searchController{
        
        private $conn;

        // Constructor để khởi tạo kết nối
        public function __construct() {
            require_once "./config/database.php";
            $this->conn = (new Database())->connectDB();
        }

        public function index() {
            $title = $_GET["keyword"];

            // Use prepared statement with a placeholder for security
            $sql = "SELECT * FROM tours WHERE title LIKE :title and stock > 0";
            $stmt = $this->conn->prepare($sql);

            // Bind the :title placeholder to the user input, ensuring proper escaping
            $stmt->bindValue(':title', '%' . $title . '%', PDO::PARAM_STR);

            // Execute the statement
            $stmt->execute();

            // Fetch all results
            $toursList = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($toursList as &$tour) {
                $tour["price_special"] = $tour["price"] * (1 - $tour["discount"] / 100);

                $images = json_decode($tour["images"], true);
                $tour["image"] = $images[0] ?? null;
            }
            $pageTitle ="Kết quả tìm kiếm";

            include "views/client/pages/search.php";
        }
    }
?>