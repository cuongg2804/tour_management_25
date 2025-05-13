<?php include "views/admin/partials/css.php"?>

<?php if (isset($_SESSION['verified_email'])): ?>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-8">
            <h1 class="text-center">Đặt lại mật khẩu</h1>

            <form action="admin/auth/reset" method="POST">
                <div class="form-group">
                    <label for="new_password">Mật khẩu mới</label>
                    <input
                        type="password"
                        class="form-control"
                        id="new_password"
                        name="new_password"
                        required
                    >
                </div>
                <div class="form-group">
                    <label for="confirm_password">Xác nhận mật khẩu mới</label>
                    <input
                        type="password"
                        class="form-control"
                        id="confirm_password"
                        name="confirm_password"
                        required
                    >
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">
                        Cập nhật mật khẩu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

