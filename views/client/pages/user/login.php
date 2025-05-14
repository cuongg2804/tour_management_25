<?php include "views/client/partials/header.php"?>

<?php if (!empty($_SESSION['error'])): ?>
  <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-8">
      <h1 class="text-center">Đăng nhập tài khoản</h1>
      <form action="user/login" method="POST">
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
          <label for="password">Mật khẩu</label>
          <input
            type="password"
            class="form-control"
            id="password"
            name="password"
            required
          >
        </div>
        <div class="form-group">
          <button
            type="submit"
            class="btn btn-primary btn-block"
          >Đăng nhập</button>
        </div>
      </form>
       <a href="user/register">Đăng ký</a>
    </div>
  </div>
</div>
