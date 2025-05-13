<?php include "views/admin/layouts/index.php" ?>

<div class="container my-3">
    <h1 class="mb-4">Thêm mới nhóm quyền</h1>

    <form action="admin/roles/create" method="POST">
      <div class="form-group">
        <label for="title">Tiêu đề</label>
        <input type="text" class="form-control" id="title" name="title" required>
      </div>

      <div class="form-group">
        <label for="desc">Mô tả</label>
        <input type="text" class="form-control" id="desc" name="description">
      </div>

      <div class="form-group">
        <button type="submit" class="btn btn-primary">Tạo mới</button>
      </div>
    </form>
  </div>