<?php 
     include __DIR__ . "/../../controller/client/main/mainController.php";
    class mainRouter{
       
        public function index ($url)
        {
            $nameController = (isset($url[1])?$url[1] : "index");;
            (new mainController())->$nameController($url);
        }
    }
?>