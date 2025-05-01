<?php
    include "./controller/admin/dashboard/dashboardController.php";
    class dashboardRouter {
        public function index ($url){
            {
                $nameController = (isset($url[2])?$url[2] : "index");
                (new dashboardController())->$nameController($url);
            }
        }
    }
?>