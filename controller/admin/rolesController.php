<?php 
    class rolesController {
        protected $conn;
        // Constructor để khởi tạo kết nối
        public function __construct() {
            require_once "./config/database.php";
            $this->conn = (new Database())->connectDB();
        }
        public function index() {
            $sql = "select * from roles where deleted = 0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $roleList = $stmt->fetchAll();
            $pageTitle ="Phân quyền";
            include "views/admin/pages/roles/index.php";
        }

        public function create(){
            $pageTitle ="Thêm mới nhóm quyền";
            include "views/admin/pages/roles/create.php";
        }

        public function createPost(){
            $title = $_POST['title'];
            $description = $_POST['description'];

            $permissions = json_encode([]); // Tạm thời không có quyền nào

            $stmt = $this->conn->prepare("INSERT INTO roles (title, description, permissions) VALUES (:title, :description, :permissions)");
            $stmt->execute([
                ':title' => $title,
                ':description' => $description,
                ':permissions' => $permissions
            ]);


            header("Location:/tour_management/admin/roles");

        }

        public function edit($url){
            $id = $url[3];

            $sql = "select * from roles where id = $id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetch();
            include "views/admin/pages/roles/edit.php";
        }

        public function editPost($url) {
            $id = $url[3];

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $title = $_POST['title'] ?? '';
                $description = $_POST['description'] ?? '';

                try {
                    $sql = "UPDATE roles SET title = :title, description = :description, updatedAt = NOW() WHERE id = :id";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindParam(':title', $title);
                    $stmt->bindParam(':description', $description);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

                    if ($stmt->execute()) {
                        $_SESSION['success'] = "Cập nhật nhóm quyền thành công.";
                    } else {
                        $_SESSION['error'] = "Cập nhật nhóm quyền thất bại.";
                    }
                } catch (PDOException $e) {
                    $_SESSION['error'] = "Lỗi: " . $e->getMessage();
                }
            }
        }

        public function deletePost($url){
             $id = $url[3];
            $sql = "UPDATE roles SET deleted = 1 WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo json_encode([
                    "code" => 200,
                    "message" => "Xóa nhóm quyền thành công"
                ]);
            } else {
                echo json_encode([
                    "code" => 500,
                    "message" => "Không thể cập nhật cờ deleted"
                ]);
            }
        }

        public function permissions(){
            
            $sql = "select * from roles where deleted = 0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $records = $stmt->fetchAll();
            $pageTitle ="Phân quyền";
            include "views/admin/pages/roles/permisssions.php";
        }

        public function permissionsPost() {
    $rolesData = json_decode($_POST['roles'], true);

    if (is_array($rolesData)) {
        foreach ($rolesData as $role) {
            $id = $role['id'];
            $permissions = json_encode($role['permissions']); // chuỗi JSON

            // Cập nhật vào database
            $stmt = $this->conn->prepare("UPDATE roles SET permissions = :permissions WHERE id = :id");
            $stmt->execute([
                ':permissions' => $permissions,
                ':id' => $id
            ]);

            // Nếu đang cập nhật đúng role của người dùng hiện tại -> cập nhật lại session
            if (isset($_SESSION['user']['role_id']) && $_SESSION['user']['role_id'] == $id) {
                $_SESSION['user']['permissions'] = $role['permissions'];
            }
        }

        $_SESSION['success'] = "Cập nhật quyền thành công.";
        header("Location:/tour_management/admin/roles/permissions");
        exit();
    } else {
        $_SESSION['error'] = "Dữ liệu không hợp lệ.";
        header("Location:/tour_management/admin/roles/permissions");
        exit();
    }
}

}
    ?>
