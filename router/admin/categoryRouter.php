<?php
    include "./controller/admin/category/categoryController.php";

    class categoryRouter {
        public function index($url) {
            // Kiểm tra sự tồn tại của quyền truy cập
            if (isset($_SESSION['user']['permissions']) && in_array('products-category_view', $_SESSION['user']['permissions'])) {
                // Lấy tên controller, mặc định là 'index'
                $nameController = isset($url[2]) ? $url[2] : "index";
                
                // Thêm hậu tố "Post" nếu là phương thức POST
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $nameController .= "Post";
                }
                
                // Kiểm tra nếu phương thức tồn tại trong categoryController
                if (method_exists(new categoryController(), $nameController)) {
                    (new categoryController())->$nameController($url);
                } else {
                    echo "Phương thức không tồn tại!";
                }
            } else {
                echo "Không có quyền truy cập!";
            }
        }
    }
?>
