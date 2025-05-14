<?php 
    class reportController {
        protected $conn;
        // Constructor để khởi tạo kết nối
        public function __construct() {
            require_once "./config/database.php";
            $this->conn = (new Database())->connectDB();
        }

        public function index(){
            $pageTitle="Thống kê báo cáo";
            include "views/admin/pages/report/index.php";
        }

       public function indexPost() {
    $month = $_POST['month'] ?? null;
    $status = $_POST['status'] ?? null;

    $conditions = [];
    $params = [];

    // Điều kiện tháng
    if (!empty($month)) {
        $conditions[] = "DATE_FORMAT(orders.createdAt, '%Y-%m') = :month";
        $params[':month'] = $month;
    }

    // Điều kiện trạng thái
    if (!empty($status)) {
        $conditions[] = "orders.status = :status";
        $params[':status'] = $status;
    }

    // Tạo chuỗi điều kiện WHERE nếu có
    $whereClause = "";
    if (!empty($conditions)) {
        $whereClause = "WHERE " . implode(" AND ", $conditions);
    }

    // Câu SQL chính
    $sql = "
        SELECT 
            tours.title AS tour_name,
            SUM(orders_item.quantity) AS total_customers,
            SUM(orders_item.quantity * orders_item.price) AS total_revenue
        FROM orders
        INNER JOIN orders_item ON orders.id = orders_item.orderId
        INNER JOIN tours ON orders_item.tourId = tours.id
        $whereClause
        GROUP BY orders_item.tourId
    ";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute($params);

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    include "views/admin/pages/report/index.php";
}


    }
?>