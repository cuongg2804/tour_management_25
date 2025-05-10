<?php 
    include "views/admin/layouts/index.php";
?>

<h1 class="mb-4"><?= htmlspecialchars($pageTitle) ?></h1>

<div class="card mb-3">
  <div class="card-header">Danh sách</div>
  <div class="card-body">

    <!-- Thanh tìm kiếm -->
    <form method="GET" class="form-inline mb-3">
        <input
          type="text"
          name="keyword"
          class="form-control mr-2"
          placeholder="Tìm kiếm..."
          value="<?= htmlspecialchars($keyword ?? '') ?>"
        >
        <button type="submit" class="btn btn-primary">Tìm</button>
      </form>

    <div class="row">
      <div class="col-8"></div>
      <div class="col-4 text-right">
        <a href="admin/tour/create" class="btn btn-outline-success">+ Thêm mới</a>
      </div>
    </div>

    <table class="table table-hover table-sm mt-3">
      <thead>
        <tr>
          <th>STT</th>
          <th>Hình ảnh</th>
          <th>Tiêu đề</th>
          <th>Giá</th>
          <th>% Giảm giá</th>
          <th>Giá đặc biệt</th>
          <th>Còn lại</th>
          <th>Trạng thái</th>
          <th>Vị trí</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
            <?php foreach ($listTour as $index => $item): ?>
              <tr>
                <td><?= $index + 1 ?></td>
                <td><img src="<?= $item['image'] ?>" alt="<?= $item['title'] ?>" width="100"></td>
                <td><?= htmlspecialchars($item['title']) ?></td>
                <td><?=number_format($item['price'], 0, ',', '.')?>đ</td>
                <td><?= $item['discount'] ?>%</td>
                <td><?=number_format($item['price_special'], 0, ',', '.')?>đ</td>
                <td><?= $item['stock'] ?></td>
                <td>
                  <?php if ($item['status'] === 'active'): ?>
                    <a href="admin/tour/inactive/<?= $item['id'] ?>" class="badge badge-success">Hoạt động</a>
                  <?php else: ?>
                    <a href="admin/tour/active/<?= $item['id'] ?>" class="badge badge-danger">Dừng hoạt động</a>
                  <?php endif; ?>
                </td>
                <td><?= $item['position'] ?></td>
                <td>
                  <a href="admin/tour/detail/<?= $item['id'] ?>" class="btn btn-secondary btn-sm">Chi tiết</a>
                  <a href="admin/tour/edit/<?= $item['id'] ?>" class="btn btn-warning btn-sm ml-1">Sửa</a>
                  <button class="btn btn-danger btn-sm ml-1" title="<?= $item['title'] ?>">Xóa</button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
    </table>

    <!-- Phân trang -->
    <nav class="d-flex justify-content-center mt-4">
    <?php if (!empty($objPagination)): ?>
        <nav>
          <ul class="pagination">
            <!-- Ví dụ đơn giản -->
            <?php for ($i = 1; $i <= $objPagination['totalPage']; $i++): ?>
              <li class="page-item <?= $i == $objPagination['currentPage'] ? 'active' : '' ?>">
                <a class="page-link" href="admin/tour?page=<?= $i ?>">
                  <?= $i ?>
                </a>
              </li>
            <?php endfor; ?>
          </ul>
        </nav>
      <?php endif; ?>
    </nav>


  </div>
</div>
</main>


