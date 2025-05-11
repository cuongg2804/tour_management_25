<?php 
    include "./views/client/partials/header.php";
?>

<div class="cart">
<div class="container">
<div class="row">
    <div class="col-12">
      <table class="table table-bordered" table-cart>      
          <thead>
          <tr>
            <th>STT</th>
            <th>Ảnh</th>
            <th>Tiêu đề</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Tổng tiền</th>
            <th>Hành động</th>
          </tr>
          </thead>
          <tbody>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          </tbody>
      </table>
      <h5 class="text-right mb-4">
        Tổng đơn hàng: <span total-price>0</span>đ
      </h5>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <form id="form-order">
        <div class="form-group">
          <label for="fullName">Họ tên</label>
          <input
            type="text"
            class="form-control"
            id="fullName"
            name="fullName"
            required
          />
        </div>

        <div class="form-group">
          <label for="phone">Số điện thoại</label>
          <input
            type="text"
            class="form-control"
            id="phone"
            name="phone"
            required
          />
        </div>

        <div class="form-group">
          <label for="note">Ghi chú</label>
          <textarea
            class="form-control"
            id="note"
            name="note"
            rows="2"
          ></textarea>
        </div>

        <div class="form-group">
          <button
            type="submit"
            class="btn btn-success btn-block"
          >
            ĐẶT TOUR
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
</div>

<?php 
    include "./views/client/partials/footer.php";
?>