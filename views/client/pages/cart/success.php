<?php 
    include "./views/client/partials/header.php";
?>

<div class="container my-3">
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success">
                Chúc mừng bạn đã đặt hàng thành công! Mã đơn hàng của bạn là <b><?= htmlspecialchars($order['code']) ?></b>.
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div>Thông tin khách hàng</div>

            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>Họ tên</td>
                        <td><?= htmlspecialchars($order['fullName']) ?></td>
                    </tr>
                    <tr>
                        <td>Số điện thoại</td>
                        <td><?= htmlspecialchars($order['phone']) ?></td>
                    </tr>
                    <tr>
                        <td>Ghi chú</td>
                        <td><?= htmlspecialchars($order['note']) ?></td>
                    </tr>
                    <tr>
                        <td>Ngày đặt</td>
                        <td><?= htmlspecialchars($order['createdAt']) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div>Danh sách Tour</div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Ảnh</th>
                        <th>Tiêu đề</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng tiền</th>
                        <th>Ngày khởi hành</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listOrderItem as $index => $item): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" width="80px"></td>
                            <td><a ><?= htmlspecialchars($item['title']) ?></a></td>
                            <td><?= number_format($item['price_special']) ?>đ</td>
                            <td><?= $item['quantity'] ?></td>
                            <td><?= number_format($item['total']) ?>đ</td>
                            <td><?= date('d/m/Y', strtotime($item['timeStart'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h5 class="text-right mb-4">
                Tổng đơn hàng: <?= number_format($totalPrice) ?>đ
            </h5>
        </div>
    </div>
</div>

<?php 
    include "./views/client/partials/footer.php";
?>