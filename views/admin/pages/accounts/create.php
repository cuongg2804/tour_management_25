<?php include "views/admin/layouts/index.php"  ?>

<form action="admin/accounts/create" method="POST" enctype="multipart/form-data">
  <div class="form-group">
    <label for="fullName">Họ tên *</label>
    <input type="text" class="form-control" id="fullName" name="fullName" required>
  </div>

  <div class="form-group">
    <label for="email">Email *</label>
    <input type="email" class="form-control" id="email" name="email" required>
  </div>


  <div class="form-group">
    <label for="phone">Số điện thoại</label>
    <input type="text" class="form-control" id="phone" name="phone">
  </div>


  <div class="form-group">
    <label for="role_id">Phân quyền</label>
    <select name="role_id" id="role_id" class="form-control">
      <option disabled selected>-- Chọn --</option>
      <?php foreach ($roles as $role): ?>
        <option value="<?php echo $role['id']; ?>"><?php echo $role['title']; ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="form-group form-check form-check-inline">
    <input type="radio" class="form-check-input" id="statusActive" name="status" value="active" checked>
    <label for="statusActive" class="form-check-label">Hoạt động</label>
  </div>

  <div class="form-group form-check form-check-inline">
    <input type="radio" class="form-check-input" id="statusInActive" name="status" value="inactive">
    <label for="statusInActive" class="form-check-label">Dừng hoạt động</label>
  </div>

  <div class="form-group">
    <button type="submit" class="btn btn-primary">Tạo mới</button>
  </div>
</form>
