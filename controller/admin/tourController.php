<?php 
    class tourController {
        // Constructor để khởi tạo kết nối
        public function __construct() {
            require_once "./config/database.php";
            $this->conn = (new Database())->connectDB();
        }
        public function index() {
            $where="deleted = 0";
            $params = [];
    
    
            //Search
            $keyword = isset($_GET["keyword"]) ? $_GET["keyword"] : "";
            if(!empty($keyword)){
                $where .= " AND title REGEXP  :keyword";
                $params[":keyword"] =  $keyword ;
            }
            //End Search
    
            //Paginantion
            $objPagination = [
                'currentPage' => 1,
                'limit'=> 4,
                'skip' => 0,
                'totalPage' => '0' 
            ];
    
            if(isset($_GET["page"]) && is_numeric($_GET["page"]) && $_GET["page"] >0){
                $objPagination['currentPage'] = (int)$_GET["page"];
            }
    
            $objPagination['skip'] = ($objPagination['currentPage'] - 1) * ($objPagination['limit']);
            
            //Đếm tổng bản ghi
            $sqlCount = "SELECT count(*) from tours where $where";
            $stmtCount =$this->conn->prepare($sqlCount);
            foreach($params as $key => $value){
                $stmtCount->bindValue($key,$value);
            }
            $stmtCount->execute();
            $totalRecord = $stmtCount->fetchColumn();
    
            $objPagination['totalPage'] = (int) ( $totalRecord / $objPagination['limit']) + 1;
             //End Pagination
    
    
    
            $sql = "SELECT * FROM tours where $where LIMIT :limit OFFSET :offset";
            $stmt = $this->conn->prepare($sql);
            foreach($params as $key => $value){
                $stmt->bindValue($key,$value);
            }
            $stmt->bindValue(":limit",$objPagination["limit"],PDO::PARAM_INT);
            $stmt->bindValue(":offset",$objPagination["skip"],PDO::PARAM_INT);
            $stmt->execute();
            $listTour = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($listTour as &$tour) {
                $tour["price_special"] = $tour["price"] * (1 - $tour["discount"] / 100);
                $tour["image"] = (json_decode($tour["images"], true))[0] ?? null;
            }
            
           
            $pageTitle="Quản lí Tour";
         
            // Gọi view hiển thị
            include 'views/admin/pages/tour/index.php';
        }
        public function detail($url){
            $id = $url[3];

            $sql = "select * from tours where id = $id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch();

            print_r($result) ;
        }

        function remove_accents($str) {
            $accents = array(
                'à' => 'a', 'á' => 'a', 'ạ' => 'a', 'ả' => 'a', 'ã' => 'a', 'ạ' => 'a', 
                'ă' => 'a', 'ắ' => 'a', 'ằ' => 'a', 'ẵ' => 'a', 'ẳ' => 'a', 'ặ' => 'a', 
                'â' => 'a', 'ấ' => 'a', 'ầ' => 'a', 'ẫ' => 'a', 'ẩ' => 'a', 'ậ' => 'a',
                'è' => 'e', 'é' => 'e', 'ẹ' => 'e', 'ẻ' => 'e', 'ẽ' => 'e', 'ê' => 'e',
                'ề' => 'e', 'ế' => 'e', 'ễ' => 'e', 'ể' => 'e', 'ệ' => 'e',
                'ì' => 'i', 'í' => 'i', 'ị' => 'i', 'ỉ' => 'i', 'ĩ' => 'i',
                'ò' => 'o', 'ó' => 'o', 'ọ' => 'o', 'ỏ' => 'o', 'õ' => 'o', 'ô' => 'o',
                'ố' => 'o', 'ồ' => 'o', 'ỗ' => 'o', 'ổ' => 'o', 'ộ' => 'o',
                'ơ' => 'o', 'ớ' => 'o', 'ờ' => 'o', 'ỡ' => 'o', 'ở' => 'o', 'ợ' => 'o',
                'ù' => 'u', 'ú' => 'u', 'ụ' => 'u', 'ủ' => 'u', 'ũ' => 'u', 'ư' => 'u',
                'ứ' => 'u', 'ừ' => 'u', 'ữ' => 'u', 'ử' => 'u', 'ự' => 'u',
                'ỳ' => 'y', 'ý' => 'y', 'ỵ' => 'y', 'ỷ' => 'y', 'ỹ' => 'y',
                'đ' => 'd', 'Đ' => 'd'
            );
            return strtr($str, $accents);
        }
    
         function create_slug($title){
            $title = $this->remove_accents($title);
            $title = strtolower($title);
            $slug = preg_replace("/\s+/","-", $title);
           
    
            $slug = trim($slug, "-");
            return $slug;
        }
        public function create() {
            $sql = "select * from categories";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $category = $stmt->fetchAll(PDO::FETCH_ASSOC);

            
            include "views/admin/pages/tour/create.php";
        }

        public function createPost() {
            if($_POST){
                $title = $_POST["title"];
                $price = $_POST["price"];
                $discount = $_POST["discount"];
                $category_id = $_POST["category_id"];
                $information = $_POST["information"];
                $schedule = $_POST["schedule"];
                $timeStart = $_POST["timeStart"];
                $stock=$_POST["stock"];
                $status = $_POST["status"];


                $anh = []; // Mảng lưu tên các ảnh

                // Kiểm tra nếu có ảnh được gửi lên
                if (isset($_FILES["images"]) && !empty($_FILES["images"]["name"][0])) {
                // Đường dẫn đến thư mục lưu ảnh
                    $uploadDir = "C:/xampp/htdocs/tour_management/public/client/upload/tour/";

                    // Kiểm tra nếu thư mục chưa tồn tại, tạo mới thư mục
                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }


                    // Lặp qua từng ảnh được gửi lên
                    foreach ($_FILES["images"]["name"] as $key => $name) {
                        // Kiểm tra nếu không có lỗi trong quá trình upload
                        if ($_FILES["images"]["error"][$key] === UPLOAD_ERR_OK) {
                            $tmpName = $_FILES["images"]["tmp_name"][$key];
                            // Tạo tên ảnh mới để tránh trùng lặp
                            $uniqueName = time() . '_' . basename($name);
                            // Đường dẫn đầy đủ để lưu ảnh
                            $uploadPath = $uploadDir . $uniqueName;

                            // Di chuyển file từ thư mục tạm tới thư mục đích
                            if (move_uploaded_file($tmpName, $uploadPath)) {
                                $anh[] = $uniqueName; // Lưu tên ảnh vào mảng $anh
                                echo "Đã lưu ảnh: $uploadPath<br>"; // Hiển thị thông báo nếu ảnh đã lưu thành công
                            } else {
                                echo "Lỗi: Không thể lưu file tại đường dẫn: $uploadPath<br>"; // Thông báo lỗi nếu không thể lưu ảnh
                            }
                        } else {
                            echo "Lỗi upload file: " . $_FILES["images"]["error"][$key] . "<br>"; // Thông báo lỗi nếu có lỗi trong quá trình upload
                        }
                    }
                }

                        
                $jsonImages = json_encode($anh);

                    $slug = $this->create_slug($title);

                    $sql = "INSERT INTO tours (title, price, discount, information, schedule, timeStart, stock, status,slug, images, deleted, createdAt) 
                    VALUES (:title, :price, :discount, :information, :schedule, :timeStart, :stock, :status,:slug, :images, 0, now())";

                    $stmt = $this->conn->prepare($sql);

                    $stmt->bindValue(":title", $title);
                    $stmt->bindValue(":price", $price);
                    $stmt->bindValue(":discount", $discount);
                    $stmt->bindValue(":information", $information);
                    $stmt->bindValue(":schedule", $schedule);
                    $stmt->bindValue(":timeStart", $timeStart);
                    $stmt->bindValue(":stock", $stock);
                    $stmt->bindValue(":status", $status);
                    $stmt->bindValue(":slug", $slug);

                    $stmt->bindValue(":images", json_encode($anh));

                    $query = $stmt->execute();

                    $newID = $this->conn->lastInsertId();
                    $code = 'TOUR' . str_pad($newID, 6, '0', STR_PAD_LEFT);

                    $sql = "UPDATE tours SET code = :code WHERE id = :id";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindValue(':code', $code);
                    $stmt->bindValue(':id', $newID);
                    $stmt->execute();

                    $sql = "insert into tours_categories (tour_id, category_id) values ($newID, $category_id)";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->execute();

                    if ($query) {
                        header("Location:index");  // Chuyển hướng sau khi thành công
                    } else {
                        echo "THÊM THẤT BẠI, VUI LÒNG THỬ LẠI!!";  // Thông báo nếu không thành công
                    }
                    }
                }
            
        
        public function edit($url){
           $id = $url[3];

            // 1. Lấy thông tin tour
            $sql = "SELECT * FROM tours WHERE id = :id AND deleted = 0 LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['id' => $id]);
            $tour = $stmt->fetch(PDO::FETCH_ASSOC);

            // 2. Lấy danh sách danh mục còn hoạt động
            $sql = "SELECT * FROM categories WHERE deleted = 0 AND status = 'active'";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // 3. Lấy category_id từ bảng liên kết
            $sql = "SELECT category_id FROM tours_categories WHERE tour_id = :tour_id LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['tour_id' => $id]);
            $tour_category = $stmt->fetch(PDO::FETCH_ASSOC);

            // 4. Gán category_id vào tour (nếu có)
            if ($tour_category) {
                $tour['category_id'] = $tour_category['category_id'];
            } else {
                $tour['category_id'] = null;
            }
            
            $pageTitle ="Sửa ".$tour["title"];
            $images = json_decode($tour['images'] ?? '[]', true);
         
            include "views/admin/pages/tour/edit.php";
        }

        public function editPost($url){
            if($_SERVER["REQUEST_METHOD"] === "POST"){
                
                    $title = $_POST['title'] ;
                    $category_id = ($_POST['category_id']) ;
                    $price = ($_POST['price']) ;
                    $discount= ($_POST['discount']) ;
                    $stock= ($_POST['stock']) ;
                    $timeStart = ($_POST['timeStart']) ;
                    $information = ($_POST['information']) ;
                    $schedule = ($_POST['schedule']) ;
                    $status= ($_POST['status']) ;
                    $existingImages = ($_POST['existing_images']);

                    $existingImages = $_POST['existing_images'] ?? [];
                    $uploadedImages = [];
                    $uploadDir =  __DIR__ . "/../../public/client/upload/tour/";// Đường dẫn tuyệt đối đến thư mục lưu ảnh
         

                    if (!empty($_FILES['images']['name'][0])) {
                        foreach ($_FILES['images']['tmp_name'] as $i => $tmpName) {
                            if (is_uploaded_file($tmpName)) {
                                $fileName = basename($_FILES['images']['name'][$i]);

                                // Tạo đường dẫn lưu file vật lý
                                $targetPath = $uploadDir . $fileName;

                                // Di chuyển file vào thư mục đích
                                if (move_uploaded_file($tmpName, $targetPath)) {
                                    // Lưu đường dẫn tương đối để hiển thị lại ảnh
                                    $uploadedImages[] = $fileName;
                                }
                            }
                        }
                    }

                    // Gộp ảnh cũ và ảnh mới
                    $allImages = array_merge($existingImages, $uploadedImages);

                    // Chuyển thành JSON để lưu vào DB
                    $imagesJson = json_encode($allImages, JSON_UNESCAPED_SLASHES);

                    
                     // Giả sử bạn có biến $pdo là PDO kết nối
                    $sql = "UPDATE tours SET 
                    title = :title,
                    price = :price,
                    discount = :discount,
                    stock = :stock,
                    timeStart = :timeStart,
                    information = :information,
                    schedule = :schedule,
                    images = :images,
                    status = :status,
                    updatedAt= now()
                    WHERE id = :id";

                    $stmt = $this->conn->prepare($sql);
                    $query = $stmt->execute([
                        ':title' => $title,
                        ':price' => $price,
                        ':discount' => $discount,
                        ':stock' => $stock,
                        ':timeStart' => $timeStart,
                        ':information' => $information,
                        ':schedule' => $schedule,
                        ':images' => $imagesJson,
                        ':status' => $status,
                        ':id' => $url[3] ?? 0 // hoặc $_POST['id'] nếu bạn truyền qua POST
                ]);
                if ($query) {
                        header("Location:/tour_management/admin/tour");  // Chuyển hướng sau khi thành công
                        
                    } else {
                        echo "THÊM THẤT BẠI, VUI LÒNG THỬ LẠI!!";  // Thông báo nếu không thành công
                    }
                    
                }         
        }
    
        public function deletePost($url){
            $sql = "update tours set deleted = 1 where id = $url[3]";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            echo json_encode([
                'code' => 200,
                'data' => 'ok'
            ]);
        }

    }
?>
