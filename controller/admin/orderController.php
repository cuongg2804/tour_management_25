<?php 
class orderController {
    protected $conn;

    public function __construct() {
        require_once "./config/database.php";
        $this->conn = (new Database())->connectDB();
    }
public function index() {
    $keyword = $_GET['keyword'] ?? null;
    $status = $_GET['orderStatus'] ?? null;
    $startDate = $_GET['startDate'] ?? null;
    $endDate = $_GET['endDate'] ?? null;

    // Tạo điều kiện truy vấn động
    $where = "WHERE 1";
    $params = [];

    if (!empty($keyword)) {
        $where .= " AND id LIKE :keyword";
        $params[':keyword'] = '%' . $keyword . '%';
    }

    if (!empty($status)) {
        $where .= " AND status = :status";
        $params[':status'] = $status;
    }

    if (!empty($startDate)) {
        $where .= " AND DATE(createdAt) >= :startDate";
        $params[':startDate'] = $startDate;
    }

    if (!empty($endDate)) {
        $where .= " AND DATE(createdAt) <= :endDate";
        $params[':endDate'] = $endDate;
    }

    // Phân trang
    $perPage = 10;
    $page = isset($_GET['page']) ? max((int)$_GET['page'], 1) : 1;
    $offset = ($page - 1) * $perPage;

    // Đếm tổng bản ghi
    $countSql = "SELECT COUNT(*) FROM orders $where";
    $stmt = $this->conn->prepare($countSql);
    $stmt->execute($params);
    $totalRecords = $stmt->fetchColumn();

    // Lấy danh sách đơn hàng
    $listSql = "SELECT * FROM orders $where ORDER BY createdAt DESC LIMIT :limit OFFSET :offset";
    $stmt = $this->conn->prepare($listSql);

    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $orderList = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Xử lý từng đơn hàng: tính tổng tiền từ bảng orders_item
    foreach ($orderList as &$order) {
        $orderId = $order['id'];
        $order['totalPrice'] = 0;

        $productSql = "SELECT * FROM orders_item WHERE orderId = :orderId";
        $stmt = $this->conn->prepare($productSql);
        $stmt->execute([':orderId' => $orderId]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $totalPrice = 0;
        foreach ($products as &$product) {
            $price = $product['price'] - $product['price'] * ($product['discount'] / 100);
            $price = round($price);
            $total = $price * $product['quantity'];
            $product['price'] = $price;
            $product['totalPrice'] = $total;
            $totalPrice += $total;
        }

        $order['products'] = $products;
        $order['totalPrice'] = $totalPrice;
    }
    $pageTitle ="Quản lí đơn hàng";
    // Truyền dữ liệu cho view
    include "views/admin/pages/orders/index.php";
}

    public function detail($url){
        // Lấy ID đơn hàng và trạng thái từ query string
        $idOrder = $url[3];  
        $status = $_GET['status'];  

        // Truy vấn đơn hàng
        $stmt = $this->conn->prepare("SELECT * FROM orders WHERE id = :id");
        $stmt->bindParam(':id', $idOrder, PDO::PARAM_INT);
        $stmt->execute();
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        // Nếu không tìm thấy đơn hàng
        if (!$order) {
            throw new Exception('Không tìm thấy đơn hàng.');
        }

        // Tính toán tổng tiền đơn hàng
        $order['totalPrice'] = 0;

        // Lấy thông tin các sản phẩm trong đơn hàng
        $stmt = $this->conn->prepare("SELECT * FROM orders_item WHERE orderId = :order_id");
        $stmt->bindParam(':order_id', $idOrder, PDO::PARAM_INT);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Lặp qua các sản phẩm của đơn hàng
    foreach ($products as &$item) {
        // Lấy thông tin sản phẩm từ bảng tours
        $stmtProduct = $this->conn->prepare("SELECT * FROM tours WHERE id = :product_id");
        $stmtProduct->bindParam(':product_id', $item['product_id'], PDO::PARAM_INT);
        $stmtProduct->execute();
        $product = $stmtProduct->fetch(PDO::FETCH_ASSOC);

        // Kiểm tra nếu tìm thấy sản phẩm trong bảng tours
        if ($product) {
            $item['thumbnail'] = $product['image']; // Giả sử 'image' là cột ảnh trong bảng tours
            $item['title'] = $product['title']; // Giả sử 'title' là cột tên sản phẩm trong bảng tours
        }

        // Tính giá sản phẩm sau khi giảm giá
        $item['price'] = round($item['price'] - $item['price'] * ($item['discount'] / 100));
        $item['totalPrice'] = $item['price'] * $item['quantity'];

        // Cộng dồn tổng tiền đơn hàng
        $order['totalPrice'] += $item['totalPrice'];
    }


        $sql="select tours.*, orders_item.quantity   from tours 
        inner join orders_item
        on tours.id = orders_item.tourId
        inner join orders 
        on orders_item.orderId = orders.id
        where orderId = $idOrder";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $tourInfor = $stmt->fetchAll();


        foreach ($tourInfor as &$tour) {
                $tour["totalPrice"] = $tour["price"] * $tour["quantity"];
                $tour["image"] = (json_decode($tour["images"], true))[0] ?? null;
            }

        $pageTitle ="Chi tiết đơn hàng";
            include "views/admin/pages/orders/detail.php";
        }

        public function updatePost($url){
            if(isset($_GET['status'])){
                $status = $_GET['status'];
                $sql= "update orders set status = '$status', updatedAt = now() where id = $url[3]";
                $stmt =$this->conn->prepare($sql); 
                $stmt->execute();
                
                header("Location:/tour_management/admin/order");
            }
            
        }
}
?>
