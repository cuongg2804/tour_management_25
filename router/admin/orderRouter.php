<?php 
    include __DIR__ . "./../../controller/admin/orderController.php";
    class orderRouter extends index{
        public function index ($url)
        {
            $nameController = (isset($url[2])?$url[2] : "index");
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $nameController.= "Post";
            }
            (new orderController())->$nameController($url);
        }
    }
?>