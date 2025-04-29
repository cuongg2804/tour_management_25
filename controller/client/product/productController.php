<?php 
    class productController{
        public function index()
        {
            include "views/client/pages/home/index.php";
        }
        public function detail() {
            include "views/client/pages/home/detail.php";
        }
    }
?>