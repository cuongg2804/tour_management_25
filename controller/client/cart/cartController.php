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

        public function order(){
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
                $stmt = $this->conn->prepare("INSERT INTO orders (fullName, phone, note, status, deleted, createdAt, updatedAt) VALUES (:fullName, :phone, :note, 'initial',0, now(),now() )");
                $stmt->execute([
                    ':fullName' => $info['fullName'],
                    ':phone' => $info['phone'],
                    ':note' => $info['note']
                ]);
                $orderId = $this->conn->lastInsertId();
        
                // 2. Tạo mã đơn hàng từ ID (ví dụ đơn giản)
                $code = 'ORD'.str_pad($orderId, 6, '0', STR_PAD_LEFT);
        
                // 3. Cập nhật mã đơn hàng
                $stmt = $this->conn->prepare("UPDATE orders SET code = :code WHERE id = :id");
                $stmt->execute([
                    ':code' => $code,
                    ':id' => $orderId
                ]);
        
                // 4. Thêm từng tour vào bảng order_items
                foreach ($cart as $tour) {
                    // Lấy thông tin tour
                    $stmt = $this->conn->prepare("SELECT * FROM tours WHERE id = :id AND deleted = 0 AND status = 'active'");
                    $stmt->execute([':id' => $tour['tourId']]);
                    $inforTour = $stmt->fetch(PDO::FETCH_ASSOC);
        
                    if ($inforTour) {
                        $stmt = $this->conn->prepare("
                            INSERT INTO orders_item (orderId, tourId, quantity, price, discount, timeStart)
                            VALUES (:orderId, :tourId, :quantity, :price, :discount, :timeStart)
                        ");
                        $stmt->execute([
                            ':orderId' => $orderId,
                            ':tourId' => $tour['tourId'],
                            ':quantity' => $tour['quantity'],
                            ':price' => $inforTour['price'],
                            ':discount' => $inforTour['discount'],
                            ':timeStart' => $inforTour['timeStart']
                        ]);
                    }
                }
        
                // Commit transaction
                $this->conn->commit();
        
                echo json_encode([
                    'code' => 200,
                    'message' => 'Đặt hàng thành công!',
                    'orderCode' => $code
                ]);
            } catch (Exception $e) {
                $this->conn->rollBack();
                echo json_encode([
                    'code' => 200,
                    'message' => 'Lỗi hệ thống: ' . $e->getMessage()
                ]);
            }

        }
        

        public function success ($url){
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
    
            // 2. Lấy danh sách sản phẩm trong đơn hàng
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
    
            // 3. Gửi dữ liệu sang view
            // $pageTitle = "Đặt hàng thành công!";
            // include "views/client/pages/cart/success.php";
        }
        
    }
?>