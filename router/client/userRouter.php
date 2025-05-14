<?php 
    include __DIR__ . "/../../controller/client/userController.php";
    class userRouter extends index{
        public function index ($url)
        {
            $nameController = (isset($url[1])?$url[1] : "index");
                if($_SERVER['REQUEST_METHOD'] === 'POST'){
                    $nameController.= "Post";
                }
                (new userController())->$nameController($url);
        }
    }
?>