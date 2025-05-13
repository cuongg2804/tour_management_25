
    <?php
        session_start();
        ini_set('memory_limit', '1024M'); // tăng giới hạn lên 1GB

        include "router/client/index.php";
        include "router/admin/index.php";
        if (isset($_GET['url'])) {
            $url = ($_GET['url']);
            $url = explode("/", rtrim($url, '/'));
            if (!str_contains($url[0], "admin")) {
                (new index())->routerClient($url);
            } else {
               (new indexAdmin())->routerAdmin($url);
            }
        }

    ?>
