<?php 
    class tourController{
        
        private $conn;

        // Constructor để khởi tạo kết nối
        public function __construct() {
            require_once "./config/database.php";
            $this->conn = (new Database())->connectDB();
        }

        public function index($url)
        {

            $sql = "SELECT tours.*, 
                   ROUND(price * (1 - discount / 100), 0) AS price_special
            FROM tours
            INNER JOIN tours_categories ON tours.id = tours_categories.tour_id
            INNER JOIN categories ON tours_categories.category_id = categories.id
            WHERE categories.slug = :slug
              AND categories.deleted = false
              AND categories.status = 'active'
              AND tours.deleted = false
              AND tours.status = 'active'";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['slug' => $url[2]]);  // an toàn hơn
            $toursList = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($toursList as &$tour) {
                $tour['price_special'] = $tour['price'] * (1 - $tour['discount'] / 100);
                $tour["image"]= (json_decode($tour['images'], true))[0];
            }

            
            $sql = "SELECT title from categories where slug = :slug ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['slug' => $url[2]]);  // an toàn hơn
            $category = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pageTitle="Danh sách Tour ".$category[0]["title"] ;


            include "views/client/pages/tour/index.php";
        }

        
        public function detail($url) {
            if($url[2]){
                $slug = $url[2];  // Giả sử $url[2] là slug của category
        
            $sql = "SELECT tours.*, 
                           ROUND(price * (1 - discount / 100), 0) AS price_special
                    FROM tours where slug = :slug";
        
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['slug' => $url[2]]);  // an toàn hơn
            $tourDetail = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $tourDetail['images'] = json_decode($tourDetail['images'], true);
        
            include "views/client/pages/tour/detail.php";
            }
        }
    }
?>