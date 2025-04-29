<?php 
    include __DIR__ . "./../../controller/client/category/categoryController.php";
    class categoryRouter extends index{
        public function index ($url)
        {
            $nameController = $url[1];
            (new categoryController())->$nameController();
        }
    }
?>