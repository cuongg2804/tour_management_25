<div class="sider">
  <div class="inner-menu">
    <ul class="menu-list">

      <li><a href="admin/dashboard"><i class="fas fa-tachometer-alt"></i> Tổng quan</a></li>

      <?php if (in_array('products-category_view', $_SESSION['user']['permissions'])): ?>
        <li><a href="admin/category"><i class="fas fa-tags"></i> Quản lý danh mục</a></li>
      <?php endif; ?>

      <?php if (in_array('products-view', $_SESSION['user']['permissions'])): ?>
        <li><a href="admin/tour"><i class="fas fa-route"></i> Quản lý tour</a></li>
      <?php endif; ?>

      <?php if (in_array('orders-view', $_SESSION['user']['permissions'])): ?>
        <li><a href="admin/order"><i class="fas fa-shopping-cart"></i> Quản lý đơn hàng</a></li>
      <?php endif; ?>

      <?php if (in_array('roles-view', $_SESSION['user']['permissions'])): ?>
        <li><a href="admin/roles"><i class="fas fa-users-cog"></i> Nhóm quyền</a></li>
      <?php endif; ?>

      <?php if (in_array('roles-permissions', $_SESSION['user']['permissions'])): ?>
        <li><a href="admin/roles/permissions"><i class="fas fa-key"></i> Phân quyền</a></li>
      <?php endif; ?>

      <?php if (in_array('accounts-view', $_SESSION['user']['permissions'])): ?>
        <li><a href="admin/accounts"><i class="fas fa-user-shield"></i> Tài khoản admin</a></li>
      <?php endif; ?>

      <?php if (in_array('users-view', $_SESSION['user']['permissions'])): ?>
        <li><a href="admin/users"><i class="fas fa-user"></i> Tài khoản user</a></li>
      <?php endif; ?>

      <?php if (in_array('settings-general', $_SESSION['user']['permissions'])): ?>
        <li><a href="admin/settings/general"><i class="fas fa-cogs"></i> Cài đặt chung</a></li>
      <?php endif; ?>

      <?php if (in_array('reports-view', $_SESSION['user']['permissions'])): ?>
        <li><a href="admin/report"><i class="fas fa-chart-line"></i> Báo cáo, thống kê</a></li>
      <?php endif; ?>

    </ul>
  </div>
</div>
