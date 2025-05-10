<?php 
    include "views/admin/layouts/index.php";
?>

<form
    action="admin/tour/create"
    method="POST"
    enctype="multipart/form-data"
    form-send-data
>

    <div class="form-group">
        <label for="title">Tiêu đề</label>
        <input 
            type="text"
            class="form-control"
            id="title"
            name="title"
            required
        />
    </div>

    <div class="form-group">
        <label for="price">Giá</label>
        <input 
            type="number"
            class="form-control"
            id="price"
            name="price"
            value="0"
            min="0"
        />
    </div>

    <div class="form-group">
        <label for="discount">Giảm giá %</label>
        <input 
            type="number"
            class="form-control"
            id="discount"
            name="discount"
            value="0"
            min="0"
        />
    </div>

    <div class="form-group">
        <label for="category">Danh mục</label>
        <select 
            name="category_id"
            id="category"
            class="form-control"
            required>
            <option value="" disabled selected>-- Chọn danh mục</option>
            <?php foreach($category as $index => $item): ?>
                <option value="<?= htmlspecialchars($item['id']) ?>"><?= htmlspecialchars($item['title']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="information">Thông tin</label>
        <textarea
            class="form-control"
            id="information"
            name="information"
            textarea-mce
        ></textarea>
    </div>

    <div class="form-group">
        <label for="schedule">Lịch trình</label>
        <textarea
            class="form-control"
            id="schedule"
            name="schedule"
            textarea-mce
        ></textarea>
    </div>

    <div class="form-group">
        <label for="timeStart">Lịch khởi hành</label>
        <input 
            type="datetime-local"
            class="form-control"
            id="timeStart"
            name="timeStart"
        />
    </div>

    <div class="form-group">
        <label for="stock">Số lượng</label>
        <input 
            type="number"
            class="form-control"
            id="stock"
            name="stock"
            value="0"
            min="0"
        />
    </div>

    <div class="form-group">
        <div class="custom-file-container" data-upload-id="upload-images">
                <input type="file" id="fileInput" name="images[]" class="custom-file-container__custom-file__custom-file-input" accept="image/*" multiple>
                <label for="fileInput" class="custom-file-container__custom-file__custom-file-control" >
                    Chọn ảnh
                </label>
                <div class="custom-file-container__image-preview">
                </div>
            </div>
    </div>


    <div class="form-group">
        <label>Trạng thái</label><br>
        <div class="form-check form-check-inline">
            <input
                type="radio"
                class="form-check-input"
                id="statusActive"
                name="status"
                value="active"
                checked>
            <label for="statusActive" class="form-check-label">Hoạt động</label>
        </div>
        <div class="form-check form-check-inline">
            <input
                type="radio"
                class="form-check-input"
                id="statusInActive"
                name="status"
                value="inactive"
            >
            <label for="statusInActive" class="form-check-label">Dừng hoạt động</label>
        </div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">Tạo mới</button>
    </div>
</form>

<?php 
    include "views/admin/partials/footer.php";
?>
