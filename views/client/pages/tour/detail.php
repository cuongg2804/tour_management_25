<?php 
    include "./views/client/partials/header.php";
?>

<div class="alert alert-success alert-hidden" alert-add-cart-success>
  Đã thêm tour vào giỏ hàng! <span>x</span>
</div>

<div class="tour-detail">
  <div class="container my-3">
    <div class="row">
      <div class="col-6">
        <div class="inner-images">
          <div class="swiper sliderMain">
            <div class="swiper-wrapper">
              <?php if (!empty($tourDetail['images'])): ?>
                <?php foreach ($tourDetail['images'] as $image): ?>
                  <div class="swiper-slide">
                    <div class="inner-image">
                      <img src="<?=htmlspecialchars($image)?>" alt="<?= htmlspecialchars($tourDetail['title']); ?>">
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
            <div class="swiper-pagination"></div>
          </div>
        </div>
      </div>

      <div class="col-6">
        <div class="inner-title"><?= htmlspecialchars($tourDetail['title']) ?></div>

        <div class="inner-barcode">
          <i class="fa-solid fa-barcode"></i> Mã tour: <?= htmlspecialchars($tourDetail['code']) ?>
        </div>

        <div class="inner-time-start">
          <i class="fa-solid fa-calendar-days"></i> Lịch khởi hành: <?= htmlspecialchars($tourDetail['timeStart']) ?>
        </div>

        <div class="inner-stock">
          <i class="fa-solid fa-person-walking-luggage"></i> Còn lại: <?= intval($tourDetail['stock']) ?> chỗ
        </div>

        <div class="inner-price-special">
          <?= number_format($tourDetail['price_special'], 0, ',', '.') ?>đ
        </div>

        <div class="inner-price">
          <?= number_format($tourDetail['price'], 0, ',', '.') ?>đ
        </div>

        <div class="inner-percent">
          Giảm tới <?= intval($tourDetail['discount']) ?>%
        </div>

        <form action="" form-add-to-cart>
          <input type="hidden" name="tour_id" value="<?= $tourDetail['id'] ?>">
          <input
            class="form-control mb-2"
            type="number"
            name="quantity"
            value="1"
            min="1"
            max="<?= intval($tourDetail['stock']) ?>"
          >
          <button type="submit" class="btn btn-success btn-block">Thêm vào giỏ hàng</button>
        </form>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-12">
        <div class="inner-infomation">
          <div class="inner-label">Thông tin tour</div>
          <div class="inner-text"><?= $tourDetail['information'] ?></div>
        </div>
      </div>

      <div class="col-12 mt-3">
        <div class="inner-infomation">
          <div class="inner-label">Lịch trình tour</div>
          <div class="inner-text"><?= $tourDetail['schedule'] ?></div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php  include "views/client/partials/footer.php"; ?>