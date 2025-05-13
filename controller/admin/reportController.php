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

        public function indexPost(){

$month = $_POST['month'] ?? null;
$status = $_POST['status'] ?? null;
$tourName = $_POST['tour_name'] ?? null;

$sql = "SELECT t.title AS tour_name, SUM(oi.quantity) AS total_customers,
                SUM(oi.quantity * oi.price * (1 - oi.discount / 100)) AS total_revenue
            FROM orders_item oi
            JOIN orders o ON oi.orderId = o.id
            JOIN tours t ON oi.tourId = t.id
            WHERE o.deleted IS NULL";

$params = [];

if (!empty($month)) {
    // Thêm điều kiện lọc theo tháng
    $sql .= " AND DATE_FORMAT(o.createdAt, '%Y-%m') = :month";
    $params[':month'] = $month; // Tháng cần được truyền vào
}

if (!empty($status)) {
    // Thêm điều kiện lọc theo trạng thái
    $sql .= " AND o.status = :status";
    $params[':status'] = $status;
}

if (!empty($tourName)) {
    // Thêm điều kiện lọc theo tên tour
    $sql .= " AND t.title LIKE :tour_name";
    $params[':tour_name'] = '%' . $tourName . '%';
}

$sql .= " GROUP BY t.id ORDER BY total_revenue DESC";

// Tạo câu SQL với các tham số đã thay thế
$finalSql = $sql;

foreach ($params as $key => $value) {
    // Thay thế tham số trong câu SQL bằng giá trị thực tế
    $finalSql = str_replace($key, "'$value'", $finalSql);
}

// In ra câu SQL cuối cùng với các tham số đã thay thế
echo "<pre>";
echo "Final SQL Query: " . $finalSql . "\n";
echo "</pre>";

// Tiếp tục thực thi truy vấn sau khi in ra SQL
$stmt = $this->conn->prepare($sql);
$stmt->execute($params);
$results = $stmt->fetchAll();


// In kết quả ra để kiểm tra
print_r($results);


             //include "views/admin/pages/report/index.php";
        }
    }
?>