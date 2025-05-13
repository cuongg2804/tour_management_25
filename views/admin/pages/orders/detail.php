<?php include "views/admin/layouts/index.php" ?>

<div class="container my-4">
    <h1 class="mb-4 text-primary">🧾 Chi tiết đơn hàng</h1>

    <?php if ($order): ?>
        <!-- Thông tin khách hàng -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <strong>👤 Thông tin khách hàng</strong>
            </div>
            <div class="card-body">
                <table class="table table-bordered mb-0">
                    <tbody>
                        <tr>
                            <td width="200">Họ tên</td>
                            <td><strong><?= htmlspecialchars($order['fullName']) ?></strong></td>
                        </tr>
                        <tr>
                            <td>Số điện thoại</td>
                            <td><strong><?= htmlspecialchars($order['phone']) ?></strong></td>
                        </tr>
                        <tr>
                            <td>Địa chỉ</td>
                            <td><strong><?= htmlspecialchars($order['note']) ?></strong></td>
                        </tr>
                        <tr>
                            <td>Ghi chú</td>
                            <td><strong><?= htmlspecialchars($order['note']) ?></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Danh sách sản phẩm -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <strong>📦 Danh sách sản phẩm</strong>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>STT</th>
                            <th>Ảnh</th>
                            <th>Tên</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tổng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tourInfor as $index => $item): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td>
                                    <img src="public/client/upload/tour/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" width="70">
                                </td>
                                <td>
                                    <a href="admin/tour/detail/<?= htmlspecialchars($item['id']) ?>">
                                        <?= htmlspecialchars($item['title']) ?>
                                    </a>
                                </td>
                                <td><?= number_format($item['price'], 0, ',', '.') ?>đ</td>
                                <td><?= $item['quantity'] ?></td>
                                <td><?= number_format($item['totalPrice'], 0, ',', '.') ?>đ</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tổng tiền và cập nhật trạng thái -->
        <div class="row mb-4 align-items-center">
            <div class="col-md-6">
                <label for="orderStatus" class="form-label fw-bold">📝 Trạng thái đơn hàng:</label>
                <select name="orderStatus" id="orderStatus" class="form-select w-75">
                    <option value="initial" <?= $order['status'] == 'initial' ? 'selected' : '' ?>>Chờ xác nhận</option>
                    <option value="confirmed" <?= $order['status'] == 'confirmed' ? 'selected' : '' ?>>Đã xác nhận</option>
                    <option value="paied" <?= $order['status'] == 'paied' ? 'selected' : '' ?>>Đã thanh toán</option>
                    <option value="shipping" <?= $order['status'] == 'shipping' ? 'selected' : '' ?>>Đang giao hàng</option>
                    <option value="delivered" <?= $order['status'] == 'delivered' ? 'selected' : '' ?>>Hoàn thành</option>
                    <option value="cancelled" <?= $order['status'] == 'cancelled' ? 'selected' : '' ?>>Đã hủy</option>
                </select>
            </div>
            <div class="col-md-6 text-end">
                <h4 class="text-danger mb-2">
                    💰 Tổng đơn hàng: <?= number_format($order['totalPrice'], 0, ',', '.') ?>đ
                </h4>
                <?php if (count($tourInfor) > 0): ?>
                    <button class="btn btn-primary" data-id="<?= $order['id'] ?>" id="update-order">Cập nhật</button>
                <?php endif; ?>
            </div>
        </div>

        <!-- Form cập nhật trạng thái -->
        <form data-path="admin/order/update" method="POST" enctype="multipart/form-data" form-update></form>

    <?php else: ?>
        <div class="alert alert-warning">Không tìm thấy đơn hàng.</div>
    <?php endif; ?>
</div>

<?php include "views/admin/partials/footer.php" ?>
