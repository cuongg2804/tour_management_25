<?php
  include "views/client/partials/header.php";
?>
    <div class="section-1">
      <div class="container">
        <div class="section-1__wrap">
          <div class="section-1__bg-head"></div>
          <div class="section-1__content"><img class="section-1__bg-1" src="public/client/image/section-1-bg-1.svg" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
            <h1 class="section-1__title" data-aos="fade-up" data-aos-duration="800">Hành Trình Mới</h1>
            <h2 class="section-1__sub-title" data-aos="fade-up" data-aos-duration="800" data-aos-delay="150">Trải nghiệm mới!</h2>
            <p class="section-1__desc" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">Bạn xứng đáng với những chuyến đi đáng nhớ!
            Chúng tôi có hơn 300 tour du lịch trong và ngoài nước để bạn khám phá thế giới theo cách riêng của mình!</p>
            <div class="section-1__buttons">
              <a class="button" href="#" data-aos="fade-up" data-aos-duration="800" data-aos-delay="450">Giới Thiệu <i class="fa-regular fa-circle-play"></i></a>
              <a class="button button--primiry" href="/tour_management/category" data-aos="fade-up" data-aos-duration="800" data-aos-delay="600">Khám Phá Ngay</a>
            </div>
          </div>
          <div class="section-1__image"><img class="section-1__thumb" src="public/client/image/image1.png" data-aos="fade-up" data-aos-duration="800" data-aos-delay="450"><img class="section-1__bg-3" src="public/client/image/section-1-bg-3.svg" data-aos="fade-up" data-aos-duration="800" data-aos-delay="150"></div>
       
        </div>
      </div>
    </div>
    <div class="section-2" id="section-2">
      <div class="container">
        <div class="box-head">
          <div class="box-head__left">
            <div class="box-head__sub-title">Có gì mới?</div>
            <div class="box-head__title">Các tour nổi bật</div>
          </div>
          <div class="box-head__right"><a class="button" href="category">Xem thêm <i class="fa-solid fa-angle-right"></i></a></div>
        </div>
        <div class="section-2__wrap">
    <?php foreach ($result as $tour): ?>
      <?php
        $images = json_decode($tour['images']);
       // $imageUrl = $images[0]  ;
        $title = $tour['title'];
        $code = $tour['code'];
        $price = $tour['price'];
        $discount = $tour['discount'];
        $finalPrice = $price * (1 - $discount / 100);
      ?>
      <div class="section-2__item">
        <div class="section-2__image">
          <a href="tour/detail/<?= htmlspecialchars($tour['slug'])?>">
            <!-- <img src="<?= htmlspecialchars($imageUrl) ?>" alt="<?= htmlspecialchars($code . ' - ' . $title) ?>"> -->
          </a>
        </div>
        <div class="section-2__content">
          <h3 class="section-2__title">
            <a href="tour/detail/<?= htmlspecialchars($tour['slug'])?>"><?= htmlspecialchars($code . ' - ' . $title) ?></a>
          </h3>
          <div class="section-2__info">
            <!-- Các trường thông tin khác nếu có -->
          </div>
          <div class="section-2__price">
            <?= number_format($finalPrice, 0, ',', '.') ?> VNDD
          </div>
        </div>
      </div>
    <?php endforeach; ?>
</div>
        <div class="section-2__button-bottom"><a class="button" href="#">Xem thêm <i class="fa-solid fa-angle-right"></i></a></div>
      </div>
    </div>
    <div class="section-3">
      
        <div class="container">
          <div class="section-3__wrap">
            <div class="section-3__image">
              <a href="tour/detail/<?= htmlspecialchars($tour['slug'])?>">
              <img src="<?= htmlspecialchars(json_decode($tour['images'])[0]) ?>" alt="<?= htmlspecialchars($tour['title']) ?>" data-aos="fade-up" data-aos-duration="800">
              </a>
            </div>
            <div class="section-3__content">
              <h2 class="section-3__title" data-aos="fade-up" data-aos-duration="800">Tour đang Hot</h2>
              <h3 class="section-3__sub-title" data-aos="fade-up" data-aos-duration="800" data-aos-delay="150"><?= htmlspecialchars($tour['title']) ?></h3>
              <p class="section-3__desc" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300"><?= htmlspecialchars($tour['schedule']) ?></p>
              
              <a class="button button--primiry" href="tour/detail/<?= htmlspecialchars($tour['slug'])?>" data-aos="fade-up" data-aos-duration="800" data-aos-delay="600">Khám Phá Ngay</a>
             
            </div>
          </div>
        </div>
    
    </div>
    <div class="section-4">
      <div class="container">
        <div class="box-head">
          <div class="box-head__left">
            <div class="box-head__sub-title">Có thể bạn đã biết?</div>
            <h2 class="box-head__title">Kiến thức thú cưng hữu ích</h2>
          </div>
          <div class="box-head__right"><a class="button" href="#">Xem thêm <i class="fa-solid fa-angle-right"></i></a></div>
        </div>
        <div class="section-4__wrap">
          <?php foreach ($result as $tour): ?>
            <div class="section-4__item">
              <div class="section-4__image">
                <a href="/tour/detail/<?= htmlspecialchars($tour['slug']) ?>">
                  <img src="<?= htmlspecialchars(json_decode($tour['images'])[0]) ?>" alt="<?= htmlspecialchars($tour['title']) ?>">
                </a>
              </div>
              <div class="section-4__content">
                <div class="section-4__tag">Tour du lịch</div>
                <h3 class="section-4__title">
                  <a href="/tour/<?= htmlspecialchars($tour['slug']) ?>">
                    <?= htmlspecialchars($tour['title']) ?>
                  </a>
                </h3>
                <div class="section-4__desc"><?= nl2br(htmlspecialchars($tour['information'])) ?></div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="section-4__button-bottom"><a class="button" href="#">Xem thêm <i class="fa-solid fa-angle-right"></i></a></div>
      </div>
    </div>
    
<?php 

  include "views/client/partials/footer.php";

?>