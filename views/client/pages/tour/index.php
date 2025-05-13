<?php 
    include "./views/client/partials/header.php";
?>

<div class="container my-3">
  <div class="row">
    <div class="col-12">
      <div class="box-head">
        <h1><?= htmlspecialchars($pageTitle) ?></h1>
      </div>
    </div>
  </div>

  <div class="row">
    <?php if (!empty($toursList)): ?>
      <?php foreach ($toursList as $item): ?>
        <div class="col-6 mb-3">
          <div class="card">
            <?php if (!empty($item["images"])): ?>
              <img src="public/client/upload/tour/<?=htmlspecialchars($item["image"])?>" alt="<?= htmlspecialchars($item['title']); ?>">
            <?php endif; ?>
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($item['title']) ?></h5>
              <b class="mr-2 mb-2">
                <?= number_format($item['price_special'], 0, ',', '.') ?>đđ
              </b>
              <del class="mb-2">
                <?= number_format($item['price'], 0, ',', '.') ?>đ
              </del>
              <p class="font-weight-bold">Giảm <?= intval($item['discount']) ?>%</p>
              <a href="tour/detail/<?= htmlspecialchars($item['slug']) ?>" class="btn btn-primary">Xem chi tiết</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="col-12">
        <p>Không có tour nào để hiển thị.</p>
      </div>
    <?php endif; ?>
  </div>
</div>


<?php  include "views/client/partials/footer.php"; ?>