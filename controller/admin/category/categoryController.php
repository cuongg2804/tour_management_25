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
        $sqlCount = "SELECT count(*) from categories where $where";
        $stmtCount =$this->conn->prepare($sqlCount);
        foreach($params as $key => $value){
            $stmtCount->bindValue($key,$value);
        }
        $stmtCount->execute();
        $totalRecord = $stmtCount->fetchColumn();

        $objPagination['totalPage'] = (int) ( $totalRecord / $objPagination['limit']) + 1;
         //End Pagination



        $sql = "SELECT * FROM categories where $where LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($sql);
        foreach($params as $key => $value){
            $stmt->bindValue($key,$value);
        }
        $stmt->bindValue(":limit",$objPagination["limit"],PDO::PARAM_INT);
        $stmt->bindValue(":offset",$objPagination["skip"],PDO::PARAM_INT);
        $stmt->execute();
        $listCategory = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $pageTitle="Danh mục";
        // Gọi view hiển thị
        include 'views/admin/pages/category/index.php';
    }

    public function create(){
        $pageTitle = "Tạo danh mục";
        include "views/admin/pages/category/create.php";
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

    public function createPost(){
       // print_r ($_FILES);
       ob_start();
            if (isset($_POST["title"]) && isset($_POST["description"]) &&isset($_POST["status"]) ){
                $title = $_POST["title"];
                $des = $_POST["description"];
                $status = $_POST["status"];

                $anh = null;
                if (isset($_FILES["images"]) && $_FILES["images"]["error"] == 0) {
                    $anh = basename($_FILES["images"]["name"]);
                    $uploadDir =  __DIR__ . "/../../../public/client/upload/";
              
                    $uploadPath = $uploadDir . $anh;
                    //echo $uploadPath;
                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    move_uploaded_file($_FILES["images"]["tmp_name"], $uploadPath);
                    

                }
                $slug = $this->create_slug($title);
                $sql = "INSERT INTO categories (title, image, description, status, slug, deleted, createdAt) 
                VALUES (:title,:image, :description, :status, :slug, 0, NOW())"; // Sử dụng NOW() cho createdAt

                $stmt = $this->conn->prepare($sql);

                // Liên kết các tham số với giá trị
                $stmt->bindValue(":title", $title);
                $stmt->bindValue(":image", $anh);
                $stmt->bindValue(":description", $des);
                $stmt->bindValue(":status", $status);  // Cần bind tham số cho status
                $stmt->bindValue(":slug", $slug);

                // Thực thi câu lệnh SQL
                $query = $stmt->execute();

                if ($query) {
                    header("Location:index");  // Chuyển hướng sau khi thành công
                } else {
                    echo "THÊM THẤT BẠI, VUI LÒNG THỬ LẠI!!";  // Thông báo nếu không thành công
                }

            }
        
    }
}
?>
