<?php include "views/admin/layouts/index.php"

?>

<h1 class="mb-4 text-center">ĐƠN HÀNG</h1>

<div class="card mb-3 shadow-sm">
  <div class="card-header bg-primary text-white">
    <h5 class="mb-0">Danh sách đơn hàng</h5>
  </div>
  <div class="card-body">

  <form method="GET" action="" class="mb-4">
  <div class="row">
    <!-- Lọc ngày bắt đầu -->
    <div class="col-md-4">
      <label for="startDate" class="form-label">Ngày bắt đầu</label>
      <input type="date" id="startDate" name="startDate" class="form-control" value="<?= isset($_GET['startDate']) ? $_GET['startDate'] : '' ?>">
    </div>

    <!-- Lọc ngày kết thúc -->
    <div class="col-md-4">
      <label for="endDate" class="form-label">Ngày kết thúc</label>
      <input type="date" id="endDate" name="endDate" class="form-control" value="<?= isset($_GET['endDate']) ? $_GET['endDate'] : '' ?>">
    </div>

    <!-- Nút Lọc -->
    <div class="col-md-4 d-flex align-items-end">
      <button type="submit" class="btn btn-success btn-sm w-100">Lọc</button>
    </div>
  </div>

  <div class="row mt-3">
    <!-- Lọc trạng thái đơn hàng -->
    <div class="col-md-12">
      <div class="select-container">
        <label for="orderStatus" class="form-label">Chọn trạng thái</label>
        <select name="orderStatus" id="orderStatus" class="form-select form-select-lg">
          <option value="">Tất cả</option>
          <option value="initial" <?= isset($_GET['orderStatus']) && $_GET['orderStatus'] == 'initial' ? 'selected' : '' ?>>Chờ xác nhận</option>
          <option value="confirmed" <?= isset($_GET['orderStatus']) && $_GET['orderStatus'] == 'confirmed' ? 'selected' : '' ?>>Đã xác nhận</option>
          <option value="paied" <?= isset($_GET['orderStatus']) && $_GET['orderStatus'] == 'paied' ? 'selected' : '' ?>>Đã thanh toán</option>
          <option value="shipping" <?= isset($_GET['orderStatus']) && $_GET['orderStatus'] == 'shipping' ? 'selected' : '' ?>>Đang diễn ra</option>
          <option value="delivered" <?= isset($_GET['orderStatus']) && $_GET['orderStatus'] == 'delivered' ? 'selected' : '' ?>>Hoàn thành</option>
          <option value="cancelled" <?= isset($_GET['orderStatus']) && $_GET['orderStatus'] == 'cancelled' ? 'selected' : '' ?>>Đã hủy</option>
        </select>
      </div>
    </div>
  </div>
</form>

    <table class="table table-bordered table-striped table-sm">
      <thead class="table-dark">
        <tr>
          <th>STT</th>
          <th>Mã đơn hàng</th>
          <th>Tổng đơn</th>
          <th>Thời gian đặt</th>
          <th>Trạng thái</th>
          <th>Cập nhật</th>
          <th>Chi tiết</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($orderList)): ?>
          <?php foreach ($orderList as $index => $item): ?>
            <tr>
              <td><?= $index + 1 ?></td>
              <td><?= htmlspecialchars($item['code']) ?></td>
              <td><?= number_format($item['totalPrice'], 0, ',', '.') ?>đ</td>
              <td><?= date('d-m-Y', strtotime($item['createdAt'])) ?></td>
              <td>
                <?php
                  switch ($item['status']) {
                      case 'initial': ?>
                          <span class="badge bg-warning">Chờ xác nhận</span>
                          <?php break;
                      case 'confirmed': ?>
                          <span class="badge bg-primary">Đã xác nhận</span>
                          <?php break;
                      case 'paied': ?>
                          <span class="badge bg-secondary">Đã thanh toán</span>
                          <?php break;
                      case 'shipping': ?>
                          <span class="badge bg-info">Đang diễn ra</span>
                          <?php break;
                      case 'delivered': ?>
                          <span class="badge bg-success">Hoàn thành</span>
                          <?php break;
                      case 'cancelled': ?>
                          <span class="badge bg-danger">Đã hủy</span>
                          <?php break;
                      default: ?>
                          <span class="badge bg-dark">Không rõ</span>
                <?php } ?>
              </td>
              <td><?= date('d-m-Y', strtotime($item['updatedAt'])) ?></td>
              <td>
                <a href="admin/order/detail/<?= htmlspecialchars($item['id']) ?>?status=<?= $item['status'] ?>" class="btn btn-info btn-sm">Chi tiết</a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="7" class="text-center text-muted">Không có đơn hàng nào.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include "views/admin/partials/footer.php"?>
