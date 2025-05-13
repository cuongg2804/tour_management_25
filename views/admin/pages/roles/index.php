<?php include "views/admin/layouts/index.php" ?>;
  <div class="container my-3">
    <h1 class="mb-4">Nhóm quyền</h1>

    <div class="card mb-3">
      <div class="card-header">Danh sách</div>
      <div class="card-body">
        <div class="row">
          <div class="col-8"></div>
          <div class="col-4 text-right">
            <a href="admin/roles/create" class="btn btn-outline-success">+ Thêm mới</a>
          </div>
        </div>

        <table class="table table-hover table-sm">
          <thead>
            <tr>
              <th>STT</th>
              <th>Nhóm quyền</th>
              <th>Mô tả ngắn</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($roleList) > 0): ?>
              <?php foreach ($roleList as $index => $item): ?>
                <tr>
                  <td><?php echo $index + 1; ?></td>
                  <td><?php echo htmlspecialchars($item['title']); ?></td>
                  <td><?php echo htmlspecialchars($item['description']); ?></td>
                  <td>
                    <a href="admin/roles/detail/<?php echo $item['id']; ?>" class="btn btn-secondary btn-sm">Chi tiết</a>
                    <a href="admin/roles/edit/<?php echo $item['id']; ?>" class="btn btn-warning btn-sm ml-1">Sửa</a>
                    <button class="btn btn-danger btn-sm ml-1" btn-delete data-id="<?php echo $item['id']; ?>" title="<?php echo $item['title']; ?>">Xóa</button>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="4" class="text-center">Chưa có nhóm quyền nào được tạo.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <?php include "views/admin/partials/footer.php" ?>


