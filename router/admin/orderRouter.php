<?php 
    include __DIR__ . "./../../controller/admin/orderController.php";
    class orderRouter extends index{
        public function index ($url)
        {
            if (isset($_SESSION['user']['permissions']) && in_array('orders-view', $_SESSION['user']['permissions'])) {
                $nameController = (isset($url[2])?$url[2] : "index");
                if($_SERVER['REQUEST_METHOD'] === 'POST'){
                    $nameController.= "Post";
                }
                (new orderController())->$nameController($url);
            }
            else{
                header("Location:/tour_management/admin/auth/login");
            }
        }
    }
?>