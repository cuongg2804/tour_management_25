<?php include "views/admin/layouts/index.php"; ?>

<body>
  <div class="container mt-5">
    <h2 class="mb-4">Thống kê tour đã bán</h2>

    <!-- Form lọc -->
    <form class="form-inline mb-4" action="admin/report" method="POST">
      <label for="month" class="mr-2">Chọn tháng:</label>
      <input
        type="month"
        id="month"
        name="month"
        class="form-control mr-3"
        value="<?= htmlspecialchars($_POST['month'] ?? '') ?>"
      >

      <label for="status" class="mr-2">Trạng thái đơn:</label>
      <select id="status" name="status" class="form-control mr-3">
        <option value="">Tất cả</option>
        <option value="initial" <?= isset($_POST['status']) && $_POST['status'] == 'initial' ? 'selected' : '' ?>>Chờ xác nhận</option>
          <option value="confirmed" <?= isset($_POST['status']) && $_POST['status'] == 'confirmed' ? 'selected' : '' ?>>Đã xác nhận</option>
          <option value="paied" <?= isset($_POST['status']) && $_POST['status'] == 'paied' ? 'selected' : '' ?>>Đã thanh toán</option>
          <option value="shipping" <?= isset($_POST['status']) && $_POST['status'] == 'shipping' ? 'selected' : '' ?>>Đang diễn ra</option>
          <option value="delivered" <?= isset($_POST['status']) && $_POST['status'] == 'delivered' ? 'selected' : '' ?>>Hoàn thành</option>
          <option value="cancelled" <?= isset($_POST['status']) && $_POST['status'] == 'cancelled' ? 'selected' : '' ?>>Đã hủy</option>
      </select>

     

      <button type="submit" class="btn btn-primary">Lọc</button>
    </form>

    <!-- Bảng kết quả -->
    <table class="table table-bordered table-hover">
      <thead class="thead-light">
        <tr>
          <th>#</th>
          <th>Tên tour</th>
          <th>Lượt khách</th>
          <th>Doanh thu</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $totalGuests = 0;
          $totalRevenue = 0;
          if (!empty($results)) {
              foreach ($results as $index => $row) {
                  $totalGuests += $row['total_customers'];
                  $totalRevenue += $row['total_revenue'];
        ?>
          <tr>
            <td><?= $index + 1 ?></td>
            <td><?= htmlspecialchars($row['tour_name']) ?></td>
            <td><?= $row['total_customers'] ?></td>
            <td><?= number_format($row['total_revenue'], 0, ',', '.') ?>đ</td>
          </tr>
        <?php
              }
          } else {
        ?>
          <tr>
            <td colspan="4" class="text-center">Không có dữ liệu phù hợp.</td>
          </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr>
          <th colspan="2">Tổng</th>
          <th><?= $totalGuests ?></th>
          <th><?= number_format($totalRevenue, 0, ',', '.') ?>đ</th>
        </tr>
      </tfoot>
    </table>
  </div>
</body>

<?php include "views/admin/partials/footer.php"; ?>
