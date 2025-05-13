<?php include "views/admin/partials/css.php" ; ?>

<?php if (!empty($_SESSION['error'])): ?>
  <div class="alert alert-danger">
    <?= $_SESSION['error'] ?>
  </div>
  <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-8">
      <h1 class="text-center">Đăng nhập</h1>
      <form action="admin/auth/login" method="POST">
        <div class="form-group">
          <label for="email">Email</label>
          <input
            type="email"
            class="form-control"
            id="email"
            name="email"
            required
          />
        </div>
        <div class="form-group">
          <label for="password">Mật khẩu</label>
          <input
            type="password"
            class="form-control"
            id="password"
            name="password"
            required
          />
        </div>
        <div class="form-group">
          <button
            type="submit"
            class="btn btn-primary btn-block"
          >
            Đăng nhập
          </button>
        </div>
        <div>
          <a href="admin/auth/forget">Quên mật khẩu</a>
        </div>
      </form>
    </div>
  </div>
</div>
