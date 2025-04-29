
<div class="container my-3">
    <div class="row">
      <div class="col-12">
        <!-- box-head (pageTitle) sẽ được chèn ở đây, bạn cần tự render -->
        <div class="box-head">
          <h1>Tiêu đề trang  </h1>
        </div>
      </div>
    </div>
    <div class="row">
      <!-- Lặp qua toursList -->
      <!-- Ví dụ giả sử bạn có danh sách dữ liệu toursList trong Javascript để render -->
      <!-- Dưới đây mình sẽ viết mẫu một item -->

      <div class="col-6 mb-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Tên Tour</h5>
            <b class="mr-2 mb-2">1,000,000đ</b>
            <del class="mb-2">1,500,000đ</del>
            <p class="font-weight-bold">Giảm 30%</p>
            <a href="/tours/detail/slug-cua-tour" class="btn btn-primary">Xem chi tiết</a>
          </div>
        </div>
      </div>

      <!-- Lặp tiếp các item khác tương tự -->

    </div>
  </div>