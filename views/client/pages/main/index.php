<?php
  include "views/client/partials/header.php";
?>
    <div class="section-1">
      <div class="container">
        <div class="section-1__wrap">
          <div class="section-1__bg-head"></div>
          <div class="section-1__content"><img class="section-1__bg-1" src="assets/images/section-1-bg-1.svg" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
            <h1 class="section-1__title" data-aos="fade-up" data-aos-duration="800">Thêm Một Bạn</h1>
            <h2 class="section-1__sub-title" data-aos="fade-up" data-aos-duration="800" data-aos-delay="150">Thêm Ngàn Niềm Vui!</h2>
            <p class="section-1__desc" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">Có một con thú cưng đồng nghĩa với việc bạn có thêm niềm vui mới. Chúng tôi có hơn 200 con thú cưng khác nhau có thể đáp ứng nhu cầu của bạn!</p>
            <div class="section-1__buttons"><a class="button" href="#" data-aos="fade-up" data-aos-duration="800" data-aos-delay="450">Giới Thiệu <i class="fa-regular fa-circle-play"></i></a><a class="button button--primiry" href="#" data-aos="fade-up" data-aos-duration="800" data-aos-delay="600">Khám Phá Ngay</a></div><img class="section-1__bg-2" src="assets/images/section-1-bg-2.svg" data-aos="fade-up" data-aos-duration="800" data-aos-delay="750">
          </div>
          <div class="section-1__image"><img class="section-1__thumb" src="assets/images/image-1.png" data-aos="fade-up" data-aos-duration="800" data-aos-delay="450"><img class="section-1__bg-3" src="assets/images/section-1-bg-3.svg" data-aos="fade-up" data-aos-duration="800" data-aos-delay="150"></div>
        </div>
      </div>
    </div>
    <div class="section-2">
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
        $imageUrl = $images[0] ;
        $title = $tour['title'];
        $code = $tour['code'];
        $price = $tour['price'];
        $discount = $tour['discount'];
        $finalPrice = $price * (1 - $discount / 100);
      ?>
      <div class="section-2__item">
        <div class="section-2__image">
          <a href="tour/detail/<?= htmlspecialchars($tour['slug'])?>">
            <img src="<?= htmlspecialchars($imageUrl) ?>" alt="<?= htmlspecialchars($code . ' - ' . $title) ?>">
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
          <div class="section-3__image"><img src="assets/images/image-2.png" alt="Thêm Một Bạn" data-aos="fade-up" data-aos-duration="800"></div>
          <div class="section-3__content">
            <h2 class="section-3__title" data-aos="fade-up" data-aos-duration="800">Thêm Một Bạn</h2>
            <h3 class="section-3__sub-title" data-aos="fade-up" data-aos-duration="800" data-aos-delay="150">Thêm Ngàn Niềm Vui!</h3>
            <p class="section-3__desc" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">Có một con thú cưng đồng nghĩa với việc bạn có thêm niềm vui mới. Chúng tôi có hơn 200 con thú cưng khác nhau có thể đáp ứng nhu cầu của bạn!</p>
            <div class="section-3__buttons"><a class="button" href="#" data-aos="fade-up" data-aos-duration="800" data-aos-delay="450">Giới Thiệu <i class="fa-regular fa-circle-play"></i></a><a class="button button--primiry" href="#" data-aos="fade-up" data-aos-duration="800" data-aos-delay="600">Khám Phá Ngay</a></div>
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
          <div class="section-4__item">
            <div class="section-4__image"><a href="#"><img src="assets/images/post-1.jpg"></a></div>
            <div class="section-4__content">
              <div class="section-4__tag">Kiến thức thú cưng</div>
              <h3 class="section-4__title"><a href="#">Pomeranian là gì? Cách nhận biết chó Pomeranian</a></h3>
              <div class="section-4__desc">Pomeranian hay còn gọi là chó Pomeranian (chó Pom) luôn nằm trong top những thú cưng dễ thương nhất. Không chỉ vậy, giống chó xiếc nhỏ nhắn, đáng yêu, thông minh, thân thiện và khéo léo.</div>
            </div>
          </div>
          <div class="section-4__item">
            <div class="section-4__image"><a href="#"><img src="assets/images/post-2.jpg"></a></div>
            <div class="section-4__content">
              <div class="section-4__tag">Kiến thức thú cưng</div>
              <h3 class="section-4__title"><a href="#">Chế độ ăn cho chó bạn cần biết</a></h3>
              <div class="section-4__desc">Việc chia khẩu phần ăn cho chó thoạt nghe có vẻ đơn giản nhưng có một số quy tắc bạn nên biết để chó cưng dễ dàng hấp thụ các chất dinh dưỡng trong khẩu phần ăn. Dành cho những người mới bắt đầu nuôi chó, đặc biệt là chó con mới sinh có sức đề kháng tương đối yếu.</div>
            </div>
          </div>
          <div class="section-4__item">
            <div class="section-4__image"><a href="#"><img src="assets/images/post-3.jpg"></a></div>
            <div class="section-4__content">
              <div class="section-4__tag">Kiến thức thú cưng</div>
              <h3 class="section-4__title"><a href="#">Tại sao chó cắn phá đồ đạc và cách phòng ngừa hiệu quả</a></h3>
              <div class="section-4__desc">Chó cắn là hiện tượng phổ biến trong quá trình phát triển. Tuy nhiên, không ai muốn thấy đồ đạc, vật dụng quan trọng của mình bị chó cắn.</div>
            </div>
          </div>
        </div>
        <div class="section-4__button-bottom"><a class="button" href="#">Xem thêm <i class="fa-solid fa-angle-right"></i></a></div>
      </div>
    </div>
    
<?php 

  include "views/client/partials/footer.php";

?>