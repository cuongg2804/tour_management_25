<?php 
    include __DIR__ . "/../../controller/client/cart/cartController.php";
    class cartRouter extends index{
        public function index ($url)
        {
            $nameController = (isset($url[1])?$url[1] : "index");
            (new cartController())->$nameController($url);
        }
    }
?>