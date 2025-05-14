<?php include "views/client/partials/header.php"?>


<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-8">
      <h1 class="text-center">Đăng ký tài khoản</h1>
      <form action="user/register" method="POST">
        <div class="form-group">
          <label for="fullName">Họ và tên</label>
          <input
            type="text"
            class="form-control"
            id="fullName"
            name="fullName"
            required
          >
        </div>
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
          >Đăng ký</button>
        </div>
      </form>
    </div>
  </div>
</div>

