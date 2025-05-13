<?php
    include "./views/admin/layouts/index.php";
?>


    <h2>Tổng quan</h2>

    <div class="row mt-4">
      

        <!-- Product Statistics -->
        <div class="col-6">
            <div class="card mb-4">
                <div class="card-header">Sản phẩm</div>
                <div class="card-body">
                    <p>Số lượng: <b><?php echo $products['total']; ?></b></p>
                    <p>Hoạt động: <b><?php echo $products['active']; ?></b></p>
                    <p>Dừng hoạt động: <b><?php echo $products['inactive']; ?></b></p>
                </div>
            </div>
        </div>

        

        <!-- Product Category Statistics -->
        <div class="col-6">
            <div class="card mb-4">
                <div class="card-header">Danh mục sản phẩm</div>
                <div class="card-body">
                    <p>Số lượng: <b><?php echo $products_category['total']; ?></b></p>
                    <p>Hoạt động: <b><?php echo $products_category['active']; ?></b></p>
                    <p>Dừng hoạt động: <b><?php echo $products_category['inactive']; ?></b></p>
                </div>
            </div>
        </div>

          <!-- Account Information -->
        <div class="col-6">
            <div class="card mb-4">
                <div class="card-header">Thông tin tài khoản</div>
                <div class="card-body">
    
                    <?php if ($user['fullName']): ?>
                        <p>Họ tên: <b><?php echo $user['fullName']; ?></b></p>
                    <?php endif; ?>
                    <?php if ($user['title']): ?>
                        <p>Họ tên: <b><?php echo $user['title']; ?></b></p>
                    <?php endif; ?>
                    <?php if ($user['email']): ?>
                        <p>Email: <b><?php echo $user['email']; ?></b></p>
                    <?php endif; ?>
                    <?php if ($user['phone']): ?>
                        <p>Số điện thoại: <b><?php echo $user['phone']; ?></b></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>