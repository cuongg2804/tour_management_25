<?php
    include "./controller/admin/category/categoryController.php";
    class categoryRouter {
        public function index ($url){
            {
                $nameController = (isset($url[2])?$url[2] : "index");
                if($_SERVER['REQUEST_METHOD'] === 'POST'){
                    $nameController.= "Post";
                }
                (new categoryController())->$nameController($url);
            }
        }
    }
?>