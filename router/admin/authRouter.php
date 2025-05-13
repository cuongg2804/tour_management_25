<?php
    include "./controller/admin/authController.php";
    class authRouter {
        public function index ($url){
            {
                
                    $nameController = (isset($url[2])?$url[2] : "index");
                    if($_SERVER['REQUEST_METHOD'] === 'POST'){
                        $nameController.= "Post";
                    }
                    (new authControlller())->$nameController($url);
                
                
                
            }
        }
    }
?>