<?php 
    class index{
       public function routerAdmin($url) {
            $nameRouter = $url[0]."Router";
            include __DIR__ . "./../admin/". $url[0] ."Router.php";
            (new $nameRouter())->index($url); 
       }
    }
?>