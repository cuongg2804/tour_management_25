<?php 
    include "views/admin/layouts/index.php";
?>

<h1 class="mb-4"><?= htmlspecialchars($pageTitle) ?></h1>

<form action="/admin/tours/edit/<?= $tour['id'] ?>?_method=PATCH" method="POST" enctype="multipart/form-data">
  <div class="form-group">
    <label for="title">Tiêu đề</label>
    <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($tour['title']) ?>" required>
  </div>

  <div class="form-group">
    <label for="category">Danh mục</label>
    <select name="category_id" id="category" class="form-control" required>
      <?php foreach ($categories as $item): ?>
        <option value="<?= $item['id'] ?>" <?= $item['id'] == $tour['category_id'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($item['title']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="form-group">
    <label for="price">Giá</label>
    <input type="number" class="form-control" id="price" name="price" value="<?= $tour['price'] ?>" min="0">
  </div>

  <div class="form-group">
    <label for="discount">% Giảm giá</label>
    <input type="number" class="form-control" id="discount" name="discount" value="<?= $tour['discount'] ?>" min="0">
  </div>

  <div class="form-group">
    <label for="stock">Số lượng</label>
    <input type="number" class="form-control" id="stock" name="stock" value="<?= $tour['stock'] ?>" min="0">
  </div>

  <div class="form-group">
    <label for="timeStart">Lịch khởi hành</label>
    <input type="datetime-local" class="form-control" id="timeStart" name="timeStart"
           value="<?= date('Y-m-d\TH:i', strtotime($tour['timeStart'])) ?>">
  </div>

  <div class="form-group">
    <label for="information">Thông tin</label>
    <textarea class="form-control" id="information" name="information" textarea-mce ><?= htmlspecialchars($tour['information']) ?></textarea>
  </div>

  <div class="form-group">
    <label for="schedule">Lịch trình</label>
    <textarea class="form-control" id="schedule" name="schedule" textarea-mce><?= htmlspecialchars($tour['schedule']) ?></textarea>
  </div>

<div class="form-group">
  <div class="custom-file-container" data-upload-id="upload-images">
    <input type="file" id="fileInput" name="images[]" class="custom-file-container__custom-file__custom-file-input" accept="image/*" multiple>
    
    <label for="fileInput" class="custom-file-container__custom-file__custom-file-control">
      Chọn ảnh
    </label>

    <div class="custom-file-container__image-preview">
      <?php if (!empty($images)): ?>
        <?php foreach ($images as $index => $img): ?>
          <div class="preview-item" data-index="<?= $index ?>">
            <img src="<?= htmlspecialchars($img) ?>" style="width: 350px;; border:1px solid #ccc; border-radius:4px;">
            <button type="button" class="image-clear" data-index="<?= $index ?>">x</button>
            <input type="hidden" name="existing_images[]" value="<?= htmlspecialchars($img) ?>">
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</div>



  <div class="form-group form-check form-check-inline">
    <input type="radio" class="form-check-input" id="statusActive" name="status" value="active"
           <?= $tour['status'] === 'active' ? 'checked' : '' ?>>
    <label class="form-check-label" for="statusActive">Hoạt động</label>
  </div>

  <div class="form-group form-check form-check-inline">
    <input type="radio" class="form-check-input" id="statusInActive" name="status" value="inactive"
           <?= $tour['status'] === 'inactive' ? 'checked' : '' ?>>
    <label class="form-check-label" for="statusInActive">Dừng hoạt động</label>
  </div>

  <div class="form-group">
    <button type="submit" class="btn btn-primary">Cập nhật</button>
  </div>
</form>

<?php 
    include "views/admin/partials/footer.php";
?>
