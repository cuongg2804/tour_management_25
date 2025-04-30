<?php 
    include __DIR__ . "./../../controller/client/tour/tourController.php";
    class tourRouter extends index{
        public function index ($url)
        {
            $nameController = (isset($url[1])?$url[1] : "index");;
            (new tourController())->$nameController($url);
        }
    }
?>