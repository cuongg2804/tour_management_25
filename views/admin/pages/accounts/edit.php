<?php include "views/admin/layouts/index.php"?>

<form 
  action="admin/accounts/edit/<?php echo $data['id']; ?>" 
  method="POST" 
  enctype="multipart/form-data"
>
  <div class="form-group">
    <label for="fullName">Họ tên *</label>
    <input 
      type="text" 
      class="form-control" 
      id="fullName" 
      name="fullName" 
      required 
      value="<?php echo htmlspecialchars($data['fullName'] ?? ''); ?>"
    />
  </div>

  <div class="form-group">
    <label for="email">Email *</label>
    <input 
      type="email" 
      class="form-control" 
      id="email" 
      name="email" 
      required 
      value="<?php echo htmlspecialchars($data['email'] ?? ''); ?>"
    />
  </div>

  <div class="form-group">
    <label for="phone">Số điện thoại</label>
    <input 
      type="text" 
      class="form-control" 
      id="phone" 
      name="phone" 
      value="<?php echo htmlspecialchars($data['phone'] ?? ''); ?>"
    />
  </div>


  <div class="form-group">
    <label for="role_id">Phân quyền</label>
    <select name="role_id" id="role_id" class="form-control">
      <option disabled>-- Chọn --</option>
      <?php foreach ($roles as $item) : ?>
        <option 
          value="<?php echo $item['id']; ?>" 
          <?php if ($item['id'] == $data['role_id']) echo 'selected'; ?>
        >
          <?php echo htmlspecialchars($item['title']); ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="form-group form-check form-check-inline">
    <input 
      type="radio" 
      class="form-check-input" 
      id="statusActive" 
      name="status" 
      value="active" 
      <?php if (($data['status'] ?? '') === 'active') echo 'checked'; ?>
    />
    <label for="statusActive" class="form-check-label">Hoạt động</label>
  </div>

  <div class="form-group form-check form-check-inline">
    <input 
      type="radio" 
      class="form-check-input" 
      id="statusInActive" 
      name="status" 
      value="inactive" 
      <?php if (($data['status'] ?? '') === 'inactive') echo 'checked'; ?>
    />
    <label for="statusInActive" class="form-check-label">Dừng hoạt động</label>
  </div>

  <div class="form-group mt-3">
    <button type="submit" class="btn btn-primary">Cập nhật</button>
  </div>
</form>
