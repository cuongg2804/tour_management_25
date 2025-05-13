<?php 
    include "./views/client/partials/header.php";
?>

<div class="category">
  <div class="container">
    <div class="box-title">
      <h1>Trang danh mục tour</h1>
    </div>
    <div class="cate-wrap">
      <?php if (!empty($query)): ?>
        <?php foreach ($query as $item): ?>
            <div class="cate-wrap__item">
                <div class="cate-wrap__image">
                  <img src="public/client/upload/<?=htmlspecialchars($item['image']); ?>" alt="<?= htmlspecialchars($item['title']); ?>">
                </div>
                <div class="cate-wrap__content">
                  <div class="cate-wrap__right">
                    <h5 class="cate-wrap__title"><?= htmlspecialchars($item['title']); ?></h5>
                    <p class="cate-wrap__text"><?= html_entity_decode($item['description']); ?></p>
                  </div>
                  <div class="cate-wrap__left">
                    <a href="tour/index/<?= htmlspecialchars($item['slug']);?>" class="button button-primary">Xem chi tiết</a>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
        <p>Không có danh mục nào.</p>
      <?php endif; ?>
    </div>
  </div>
</div>


<?php 
    include "./views/client/partials/footer.php";
?>