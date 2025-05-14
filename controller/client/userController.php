<?php 
    class userController{
        
        private $conn;

        // Constructor để khởi tạo kết nối
        public function __construct() {
            require_once "./config/database.php";
            $this->conn = (new Database())->connectDB();
        }

        public function register(){
            $pageTitle ="Đăng ký tài khoản";
            include "views/client/pages/user/register.php";
        }

        function generateRandomString($length = 30) {
            // Đảm bảo chiều dài là số chẵn nếu dùng bin2hex
            if ($length % 2 !== 0) {
                $length++;
            }
            return bin2hex(random_bytes($length / 2));
        }
        public function registerPost(){
        
            $email = $_POST['email'];
            $fullName = $_POST['fullName'];
            $password = $_POST['password'];

            // Kiểm tra email đã tồn tại chưa (và chưa bị xóa)
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ? AND deleted = 0");
            $stmt->execute([$email]);
            $existUser = $stmt->fetch();

            if ($existUser) {
                $_SESSION['error'] = "Email đã tồn tại!";
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit;
            }

            // Tạo thông tin người dùng
            $tokenUser = $this->generateRandomString(30); // Bạn cần định nghĩa hàm này trong helpers.php
            $hashedPassword = md5($password); // Không nên dùng md5 thực tế, nhưng giữ nguyên theo yêu cầu

            $stmt = $this->conn->prepare("INSERT INTO users (fullName, email, password, tokenUser) VALUES (?, ?, ?, ?)");
            $stmt->execute([$fullName, $email, $hashedPassword, $tokenUser]);

            // Lưu tokenUser vào session
            //$_SESSION['tokenUser'] = $tokenUser;

            header("Location: /tour_management/main");
        }

        public function login() {
            $pageTitle ="Đăng nhập";
            include "views/client/pages/user/login.php";
        }

        public function loginPost(){
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Tìm user theo email và chưa bị xóa
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ? AND deleted = 0");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

    if (!$user) {
        $_SESSION['error'] = "Email không tồn tại!";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }

    if (md5($password) !== $user['password']) {
        $_SESSION['error'] = "Sai mật khẩu!";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }

    if ($user['status'] !== 'active') {
        $_SESSION['error'] = "Tài khoản đang bị khóa!";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }

    // Đăng nhập thành công, lưu token vào session
    $_SESSION['user_id'] = $user['id'];

    header("Location: /tour_management/main");
        }


    public function logout(){
                unset($_SESSION['user_id']);

        // (Tùy chọn) Xóa toàn bộ session nếu cần
        // session_destroy();

        header("Location: /tour_management/main");
        exit;
    }
    
    public function history(){
// Kiểm tra xem người dùng đã đăng nhập chưa (kiểm tra session user_id)
if (!isset($_SESSION['user_id'])) {
    echo "Bạn chưa đăng nhập.";
    return;
}

$userId = $_SESSION['user_id'];

// 1. Lấy tất cả các đơn hàng của người dùng theo user_id
$stmt = $this->conn->prepare("SELECT * FROM orders WHERE user_id = :user_id ORDER BY createdAt DESC");
$stmt->execute([':user_id' => $userId]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$orders) {
    echo "Không có đơn hàng nào.";
    return;
}

// 2. Lấy danh sách sản phẩm cho mỗi đơn hàng
foreach ($orders as &$order) {
    // Lấy danh sách sản phẩm trong đơn hàng
    $stmt = $this->conn->prepare("SELECT * FROM orders_item WHERE orderId = :orderId");
    $stmt->execute([':orderId' => $order['id']]);
    $listOrderItem = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalPrice = 0;
    foreach ($listOrderItem as &$item) {
        $stmt = $this->conn->prepare("SELECT * FROM tours WHERE id = :id AND deleted = 0 AND status = 'active'");
        $stmt->execute([':id' => $item['tourId']]);
        $inforTour = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($inforTour) {
            $item['title'] = $inforTour['title'];

            if (!empty($inforTour['images'])) {
                $images = json_decode($inforTour['images'], true);
                $item['image'] = $images[0] ?? '';
            }

            $item['price_special'] = $inforTour['price'] * (1 - $inforTour['discount'] / 100);
            $item['total'] = $item['price_special'] * $item['quantity'];
            $totalPrice += $item['total'];
        }
    }

    $order['totalPrice'] = $totalPrice;
}

// 3. Gửi dữ liệu sang view để hiển thị
$pageTitle = "Lịch sử mua hàng";
include "views/client/pages/user/history.php";

    }
}
    ?>