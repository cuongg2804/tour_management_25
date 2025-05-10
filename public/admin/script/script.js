//Preview image
const uploadImage = document.querySelector("[upload-image]");
if(uploadImage){
    const uploadImg_Input = uploadImage.querySelector("[upload-image-input]");
    uploadImg_Input.addEventListener("change", () => {
        const imgPre = uploadImage.querySelector("[upload-image-preview]");
        imgPre.src = URL.createObjectURL(uploadImg_Input.files[0]);
    })
}



// document.addEventListener('DOMContentLoaded', function () {
    
// });

// document.addEventListener("DOMContentLoaded", function() {
//   const input = document.getElementById("fileInput");
//   const previewContainer = document.querySelector(".custom-file-container__image-preview");

//   input.addEventListener("change", function(event) {
//     const files = event.target.files;
//     previewContainer.innerHTML = ''; // Clear previous previews

//     // Loop through selected files and generate previews
//     Array.from(files).forEach(file => {
//       const reader = new FileReader();

//       reader.onload = function(e) {
//         // Create a new preview item (div) for each image
//         const previewItem = document.createElement("div");
//         previewItem.classList.add("preview-item");

//         // Create an image element
//         const img = document.createElement("img");
//         img.src = e.target.result;

//         // Create the "X" button to delete the image
//         const clearButton = document.createElement("button");
//         clearButton.classList.add("image-clear");
//         clearButton.textContent = "x";

//         // Event listener to remove the image preview when the "X" button is clicked
//         clearButton.addEventListener("click", function() {
//           previewItem.remove(); // Remove the preview item
//         });

//         // Append image and clear button to the preview item
//         previewItem.appendChild(img);
//         previewItem.appendChild(clearButton);

//         // Append the preview item to the preview container
//         previewContainer.appendChild(previewItem);
//       };

//       reader.readAsDataURL(file);
//     });
//   });
// });

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





