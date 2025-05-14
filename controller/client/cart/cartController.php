<?php 
    
    class cartController {
        private $conn;
        
        // Constructor để khởi tạo kết nối
        public function __construct() {
            require_once "./config/database.php";
            $this->conn = (new Database())->connectDB();
        }

        public function index()
        {
            $pageTitle = "Đặt hàng";
            include "views/client/pages/cart/index.php"; // hiển thị trang giỏ hàng
        }

        public function listjson() {
            header('Content-Type: application/json');
    
            // Lấy dữ liệu từ body của yêu cầu POST
            $json = file_get_contents("php://input");
            $data = json_decode($json, true);
            
            
            $listTour = [];
            $totalOrder = 0;
            
            foreach ($data as $tour ) {
                // Lấy chi tiết tour từ database
                $sql = "SELECT * FROM tours WHERE id = :tourId";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':tourId', $tour['tourId'], PDO::PARAM_INT);
                $stmt->execute();
                $detailTour = $stmt->fetch(PDO::FETCH_ASSOC);
            
                if ($detailTour) {
                    $detailTour['quantity'] = $tour['quantity'];
                    
                    // Xử lý trường images
                    if (!empty($detailTour['images'])) {
                        $detailTour['images'] = json_decode($detailTour['images'], true);
                        $detailTour['image'] = $detailTour['images'][0] ?? null; // Lấy ảnh đầu tiên
                    }
            
                    // Tính giá đặc biệt và giá tổng
                    $detailTour['price_special'] = $detailTour['price'] * (1 - $detailTour['discount'] / 100);
                    $detailTour['price'] = $detailTour['price_special'] * $tour['quantity'];
            
                    // Cộng dồn tổng giá trị đơn hàng
                    $totalOrder += (int) $detailTour['price'];
            
                    // Thêm thông tin vào danh sách
                    $listTour[] = $detailTour;
                }
            }
            
            // Trả về kết quả dưới dạng JSON
            echo json_encode([
                'code' => 200,
                'message' => 'Thành công',
                'listTour' => $listTour,
                'totalOrder' => $totalOrder
            ]);
        }

        public function order() {
    header('Content-Type: application/json');

    // Lấy dữ liệu từ fetch
    $rawData = file_get_contents("php://input");
    $data = json_decode($rawData, true);

    if (!$data || !isset($data['info']) || !isset($data['cart'])) {
        echo json_encode([
            'code' => 400,
            'message' => 'Dữ liệu không hợp lệ'
        ]);
        return;
    }

    $info = $data['info'];
    $cart = $data['cart'];

    try {
        // Bắt đầu transaction
        $this->conn->beginTransaction();

        // 1. Tạo đơn hàng
        $stmt = $this->conn->prepare("INSERT INTO orders (fullName, phone, note, status, deleted, createdAt, updatedAt)
                                      VALUES (:fullName, :phone, :note, 'initial', 0, NOW(), NOW())");
        $stmt->execute([
            ':fullName' => $info['fullName'],
            ':phone' => $info['phone'],
            ':note' => $info['note']
        ]);
        $orderId = $this->conn->lastInsertId();

        // 2. Tạo mã đơn hàng
        $code = 'ORD' . str_pad($orderId, 6, '0', STR_PAD_LEFT);

        // 3. Cập nhật mã đơn hàng
        $stmt = $this->conn->prepare("UPDATE orders SET code = :code WHERE id = :id");
        $stmt->execute([
            ':code' => $code,
            ':id' => $orderId
        ]);

        // 4. Xử lý từng tour trong giỏ hàng
        foreach ($cart as $tour) {
            // Lấy thông tin tour
            $stmt = $this->conn->prepare("SELECT * FROM tours WHERE id = :id AND deleted = 0 AND status = 'active'");
            $stmt->execute([':id' => $tour['tourId']]);
            $inforTour = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($inforTour) {
                $availableStock = (int)$inforTour['stock'];
                $quantity = (int)$tour['quantity'];

                if ($availableStock < $quantity) {
                    // Nếu không đủ số lượng -> huỷ giao dịch
                    $this->conn->rollBack();
                    echo json_encode([
                        'code' => 409,
                        'message' => 'Số lượng tour "' . $inforTour['title'] . '" không đủ. Còn lại: ' . $availableStock
                    ]);
                    return;
                }

                // 5. Thêm vào bảng orders_item
                $stmt = $this->conn->prepare("INSERT INTO orders_item (orderId, tourId, quantity, price, discount, timeStart)
                                              VALUES (:orderId, :tourId, :quantity, :price, :discount, :timeStart)");
                $stmt->execute([
                    ':orderId' => $orderId,
                    ':tourId' => $tour['tourId'],
                    ':quantity' => $quantity,
                    ':price' => $inforTour['price'],
                    ':discount' => $inforTour['discount'],
                    ':timeStart' => $inforTour['timeStart']
                ]);

                // 6. Trừ số lượng tour đã đặt
                $stmt = $this->conn->prepare("UPDATE tours SET stock = stock - :quantity WHERE id = :id");
                $stmt->execute([
                    ':quantity' => $quantity,
                    ':id' => $tour['tourId']
                ]);
            }
        }

        // 7. Hoàn tất giao dịch
        $this->conn->commit();

        echo json_encode([
            'code' => 200,
            'message' => 'Đặt hàng thành công!',
            'orderCode' => $code
        ]);
        } catch (Exception $e) {
            $this->conn->rollBack();
            echo json_encode([
                'code' => 500,
                'message' => 'Lỗi hệ thống: ' . $e->getMessage()
            ]);
        }
}

        

        public function success($url) {
    if (!isset($url[2])) {
        echo "Thiếu mã đơn hàng.";
        return;
    }

    $orderCode = $url[2];

    // 1. Lấy thông tin đơn hàng
    $stmt = $this->conn->prepare("SELECT * FROM orders WHERE code = :code ");
    $stmt->execute([':code' => $orderCode]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        echo "Không tìm thấy đơn hàng.";
        return;
    }

    // 2. Kiểm tra user_id từ session và cập nhật vào đơn hàng
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
        // Cập nhật user_id vào đơn hàng
        $stmt = $this->conn->prepare("UPDATE orders SET user_id = :user_id WHERE id = :orderId");
        $stmt->execute([':user_id' => $userId, ':orderId' => $order['id']]);
    }

    // 3. Lấy danh sách sản phẩm trong đơn hàng
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

    // 4. Gửi dữ liệu sang view
    $pageTitle = "Đặt hàng thành công!";
    include "views/client/pages/cart/success.php";
}

        
    }
?>