<?php include "views/admin/layouts/index.php" ?>

<?php if (!empty($records)) : ?>
  <div data-records='<?php echo json_encode($records); ?>'></div>
  <div class="text-right">
    <button
      type="submit"
      class="btn btn-primary mb-3"
      button-submit-permissions
    >Cập nhật</button>
  </div>

  <table class="table table-hover table-sm" table-permissions>
    <thead>
      <tr>
        <th>Tính năng</th>
        <?php foreach ($records as $item) : ?>
          <th class="text-center"><?php echo htmlspecialchars($item['title']); ?></th>
        <?php endforeach; ?>
      </tr>
    </thead>
    <tbody>
      <tr data-name="id" class="d-none">
        <td>Id nhóm quyền</td>
        <?php foreach ($records as $item) : ?>
          <td class="text-center">
            <input type="text" value="<?php echo $item['id']; ?>" />
          </td>
        <?php endforeach; ?>
      </tr>


      <?php
$permissionGroups = [
  'Danh mục sản phẩm' => [
    'products-category_view' => 'Xem',
    'products-category_create' => 'Thêm mới',
    'products-category_edit' => 'Chỉnh sửa',
    'products-category_delete' => 'Xóa'
  ],
  'Đơn hàng' => [
    'orders-view' => 'Xem',
    'orders-edit' => 'Chỉnh sửa',
  ],
  'Sản phẩm' => [
    'products-view' => 'Xem',
    'products-create' => 'Thêm mới',
    'products-edit' => 'Chỉnh sửa',
    'products-delete' => 'Xóa'
  ],
  'Phân quyền' => [
    'roles-view' => 'Xem',
    'roles-create' => 'Thêm mới',
    'roles-edit' => 'Chỉnh sửa',
    'roles-delete' => 'Xóa',
    'roles-permissions' => 'Nhóm quyền'
  ],
  'Tài khoản' => [
    'accounts-view' => 'Xem',
    'accounts-create' => 'Thêm mới',
    'accounts-edit' => 'Chỉnh sửa',
    'accounts-delete' => 'Xóa'
  ]
  ,
  'Thống kê,  báo  cáo' => [
    'reports-view' => 'Xem',
  ]
  
];
?>

<?php foreach ($permissionGroups as $groupTitle => $permissions) : ?>
  <tr>
    <td colspan="<?php echo count($records) + 1; ?>"><b><?php echo $groupTitle; ?></b></td>
  </tr>
  <?php foreach ($permissions as $permKey => $permLabel) : ?>
    <tr data-name="<?php echo $permKey; ?>">
      <td><?php echo $permLabel; ?></td>
      <?php foreach ($records as $item) : ?>
        <td class="text-center">
          <input type="checkbox" <?php if (in_array($permKey, json_decode($item['permissions'] ?? '[]'))) echo 'checked'; ?> />
        </td>
      <?php endforeach; ?>
    </tr>
  <?php endforeach; ?>
<?php endforeach; ?>

    </tbody>
  </table>

  

  <form form-change-permissions method="POST" action="admin/roles/permissions?_method=PATCH" class="d-none">
    <div class="form-group">
      <input type="text" class="form-control" name="roles" />
    </div>
  </form>
<?php else : ?>
  <p>Chưa có nhóm quyền nào</p>
<?php endif; ?>

<?php include "views/admin/partials/footer.php" ?>
