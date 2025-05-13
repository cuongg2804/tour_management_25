<?php include "views/admin/layouts/index.php" ?>
<h1 class="mb-4">Chỉnh sửa nhóm quyền</h1>

<!-- Thông báo (tùy framework sẽ có JS tương ứng) -->
<div class="alert alert-success" style="display: none;" id="alert-success"></div>
<div class="alert alert-danger" style="display: none;" id="alert-error"></div>

<form action="admin/roles/edit/<?= $data['id'] ?>" method="POST">
  <div class="form-group">
    <label for="title">Tiêu đề</label>
    <input
      type="text"
      class="form-control"
      id="title"
      name="title"
      required
      value="<?= htmlspecialchars($data['title']) ?>"
    >
  </div>

  <div class="form-group">
    <label for="desc">Mô tả</label>
    <input
      type="text"
      class="form-control"
      id="desc"
      name="description"
      value="<?= htmlspecialchars($data['description']) ?>"
    >
  </div>


  <div class="form-group">
    <button type="submit" class="btn btn-primary">Cập nhật</button>
  </div>
</form>
