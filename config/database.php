<?php 
    class database {
        public function connectDB() {
            $conn = new PDO("mysql:host=localhost;dbname=tour_management","root", "");

            if(isset($conn)){
                echo "Kết nối thành công";
            }
            else{
                echo "Kết nối thất bại";
            }
            return $conn;
    }
    }
?>