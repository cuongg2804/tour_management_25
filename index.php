<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
        include "views/client/partials/header.php";
    ?>
    <?php 
        include "router/client/index.php";

        
        if(isset($_GET['url'])) {
            $url = ($_GET['url']);
            $url  = explode("/",rtrim($url,'/'));
            if (!str_contains($url[0], "admin")) {
                (new index())->routerClient($url);
            }
            else{
                echo "Chưa phát triển admin";
            }            
        }
        

       
    ?>
    <?php 
        include "views/client/partials/footer.php";
    ?>
</body>
</html>