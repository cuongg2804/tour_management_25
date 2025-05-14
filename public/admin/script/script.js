//Preview image
const uploadImage = document.querySelector("[upload-image]");
if(uploadImage){
    const uploadImg_Input = uploadImage.querySelector("[upload-image-input]");
    uploadImg_Input.addEventListener("change", () => {
        const imgPre = uploadImage.querySelector("[upload-image-preview]");
        imgPre.src = URL.createObjectURL(uploadImg_Input.files[0]);
    })
}

document.addEventListener("DOMContentLoaded", function () {
  const input = document.getElementById("fileInput");
  const previewContainer = document.querySelector(".custom-file-container__image-preview");

  // Xóa preview khi nhấn nút "x"
  previewContainer.addEventListener("click", function (e) {
    if (e.target.classList.contains("image-clear")) {
      const previewItem = e.target.closest(".preview-item");
      if (previewItem) previewItem.remove();
    }
  });

  // Thêm ảnh mới vào preview (không xoá ảnh cũ)
  input.addEventListener("change", function (event) {
    const files = event.target.files;

    Array.from(files).forEach(file => {
      const reader = new FileReader();

      reader.onload = function (e) {
        const previewItem = document.createElement("div");
        previewItem.classList.add("preview-item");

        const img = document.createElement("img");
        img.src = e.target.result;
        img.style.width = "100px";
        img.style.border = "1px solid #ccc";
        img.style.borderRadius = "4px";

        const clearButton = document.createElement("button");
        clearButton.classList.add("image-clear");
        clearButton.type = "button";
        clearButton.textContent = "x";

        previewItem.appendChild(img);
        previewItem.appendChild(clearButton);

        previewContainer.appendChild(previewItem);
      };

      reader.readAsDataURL(file);
    });
  });
});

// Xóa Tour
const listBtnDel = document.querySelectorAll("[button-delete]");
if(listBtnDel) {
    listBtnDel.forEach((button) => {
      console.log(button);
        button.addEventListener("click", (event) => {
            
            const idTour = button.getAttribute("data-id");
            const title = button.getAttribute("title");
            const isConfirm = confirm("Bạn có chắc chắn muốn xóa " + title);
            if(isConfirm) {
                fetch(`admin/tour/delete/${idTour}`,{
                    method :"POST"
                })
                .then((res) => res.json())
                .then((data) => {
                  console.log(data);
                    if(data.code == 200) {
                        location.reload();
                    }
                    else{
                        alert("Xóa thất bại, vui lòng thử lại!");
                    }
                })
            }
        })
    })
}

// Xóa Category
const listBtnDelCate = document.querySelectorAll("[button-delete-category]");
if(listBtnDelCate) {
    listBtnDelCate.forEach((button) => {
        button.addEventListener("click", (event) => {
            const idCategory = button.getAttribute("data-id");
            const title = button.getAttribute("title");
            const isConfirm = confirm("Bạn có chắc chắn muốn xóa " + title);
            if(isConfirm) {
                fetch(`admin/category/delete/${idCategory}`,{
                    medthod:"POST"
                })
                .then((res) => res.json())
                .then((data) => {
                    console.log(data);
                    if(data.code == 200) {
                        location.reload();
                    }
                    else{
                        alert("Xóa thất bại, vui lòng thử lại!");
                    }
                })
            }
        })
    })
}


//Change-status-
const select_status = document.getElementById("orderStatus");

let statusOrders = "";
if(select_status){
    select_status.addEventListener("change", (item) =>{
        statusOrders += item.target.value +"" ;
    })
}

const button_update = document.getElementById("update-order");
if(button_update){
    button_update.addEventListener("click", () => {
        const isConfirm = confirm("Bạn có chắc muốn cập nhật trạng thái đơn hàng?");
        const form = document.querySelector("[form-update]");

        if(isConfirm){
            const id = button_update.getAttribute("data-id");
            console.log(id);
            const pathU = form.getAttribute("data-path");
            form.action =`${pathU}/${id}?status=${statusOrders}`;
            form.submit();
        }

    })
}
//End Change-status-orders


const listBtnDeleteRole = document.querySelectorAll("[btn-delete]");


if (listBtnDeleteRole.length > 0) {
  listBtnDeleteRole.forEach((button) => {
    button.addEventListener("click", () => {
      const roleId = button.getAttribute("data-id");
      const title = button.getAttribute("title");

      const isConfirm = confirm("Bạn có chắc chắn muốn xóa nhóm quyền: " + title + "?");

      if (isConfirm) {
        fetch(`admin/roles/delete/${roleId}`, {
          method: "POST", // hoặc "POST" nếu bạn dùng phương thức _method override
          headers: {
            "Content-Type": "application/json"
          }
        })
        .then((res) => res.json())
        .then((data) => {
          if (data.code == 200) {
            alert("Xóa thành công!");
            location.reload();
          } else {
            alert("Xóa thất bại: " + (data.message || "Vui lòng thử lại!"));
          }
        })
        
      }
    });
  });
}

// Table permissions
const buttonSubmitPermissions = document.querySelector("[button-submit-permissions]");

if(buttonSubmitPermissions) {
  buttonSubmitPermissions.addEventListener("click", () => {
    const roles = [];
    const tablePermissions = document.querySelector("[table-permissions]");
    const rows = tablePermissions.querySelectorAll("tbody tr[data-name]");
    
    rows.forEach((row, index) => {
      const dataName = row.getAttribute("data-name");
      const inputs = row.querySelectorAll("input");

      if(dataName == "id") {
        inputs.forEach(input => {
          const id = input.value;
          roles.push({
            id: id,
            permissions: []
          });
        });
      } else {
        inputs.forEach((input, index) => {
          const inputChecked = input.checked;
          if(inputChecked) {
            roles[index].permissions.push(dataName);
          }
        });
      }
    });

    if(roles.length > 0) {
      const formChangePermissions = document.querySelector("[form-change-permissions]");
      const inputRoles = formChangePermissions.querySelector("input[name='roles']");
      inputRoles.value = JSON.stringify(roles);
      formChangePermissions.submit();
    }
  });
}
// End Table Permissions

// Data default Table Permissions
const dataRecords = document.querySelector("[data-records]");
if(dataRecords) {
  const records = JSON.parse(dataRecords.getAttribute("data-records"));
  const tablePermissions = document.querySelector("[table-permissions]");
  console.log(tablePermissions);

  records.forEach((record, index) => {
    const permissions = record.permissions;
    permissions.forEach(permission => {
      const row = tablePermissions.querySelector(`tr[data-name="${permission}"]`);
      const input = row.querySelectorAll(`input`)[index];
      input.checked = true;
    });
  });
}


const listBtnDeleteAcc = document.querySelectorAll("[btn-delete-acc]");
console.log(listBtnDeleteAcc);
if (listBtnDeleteAcc.length > 0) {
  listBtnDeleteAcc.forEach((button) => {
    button.addEventListener("click", () => {
      const roleId = button.getAttribute("data-id");
      const title = button.getAttribute("title");

      const isConfirm = confirm("Bạn có chắc chắn muốn xóa tài khoản của: " + title + "?");

      if (isConfirm) {
        fetch(`admin/accounts/delete/${roleId}`, {
          method: "POST", // hoặc "POST" nếu bạn dùng phương thức _method override
          headers: {
            "Content-Type": "application/json"
          }
        })
        .then((res) => res.json())
        .then((data) => {
          if (data.code == 200) {
            alert("Xóa thành công!");
            location.reload();
          } else {
            alert("Xóa thất bại: " + (data.message || "Vui lòng thử lại!"));
          }
        })
        
      }
    });
  });
}


let timeLeft = 60; // giây
  const timerDisplay = document.getElementById("timer");
  const countdownBox = document.getElementById("countdown-box");

  const interval = setInterval(() => {
    const minutes = String(Math.floor(timeLeft / 60)).padStart(2, "0");
    const seconds = String(timeLeft % 60).padStart(2, "0");
    timerDisplay.textContent = `${minutes}:${seconds}`;

    if (timeLeft <= 0) {
      clearInterval(interval);
      timerDisplay.textContent = "00:00";
      countdownBox.classList.remove("alert-warning");
      countdownBox.classList.add("alert-danger");
      countdownBox.innerHTML = "⛔ Mã OTP đã hết hạn. Vui lòng yêu cầu lại.";
    }

    timeLeft--;
  }, 1000);




