<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
class authControlller {
    protected $conn;

    public function __construct() {
        require_once "./config/database.php";
        $this->conn = (new Database())->connectDB();
    }

    public function login(){
        $pageTitle ="Đăng nhập";
        $pageTitle = "Đăng nhập";
        include "views/admin/pages/auth/login.php";
    }

    public function loginPost(){
       
        $email =  $_POST["email"];
        $pass = md5($_POST["password"]);
        
        $sql = "SELECT * FROM account WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch();


        if (!$user) {
            $_SESSION['error'] = "Email không tồn tại!";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }

        if ($pass != $user['password']) {
            $_SESSION['error'] = "Sai mật khẩu!";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }

        if ($user['status'] != 'active') {
            $_SESSION['error'] = "Tài khoản đang bị khóa!";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }

        $_SESSION['user'] = [
        'id'       => $user['id'],
        'fullName' => $user['fullName'],
        'email'    => $user['email'],
        'role_id'  => $user['role_id'],
        'permissions' => []
        ];

        // Lấy permissions từ bảng roles
        $idRole = $_SESSION['user']['role_id'];
        $sql = "SELECT permissions FROM roles WHERE id = $idRole";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $query = $stmt->fetch();

        // Giải mã và lưu vào session
        $permissions = json_decode($query['permissions'], true);
        $_SESSION['user']['permissions'] = $permissions;

        

        header("Location: /tour_management/admin/dashboard");
    }

    public function logout() {
        // Bắt đầu session nếu chưa có
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Xóa toàn bộ dữ liệu session
        session_unset(); // Xóa tất cả biến session
        session_destroy(); // Hủy session
        header("Location: /tour_management/admin/auth/login");
    }

    public function  forget(){
        include "views/admin/pages/auth/forget.php";
    }

    public function forgetPost() {
        $email = $_POST["email"];

    $sql = "SELECT * FROM account WHERE email = :email";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch();

    if (!$user) {
        $_SESSION['error'] = "Email không tồn tại!";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }

    // Tạo mã xác nhận ngẫu nhiên
    $token = rand(100000, 999999); // hoặc dùng bin2hex(random_bytes(16)) cho link đặt lại mật khẩu
    $_SESSION['reset_token'] = $token;
    $_SESSION['reset_email'] = $email;

    // Lưu vào bảng otp_codes
    $insertOtp = "INSERT INTO password_reset (email, token) VALUES (:email, :token)";
    $stmt = $this->conn->prepare($insertOtp);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':token', $token);
    $stmt->execute();

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'cuong98431@st.vimaru.edu.vn';
        $mail->Password   = 'ygty jsls skff lrim'; // App password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('cuong98431@st.vimaru.edu.vn', 'Travel Agency');
        $mail->addAddress($email); // Gửi đến email nhập vào form

        $mail->isHTML(true);
        $mail->Subject = 'Resset Password';
        $mail->Body    = 'Mã xác nhận của bạn là: <b>' . $token . '</b>';

        $mail->send();
        $_SESSION['message'] = "Đã gửi mã xác nhận đến email của bạn.";
       
    } catch (Exception $e) {
        $_SESSION['error'] = "Không gửi được email. Lỗi: {$mail->ErrorInfo}";
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }

     header("Location: /tour_management/admin/auth/verify/$email ");

    }

    public function verify($url){
        $pageTitle ="Xác minh";
        include "views/admin/pages/auth/verify.php";
    }

    public function verifyPost($url){
       
        $email = $_POST['email'];
        $otp = $_POST['token'];
        
        // Truy vấn mã OTP mới nhất của email đó
        $sql = "SELECT * FROM password_reset 
                WHERE email = :email AND token = :otp 
                ORDER BY created_at DESC 
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':otp', $otp);
        $stmt->execute();
        $otpRecord = $stmt->fetch();
       

        if (!$otpRecord) {
            $_SESSION['error'] = "Mã OTP không đúng.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }

        //Kiểm tra thời gian còn hiệu lực (1 phút)
        $createdAt = strtotime($otpRecord['created_at']);
        $now = time();
        $diffInSeconds = $now - $createdAt;

        if ($diffInSeconds > 60) {
            $_SESSION['error'] = "Mã OTP đã hết hạn.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }

        //Thành công – chuyển đến bước đặt lại mật khẩu
        $_SESSION['verified_email'] = $email;
        header("Location: reset"); // hoặc route phù hợp của bạn
        exit;
    }

    public function reset(){
        $pageTitle ='Đặt lại mật khẩu';
        include "views/admin/pages/auth/reset.php";
    }

    public function resetPost(){
        if (!isset($_SESSION['verified_email'])) {
            $_SESSION['error'] = "Phiên đăng nhập không hợp lệ.";
            header("Location: /tour_management/admin/auth/login");
            exit;
        }

    $email = $_SESSION['verified_email'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Kiểm tra mật khẩu và xác nhận mật khẩu có khớp không
    if ($newPassword !== $confirmPassword) {
        $_SESSION['error'] = "Mật khẩu và xác nhận mật khẩu không khớp!";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }

    // Mã hóa mật khẩu mới trước khi lưu vào cơ sở dữ liệu
    $hashedPassword =  md5($confirmPassword);

    // Cập nhật mật khẩu mới vào cơ sở dữ liệu
    $sql = "UPDATE account SET password = :password WHERE email = :email";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':email', $email);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Mật khẩu đã được thay đổi thành công!";
        unset($_SESSION['verified_email']); // Xóa email trong session sau khi cập nhật thành công
        header("Location: /tour_management/admin/auth/login"); // Chuyển hướng về trang đăng nhập
        exit;
    } else {
        $_SESSION['error'] = "Có lỗi xảy ra, vui lòng thử lại!";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
    }

    public function myaccount(){
        $user = $_SESSION["user"];
        $pageTitle = "Thông tin người dùng";
        include "views/admin/pages/auth/info.php";
    }

    public function myaccountPost(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];

    try {
        // Cập nhật thông tin người dùng trong DB
        $stmt = $this->conn->prepare("UPDATE account SET fullName = :fullName, email = :email WHERE id = :id");
        $stmt->execute([
            ':fullName' => $fullName,
            ':email' => $email,
            ':id' => $id
        ]);

        // Cập nhật lại session nếu là người đang đăng nhập
        if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $id) {
            $_SESSION['user']['fullName'] = $fullName;
            $_SESSION['user']['email'] = $email;
        }

        $_SESSION['success'] = "Cập nhật thông tin thành công!";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Lỗi khi cập nhật: " . $e->getMessage();
    }

    header("Location: /tour_management/admin/auth/myaccount");
    exit();
    }
    }
}