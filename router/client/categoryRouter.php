<?php 
    include __DIR__ . "./../../controller/client/category/categoryController.php";
    class categoryRouter extends index{
        public function index ($url)
        {
            $nameController = (isset($url[1])?$url[1] : "index");
            (new categoryController())->$nameController();
        }
    }
?>