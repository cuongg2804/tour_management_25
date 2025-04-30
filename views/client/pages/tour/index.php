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
            <?php if (!empty($item["image"])): ?>
              <img src="<?= htmlspecialchars($item["image"]) ?>" alt="<?= htmlspecialchars($item['title']) ?>" class="card-img-top">
            <?php endif; ?>
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($item['title']) ?></h5>
              <b class="mr-2 mb-2">
                <?= number_format($item['price_special'], 0, ',', '.') ?>đ
              </b>
              <del class="mb-2">
                <?= number_format($item['price'], 0, ',', '.') ?>đ
              </del>
              <p class="font-weight-bold">Giảm <?= intval($item['discount']) ?>%</p>
              <a href="/tours/detail/<?= htmlspecialchars($item['slug']) ?>" class="btn btn-primary">Xem chi tiết</a>
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