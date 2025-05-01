<?php 
class categoryController {
    private $conn;

    // Constructor để khởi tạo kết nối
    public function __construct() {
        require_once "./config/database.php";
        $db = new Database();
        $this->conn = $db->connectDB();

       
    }

    public function index() {
        // Điều kiện mặc định
        $where = 'deleted = 0';
        $params = [];

        // Search
        $keyword = $_GET['keyword'] ?? '';
        if (!empty($keyword)) {
            $where .= " AND title LIKE :keyword";
            $params[':keyword'] = '%' . $keyword . '%';
        }

        // Pagination setup
        $objectPagination = [
            'currentPage' => 1,
            'limitItems' => 4,
            'skip' => 0,
            'totalPage' => 0,
        ];

        if (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0) {
            $objectPagination['currentPage'] = (int) $_GET['page'];
        }

        $objectPagination['skip'] = ($objectPagination['currentPage'] - 1) * $objectPagination['limitItems'];

        // Đếm tổng bản ghi
        $sqlCount = "SELECT COUNT(*) FROM categories WHERE $where";
        $stmtCount = $this->conn->prepare($sqlCount);
        foreach ($params as $key => $value) {
            $stmtCount->bindValue($key, $value);
        }
        $stmtCount->execute();
        $totalRecords = $stmtCount->fetchColumn();

        $objectPagination['totalPage'] = ceil($totalRecords / $objectPagination['limitItems']);

        // Lấy danh sách danh mục
        $sql = "SELECT * FROM categories WHERE $where LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(':limit', $objectPagination['limitItems'], PDO::PARAM_INT);
        $stmt->bindValue(':offset', $objectPagination['skip'], PDO::PARAM_INT);
        $stmt->execute();

        $listCategory = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Đặt biến tiêu đề
        $pageTitle = "Danh mục";

        // Gọi view hiển thị
        include 'views/admin/pages/category/index.php';
    }
}
?>
