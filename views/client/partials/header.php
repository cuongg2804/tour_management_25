<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/tour_management/public/client/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?></title>
    <base href="/tour_management/">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/file-upload-with-preview/dist/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.6/viewer.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    
    <style>
        /* CSS cho dropdown */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {background-color: #f1f1f1;}

        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>

</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header__wrap">
                <div class="header__logo">
                    <a href="main">
                        <img src="public/client/image/logo.png" alt="Logo">
                    </a>
                </div>
                <div class="col-5">
                    <form action="search" method="GET">
                        <div class="form-group d-flex mb-0">
                            <input type="text" placeholder="Nhập từ khóa..." class="form-control" name="keyword" value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>" >
                            <button type="submit" class="btn btn-primary">Tìm</button>
                        </div>
                    </form>
                </div>
                <div class="header__menu">
                    <ul>
                        <li><a href="main">Trang chủ</a></li>
                        <li><a href="category">Danh mục</a></li>
                        
                        <?php if (!empty($_SESSION['user_id'])): ?>
                            <?php 
                                // Lấy thông tin người dùng từ session hoặc cơ sở dữ liệu 
                                $stmt = $this->conn->prepare("SELECT fullName FROM users WHERE id = ? AND deleted = 0");
                                $stmt->execute([$_SESSION['user_id']]);
                                $user = $stmt->fetch();
                            ?>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle"><?php echo htmlspecialchars($user['fullName']); ?></a>
                                <div class="dropdown-content">
                                  <li><a href="cart">Giỏ hàng (<span mini-cart>0</span>)</a></li>
                                    <a href="user/history">Lịch sử mua hàng</a>
                                    <a href="user/logout">Đăng xuất</a>
                                </div>
                            </li>
                        <?php else: ?>
                            <li><a href="user/login">Đăng nhập</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </header>
</body>
</html>
