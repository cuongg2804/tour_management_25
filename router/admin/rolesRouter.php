<?php 
    include __DIR__ . "./../../controller/admin/rolesController.php";
    class rolesRouter extends index{
        public function index ($url)
        {
             if (isset($_SESSION['user']['permissions']) && in_array('role-view', $_SESSION['user']['permissions'])){
                $nameController = (isset($url[2])?$url[2] : "index");
                if($_SERVER['REQUEST_METHOD'] === 'POST'){
                    $nameController.= "Post";
                }
                (new rolesController())->$nameController($url);
            }
            else{
                header("Location:/tour_management/admin/auth/login");
            }
                
        }
    }
?>