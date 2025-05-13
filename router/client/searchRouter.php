<?php 
    include __DIR__ . "/../../controller/client/searchController.php";
    class searchRouter extends index{
        public function index ($url)
        {
            $nameController = (isset($url[1])?$url[1] : "index");;
            (new searchController())->$nameController($url);
        }
    }
?>