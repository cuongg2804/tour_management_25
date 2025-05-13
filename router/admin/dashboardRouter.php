<?php
    include "./controller/admin/dashboard/dashboardController.php";
    class dashboardRouter {
        public function index ($url){
            {
                if (isset($_SESSION['user']['permissions']) && in_array('orders-view', $_SESSION['user']['permissions'])) {
                    $nameController = (isset($url[2])?$url[2] : "index");
                    (new dashboardController())->$nameController($url);
                }
                else{
                    header("Location:/tour_management/admin/auth/login");
                }
            }
        }
    }
?>