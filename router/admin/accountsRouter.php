<?php
    include "./controller/admin/accountsControlller.php";
    class accountsRouter {
        public function index ($url){
            {
                 if (isset($_SESSION['user']['permissions']) && in_array('accounts-view', $_SESSION['user']['permissions'])) {
                    $nameController = (isset($url[2])?$url[2] : "index");
                    if($_SERVER['REQUEST_METHOD'] === 'POST'){
                        $nameController.= "Post";
                    }
                    (new accountsController())->$nameController($url);
                 }
                 else{
                     header("Location:/tour_management/admin/auth/login");
                 }
                
            }
        }
    }
?>