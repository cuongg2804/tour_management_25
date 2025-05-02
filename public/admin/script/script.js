//Preview image
const uploadImage = document.querySelector("[upload-image]");
if(uploadImage){
    const uploadImg_Input = uploadImage.querySelector("[upload-image-input]");
    uploadImg_Input.addEventListener("change", () => {
        const imgPre = uploadImage.querySelector("[upload-image-preview]");
        imgPre.src = URL.createObjectURL(uploadImg_Input.files[0]);
    })
}