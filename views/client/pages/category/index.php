<?php 
    include "./views/client/partials/header.php";
?>


<div class="container my-3">
  <div class="row">
    <div class="col-12">
      <h1>Trang danh mục tour</h1>
    </div>
  </div>

  <div class="row">
    <?php if (!empty($query)): ?>
      <?php foreach ($query as $item): ?>
        <div class="col-6 mb-3">
          <div class="card">
            <!-- <img src="public/client/upload/<?=htmlspecialchars($item['image']); ?>" alt="<?= htmlspecialchars($item['title']); ?>"> -->
              <img src="<?=htmlspecialchars($item['image']); ?>" alt="<?= htmlspecialchars($item['title']); ?>">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($item['title']); ?></h5>
              <p class="card-text"><?= html_entity_decode($item['description']); ?></p>
              <a href="tour/index/<?= htmlspecialchars($item['slug']);?>" class="btn btn-primary">Xem chi tiết</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Không có danh mục nào.</p>
    <?php endif; ?>
  </div>
</div>

<?php 
    include "./views/client/partials/footer.php";
?>