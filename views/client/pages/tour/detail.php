<div class="alert alert-success alert-hidden" alert-add-cart-susscess>
  Đã thêm tour vào giỏ hàng! <span close-alert>x</span>
</div>

<div class="tour-detail">
  <div class="container my-3">
    <div class="row">
      <div class="col-6">
        <div class="inner-images">
          <div class="swiper sliderMain">
            <div class="swiper-wrapper">
              <?php foreach ($images as $index => $image): ?>
                <div class="swiper-slide">
                  <div class="inner-image">
                    <img src="<?= htmlspecialchars($image) ?>" alt="tour image <?= $index + 1 ?>">
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
          </div>
        </div>
      </div>

      <div class="col-6">
        <div class="inner-title"><?= htmlspecialchars($tour['title']) ?></div>

        <div class="inner-barcode">
          <i class="fa-solid fa-barcode"></i> Mã tour: <?= htmlspecialchars($tour['code']) ?>
        </div>

        <div class="inner-time-start">
          <i class="fa-solid fa-calendar-days"></i> Lịch khởi hành: <?= $timeStart ?>
        </div>

        <div class="inner-stock">
          <i class="fa-solid fa-person-walking-luggage"></i> Còn lại: <?= $tour['stock'] ?> chỗ
        </div>

        <div class="inner-price-special"><?= number_format($tour['price_special'], 0, ',', '.') ?>đ</div>
        <div class="inner-price"><?= number_format($tour['price'], 0, ',', '.') ?>đ</div>
        <div class="inner-percent">Giảm tới <?= $percent ?>%</div>

        <form form-add-to-cart tour-id="<?= $tour['code'] ?>">
          <input class="form-control mb-2" type="number" name="quantity" value="1" min="1" max="<?= $tour['stock'] ?>">
          <button type="submit" class="btn btn-success btn-block">Thêm vào giỏ hàng</button>
        </form>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="inner-infomation">
          <div class="inner-label">Thông tin tour</div>
          <div class="inner-text"><?= nl2br(htmlspecialchars($tour['information'])) ?></div>
        </div>
      </div>

      <div class="col-12">
        <div class="inner-infomation">
          <div class="inner-label">Lịch trình tour</div>
          <div class="inner-text"><?= nl2br(htmlspecialchars($tour['schedule'])) ?></div>
        </div>
      </div>
    </div>
  </div>
</div>