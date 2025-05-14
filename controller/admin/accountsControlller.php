<?php 
class accountsController {
    protected $conn;

    public function __construct() {
        require_once "./config/database.php";
        $this->conn = (new Database())->connectDB();
    }

    public function index (){
        $sql = "select account.*,roles.title  from account inner join roles
            on account.role_id = roles.id where account.deleted = 0
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $accList = $stmt->fetchAll();
        $pageTitle ="Quản lý tài khoản";
        include "views/admin/pages/accounts/index.php";
    }

    public function edit($url){
        $sql = "select * from account where id = $url[3]";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetch();

        $sql = "select * from roles ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $roles = $stmt->fetchAll();
        $pageTitle ="Quản lý tài khoản";

        $pageTitle ="Chỉnh sửa tài khoản";
        include "views/admin/pages/accounts/edit.php";
    }

    public function editPost($url){
        $id = $url[3] ?? null; // lấy id từ URL
        if (!$id) {
            die("ID không hợp lệ");
        }

        $fullName = $_POST['fullName'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $role_id = $_POST['role_id'] ?? null;
        $status = $_POST['status'] ?? 'inactive'; // mặc định


            $sql = "UPDATE account 
                    SET fullName = :fullName, 
                        email = :email, 
                        phone = :phone, 
                        role_id = :role_id, 
                        status = :status,
                        updatedAt = NOW()
                    WHERE id = :id";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':fullName' => $fullName,
                ':email'    => $email,
                ':phone'    => $phone,
                ':role_id'  => $role_id,
                ':status'   => $status,
                ':id'       => $id
            ]);
        
            header("Location: /tour_management/admin/accounts/");
    }

    public function deletePost($url){
        $sql = "update account set deleted = 1 where id = $url[3]";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        echo json_encode([
                    "code" => 200,
                    "message" => "Xóa tài khoản thành công"
                ]);
    }

    public function create($url){
        $sql = "select * from roles ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $roles = $stmt->fetchAll();
        $pageTitle = "Tạo tài khoản";
        include "views/admin/pages/accounts/create.php";
    }
    
    public function createPost() {
        $password = md5('123456');

        // Tạo câu lệnh SQL
        $sql = "INSERT INTO account (fullName, email, password, phone, role_id, status, deleted, createdAt)
                VALUES (:fullName, :email, :password, :phone, :role_id, :status, 0, now())";

        // Chuẩn bị và thực thi với PDO
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':fullName' => $_POST['fullName'],
            ':email' => $_POST['email'],
            ':password' => $password,
            ':phone' => $_POST['phone'],
            ':role_id' => $_POST['role_id'],
            ':status' => $_POST['status']
        ]);
        header("Location: /tour_management/admin/accounts/");
    }
}

?>