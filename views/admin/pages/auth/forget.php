<?php include "views/admin/partials/css.php" ?>
<?php if (!empty($_SESSION['error'])): ?>
  <div class="alert alert-danger">
    <?= $_SESSION['error'] ?>
  </div>
  <?php unset($_SESSION['error']); ?>
<?php endif; ?>
<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-8">
      <h1 class="text-center">Lấy lại mật khẩu</h1>
      <?php if (isset($message)) : ?>
        <div class="alert alert-info text-center">
          <?= htmlspecialchars($message) ?>
        </div>
      <?php endif; ?>

      <form action="admin/auth/forget" method="POST">
        <div class="form-group">
          <label for="email">Email</label>
          <input
            type="email"
            class="form-control"
            id="email"
            name="email"
            required
          >
        </div>
        <div class="form-group">
          <button
            type="submit"
            class="btn btn-primary btn-block"
          >Gửi mail xác nhận</button>
        </div>
      </form>
    </div>
  </div>
</div>
