<?php 
    include "views/admin/layouts/index.php";
?>

<form
    action="admin/category/create"
    method="POST"
    enctype="multipart/form-data"
>
    <div class="form-group">
        <label for="title">Tiêu đề
        <input
            type="text"
            class="form-control"
            id="title"
            name="title"
            required
        >
    </div>

    <div class="form-group">
        <label for="title">Mô tả
        <textarea
            type="text"
            class="form-control"
            id="description"
            name="description"
            value=""
            textarea-mce
        ></textarea>
    </div>
    <div class="form-group" upload-image>
      <label for="images"> Hình ảnh
      <input
        type="file"
        class="form-control-file"
        id="images"
        name="images"
        accept="image/*"
        upload-image-input
      >
     <img
          src=""
          class="image-preview"
          upload-image-preview
        >
    </div>

    <div class="form-group">
        <label for="title">Trạng thái</label>
        <br>
        <div class="form-group form-check form-check-inline">
        <input
            type="radio"
            class="form-check-input"
            id="statusActive"
            name="status"
            value="active"
            checked>
        <label for="statusActive" class="form-check-label"> Hoạt động
        </div>
        <div class="form-group form-check form-check-inline">
        <input
            type="radio"
            class="form-check-input"
            id="statusInActive"
            name="status"
            value="inactive"
        >
        <label for="statusInActive" class="form-check-label"> Dừng hoạt động
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Tạo mới</button>
    </div>
</form>



<?php include "views/admin/partials/footer.php";