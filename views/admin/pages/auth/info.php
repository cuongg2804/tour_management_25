<?php include "views/admin/layouts/index.php"?>

<div class="form-box">
        <h2>Chỉnh sửa thông tin người dùng</h2>
        <form action="admin/auth/myaccount" method="post">
            <!-- Trường ẩn để gửi ID -->
            <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">

            <div class="form-group">
                <label for="fullName">Họ tên:</label>
                <input type="text" id="fullName" name="fullName" value="<?= htmlspecialchars($user['fullName']) ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>

            <input type="submit" value="Thay đổi">
        </form>
    </div>