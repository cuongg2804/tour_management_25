const sliderMain = document.querySelector(".sliderMain");
if(sliderMain) {
  const swiper = new Swiper(".sliderMain", {
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
  });
}

console.log("ok");


//CART 

//SHOW ALERT
const alertAddCartSusscess = () =>{
  const elementAlert =  document.querySelector("[alert-add-cart-success]");
  if(elementAlert){
    elementAlert.classList.remove("alert-hidden");

    setTimeout(() =>{
      elementAlert.classList.add("alert-hidden");
    }, 3000);
  }
}
//END SHOW ALERT

//Khởi tạo giỏ hàng
const cart = localStorage.getItem("cart");
if(!cart){
  localStorage.setItem("cart",JSON.stringify([]));
}
//Hết khởi tạo giỏ hàng

//Hiển thị số lượng vào giỏ hàng 
const showMiniCart = () => {
const miniCart = document.querySelector("[mini-cart]");
if(miniCart){
    const cart = JSON.parse(localStorage.getItem("cart"));
    miniCart.innerHTML = cart.length;
}
}

showMiniCart();

//Hiển thị số lượng vào giỏ hàng 
const formCart = document.querySelector("[form-add-to-cart]");
if(formCart) {
    formCart.addEventListener("submit", (event) =>  {
        event.preventDefault();
        const idTour = (formCart.querySelector('input[name="tour_id"]')).value;

        const quantity =  parseInt(formCart.querySelector("input").value);
        
        const cart = JSON.parse(localStorage.getItem("cart"));
        
        const existTour = cart.findIndex(item => item.tourId == idTour);
        if(existTour == -1) {
            cart.push ({
                tourId : idTour,
                quantity : quantity
            })
        }
        else{
            cart[existTour].quantity += quantity;
        }
        alertAddCartSusscess();
       
        localStorage.setItem("cart", JSON.stringify(cart));
        showMiniCart();
    })
}

// Vẽ thông tin đơn hàng
const drawCart = () => {
  const tableCart = document.querySelector("[table-cart]");
  if(tableCart) {
    fetch("cart/listjson", {
      method: "POST",
      headers: {"Content-Type" : "application/json"},
      body :localStorage.getItem("cart")
    })
    .then(res => res.json())
    .then(data => {
      const html = data.listTour.map((item, index) => `
        <tr>
            <td>${index+1}</td>
            <td><img src="${item.image}" alt="${item.title}" width="80px" /></td>
            <td><a href="/tours/detail/${item.slug}">${item.title}</a></td>
            <td>${item.price_special.toLocaleString()}đ</td>
            <td><input type="number" name="quantity" value="${item.quantity}" min="1" item-id="${item.id}" style="width: 60px" ></td>
            <td>${item.price.toLocaleString()}đ</td>
            <td><button class="btn btn-sm btn-danger" btn-delete="${item.id}">Xóa</button></td>
        </tr>
      `)

      const tbody = document.querySelector("tbody");
      tbody.innerHTML = html.join("");

      const totalOrder = document.querySelector("[total-price]");
      totalOrder.innerHTML = data.totalOrder.toLocaleString();

      deleteOrder();
      updateQuantity();
      showMiniCart();
      console.log(data);
    })
  }
  }
drawCart();

//Cập nhật số lượng giỏ hàng
const updateQuantity = () => {
  const inputQuantity = document.querySelectorAll("input[name='quantity']");
  if(inputQuantity.length >0 ) {
    inputQuantity.forEach((input) => {
      input.addEventListener("change", (event) => {
        event.preventDefault();
        const quantity = input.value;
        const tourId = input.getAttribute("item-id");

        const cart = JSON.parse(localStorage.getItem("cart"));
        const indexCartUpdate  = cart.findIndex((item) => item.tourId == tourId);
        cart[indexCartUpdate].quantity = parseInt(quantity);
        
        localStorage.setItem("cart", JSON.stringify(cart));
        drawCart();
      })
    })
  }
}
//Cập nhật số lượng giỏ hàng


//Xóa sản phẩm trong giỏ hàng
const deleteOrder = () =>{
  const btnDelete = document.querySelectorAll("[btn-delete]");
  if(btnDelete.length > 0 ){
    btnDelete.forEach((button) => {
      button.addEventListener("click", (event) => {
        event.preventDefault();
        const idTour = button.getAttribute("btn-delete");
        if(confirm("Bạn có chắc chắc muốn xóa tour không")){
          const cart = JSON.parse(localStorage.getItem("cart"));
          const newCart = cart.filter(item => item.tourId != idTour);
          localStorage.setItem("cart", JSON.stringify(newCart));

          drawCart();
        }
      }
      )
    })
  }
}
 //Xóa sản phẩm trong giỏ hàng

 const formOrder = document.querySelector("#form-order");
 console.log(formOrder);
if(formOrder) {
  
  formOrder.addEventListener("submit", (event) => {
    event.preventDefault();
    const fullName = formOrder.querySelector("input[name='fullName']");
    const phone = formOrder.querySelector("input[name='phone']");
    const  note = formOrder.querySelector("textarea[name='note']");

    const inforOrder = {
      info:{fullName : fullName.value,
        phone : phone.value,
        note : note.value,},
      cart : JSON.parse(localStorage.getItem("cart"))
    }

    fetch("cart/order",{
      method : "POST",
      headers: {
        "Content-Type" :"application/json"
      },
      body : JSON.stringify(inforOrder)
    })
    .then(res => res.json())
    .then(data => {
      if(data.code == 200) {
        localStorage.setItem("cart", JSON.stringify([]));
        window.location.href=`cart/success/${data.orderCode}`;
        console.log("Thành công");
      }
      else{
        alert("Lỗi đặt hàng");
      }
    })
  })
}
