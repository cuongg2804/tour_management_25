<?php include "views/admin/partials/css.php" ?>
<?php if (!empty($_SESSION['error'])): ?>
  <div class="alert alert-danger">
    <?= $_SESSION['error'] ?>
  </div>
  <?php unset($_SESSION['error']); ?>
<?php endif; ?>
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

      <!-- Đồng hồ đếm ngược -->
      <div class="alert alert-warning text-center" id="countdown-box">
        Mã OTP sẽ hết hạn sau: <span id="timer">01:00</span>
      </div>

      <form action="admin/auth/verify" method="POST">
        <div class="form-group">
          <label for="token">Nhập mã OTP</label>
          <input
            type="text"
            class="form-control"
            id="token"
            name="token"
            required
          >
        </div>
        <input type="hidden" name="email" value="<?= htmlspecialchars($url[3] ?? '') ?>">
        <div class="form-group">
          <button
            type="submit"
            class="btn btn-primary btn-block"
          >Xác nhận</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include "views/admin/partials/footer.php" ?>
