<?php include "views/admin/layouts/index.php" ?>

<h1 class="mb-4">Danh sách tài khoản</h1>

<div class="card mb-3">
  <div class="card-header">Danh sách</div>
  <div class="card-body">
    <div class="row mb-3">
      <div class="col-8">
        <!-- Có thể thêm bộ lọc tìm kiếm ở đây nếu cần -->
      </div>
      <div class="col-4 text-right">
        <a href="admin/accounts/create" class="btn btn-outline-success">
          + Thêm mới
        </a>
      </div>
    </div>

    <table class="table table-bordered table-hover table-sm">
      <thead class="thead-light">
        <tr>
          <th>#</th>
          <th>Họ và tên</th>
          <th>Email</th>
          <th>SĐT</th>
          <th>Vai trò</th>
          <th>Trạng thái</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($accList)) : ?>
          <?php foreach ($accList as $index => $item) : ?>
            <tr>
              <td><?php echo $index + 1; ?></td>
              <td><?php echo htmlspecialchars($item['fullName']); ?></td>
              <td><?php echo htmlspecialchars($item['email']); ?></td>
              <td><?php echo htmlspecialchars($item['phone']); ?></td>
              <td>
                <?php echo ($item['title']); ?>
              </td>
              <td>
                <span class="badge badge-<?php echo ($item['status'] == 'active') ? 'success' : 'secondary'; ?>">
                  <?php echo ucfirst($item['status']); ?>
                </span>
              </td>
              <td>
                <a href="admin/accounts/edit/<?php echo $item['id']; ?>" class="btn btn-sm btn-warning">Sửa</a>
                <button class="btn btn-sm btn-danger" btn-delete-acc title="<?php echo $item['fullName']; ?>" data-id="<?php echo $item['id']; ?>">Xóa</button>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else : ?>
          <tr>
            <td colspan="7" class="text-center text-muted">Chưa có tài khoản nào.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include "views/admin/partials/footer.php" ?>
