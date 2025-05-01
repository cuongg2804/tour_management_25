<?php 
    class indexAdmin{
       public function routerAdmin($url) {
          
            $nameRouter = $url[1]."Router";
            include __DIR__ . "./../admin/". $url[1] ."Router.php";
            (new $nameRouter())->index($url); 
       }
    }
?>