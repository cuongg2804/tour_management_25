<div class="sider">
  <div class="inner-menu">
    <ul>
      <li><a href="admin/dashboard">Tổng quan</a></li>

      <?php if (in_array('products-category_view', $_SESSION['user']['permissions'])): ?>
        <li><a href="admin/category">Quản lý danh mục</a></li>
      <?php endif; ?>

      <?php if (in_array('products-view', $_SESSION['user']['permissions'])): ?>
        <li><a href="admin/tour">Quản lý tour</a></li>
      <?php endif; ?>
      <?php if (in_array('orders-view', $_SESSION['user']['permissions'])): ?>
        <li><a href="admin/order">Quản lý đơn hàng</a></li>
      <?php endif; ?>
      <?php if (in_array('roles-view', $_SESSION['user']['permissions'])): ?>
        <li><a href="admin/roles">Nhóm quyền</a></li>
      <?php endif; ?>

      <?php if (in_array('roles-permissions', $_SESSION['user']['permissions'])): ?>
        <li><a href="admin/roles/permissions">Phân quyền</a></li>
      <?php endif; ?>

      <?php if (in_array('accounts-view', $_SESSION['user']['permissions'])): ?>
        <li><a href="admin/accounts">Tài khoản admin</a></li>
      <?php endif; ?>

      <?php if (in_array('users-view', $_SESSION['user']['permissions'])): ?>
        <li><a href="admin/users">Tài khoản user</a></li>
      <?php endif; ?>

      <?php if (in_array('settings-general', $_SESSION['user']['permissions'])): ?>
        <li><a href="admin/settings/general">Cài đặt chung</a></li>
      <?php endif; ?>

      <?php if (in_array('reports-view', $_SESSION['user']['permissions'])): ?>
        <li><a href="admin/report">Báo cáo, thống kê</a></li>
      <?php endif; ?>
    </ul>
  </div>
</div>
</body>
</html>



