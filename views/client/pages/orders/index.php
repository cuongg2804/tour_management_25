
<?php 
    include "./views/client/partials/header.php";
?>

<div id="app" class="container mt-4">
  <div class="alert alert-success" v-if="successMessage">{{ successMessage }}</div>

  <h1 class="mb-4">ĐƠN HÀNG</h1>
  <div class="card mb-3">
    <div class="card-header">Danh sách đơn hàng</div>
    <div class="card-body">
      <table class="table table-hover table-sm">
        <thead>
          <tr>
            <th>STT</th>
            <th>Mã đơn hàng</th>
            <th>Tổng đơn</th>
            <th>Thời gian đặt</th>
            <th>Trạng thái</th>
            <th>Cập nhật</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in orders" :key="item.id">
            <td>{{ index + 1 }}</td>
            <td>{{ item.id }}</td>
            <td>{{ item.totalPrice }}$</td>
            <td>{{ formatDate(item.createdAt) }}</td>
            <td>
              <button
                class="btn"
                :class="statusClass(item.status)"
              >
                {{ statusText(item.status) }}
              </button>
            </td>
            <td>
              <div>{{ item.createByFullName }}</div>
              <div>{{ formatDate(item.updateAt) }}</div>
            </td>
            <td>
              <a
                class="btn btn-info btn-sm ml-1"
                :href="`/${prefixAdmin}/orders/detail/${item.id}?status=${item.status}`"
              >
                Chi tiết
              </a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php  include "views/client/partials/footer.php"; ?>