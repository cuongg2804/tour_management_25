<?php 
    class index{
       public function routerClient($url) {
            $nameRouter = $url[0]."Router";
            include __DIR__ . "./../client/". $url[0] ."Router.php";
            (new $nameRouter())->index($url); 
       }
    }
?>