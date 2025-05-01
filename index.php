
    <?php
    

        include "router/client/index.php";

        if (isset($_GET['url'])) {
            $url = ($_GET['url']);
            $url = explode("/", rtrim($url, '/'));
            if (!str_contains($url[0], "admin")) {
                (new index())->routerClient($url);
            } else {
                echo "Chưa phát triển admin";
            }
        }

    ?>
