<?php include "./views/admin/layouts/index.php" ?>

<div class="main-content p-3">
  <h1 class="mb-4"><?= htmlspecialchars($pageTitle) ?></h1>

  <div class="card mb-5">
    <div class="card-header">Danh sách danh mục</div>
    <div class="card-body">
      <!-- Search form -->
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
          <a href="admin/category/create" class="btn btn-outline-success">
            + Thêm mới
          </a>
        </div>
      </div>

      <table class="table table-hover table-sm mt-3">
        <thead>
          <tr>
            <th>STT</th>
            <th>Hình ảnh</th>
            <th>Tiêu đề</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($listCategory as $index => $item): ?>
            <tr>
              <td><?= $index + 1 ?></td>
              <td>
              <!-- <img src="public/client/upload/<?=htmlspecialchars($item['image']);?>" alt="<?= htmlspecialchars($item['title']); ?>"
                     width="100px" height="auto"> -->

              <img src="<?=htmlspecialchars($item['image']);?>" alt="<?= htmlspecialchars($item['title']); ?>"
                width="100px" height="auto">
              </td>
              <td><?= htmlspecialchars($item['title']) ?></td>
              <td>
                <?php if ($item['status'] === 'active'): ?>
                  <a href="javascript:;" class="badge badge-success">Hoạt động</a>
                <?php else: ?>
                  <a href="javascript:;" class="badge badge-danger">Dừng hoạt động</a>
                <?php endif; ?>
              </td>
              <td>
                <a href="admin/category/detail/<?= $item['id'] ?>"
                   class="btn btn-secondary btn-sm">Chi tiết</a>

                <a href="admin/category/edit/<?= $item['id'] ?>"
                   class="btn btn-warning btn-sm ml-1">Sửa</a>

                <button class="btn btn-danger btn-sm ml-1"
                        title="<?= htmlspecialchars($item['title']) ?>"
                        data-id="<?= $item['id'] ?>"
                        button-delete-category>
                  Xóa
                </button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <!-- Pagination -->
      <?php if (!empty($objPagination)): ?>
        <nav class="d-flex justify-content-center mt-4">
          <ul class="pagination">
            <!-- Ví dụ đơn giản -->
            <?php for ($i = 1; $i <= $objPagination['totalPage']; $i++): ?>
              <li class="page-item <?= $i == $objPagination['currentPage'] ? 'active' : '' ?>">
                <a class="page-link" href="admin/category?page=<?= $i ?>">
                  <?= $i ?>
                </a>
              </li>
            <?php endfor; ?>
          </ul>
        </nav>
      <?php endif; ?>
    </div>
  </div>
</div>
