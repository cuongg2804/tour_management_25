<?php 
    class dashboardController{
        protected $conn;

        public function __construct() {
            require_once "./config/database.php";
            $this->conn = (new Database())->connectDB();
        }
        public function index() {
            $pageTitle = "Danh mục";
            include "views/admin/pages/dashboard/index.php";
        }


    }
?>