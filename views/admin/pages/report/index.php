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
        <option value="pending" <?= ($_POST['status'] ?? '') === 'pending' ? 'selected' : '' ?>>Chờ xử lý</option>
        <option value="processing" <?= ($_POST['status'] ?? '') === 'processing' ? 'selected' : '' ?>>Đang xử lý</option>
        <option value="completed" <?= ($_POST['status'] ?? '') === 'completed' ? 'selected' : '' ?>>Hoàn thành</option>
        <option value="cancelled" <?= ($_POST['status'] ?? '') === 'cancelled' ? 'selected' : '' ?>>Đã hủy</option>
      </select>

      <label for="tour_name" class="mr-2">Tên tour:</label>
      <input
        type="text"
        id="tour_name"
        name="tour_name"
        class="form-control mr-3"
        placeholder="Nhập tên tour"
        value="<?= htmlspecialchars($_POST['tour_name'] ?? '') ?>"
      >

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
