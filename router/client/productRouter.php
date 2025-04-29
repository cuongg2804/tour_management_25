<?php 
    include __DIR__ . "./../../controller/client/product/productController.php";
    class productRouter extends index{
        public function index ($url)
        {
            $nameController = $url[1];
            (new productController())->$nameController();
        }
    }
?>