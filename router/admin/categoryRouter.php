<?php
    include "./controller/admin/category/categoryController.php";
    class categoryRouter {
        public function index ($url){
            {
                $nameController = (isset($url[2])?$url[2] : "index");
                (new categoryController())->$nameController($url);
            }
        }
    }
?>