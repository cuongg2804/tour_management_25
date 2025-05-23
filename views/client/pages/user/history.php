<?php include "views/client/partials/header.php"?>

<?php if (empty($orders)): ?>
    <p>Chưa có đơn hàng nào.</p>
<?php else: ?>
    <div class="container my-3">
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
                        <!-- Hiển thị trạng thái đơn hàng -->
                        <tr>
                            <td>Trạng thái</td>
                            <td>
                                <?php
                                // So sánh trạng thái đơn hàng và hiển thị tên trạng thái tương ứng
                                switch ($order['status']) {
                                    case 'initial':
                                        echo "Chờ xác nhận";
                                        break;
                                    case 'confirmed':
                                        echo "Đã xác nhận";
                                        break;
                                    case 'paied':
                                        echo "Đã thanh toán";
                                        break;
                                    case 'shipping':
                                        echo "Đang diễn ra";
                                        break;
                                    case 'delivered':
                                        echo "Hoàn thành";
                                        break;
                                    case 'cancelled':
                                        echo "Đã hủy";
                                        break;
                                    default:
                                        echo "Trạng thái không xác định";
                                        break;
                                }
                                ?>
                            </td>
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
                        <?php foreach ($listOrderItem as $index => $tour): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td>
                                    <img src="<?= "public/client/upload/tour/".$tour["image"] ?>" alt="Ảnh tour" height="60">
                                </td>
                                <td><?= htmlspecialchars($tour['title']) ?></td>
                                <td><?= number_format($tour['price']) ?>đ</td>
                                <td><?= $tour['quantity'] ?></td>
                                <td><?= number_format($tour['total'] ) ?>đ</td>
                                <td><?= date('d/m/Y H:i', strtotime($tour['timeStart'])) ?></td>
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
<?php endif; ?>
