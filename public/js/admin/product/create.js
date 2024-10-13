let imageNames = [];

//Xử lý xem trước ảnh sau khi chọn ảnh
function previewImages(input) {
    const previewContainer = document.getElementById('imagePreview');
    // console.log(imageNames);
    console.log(input.files);

    if (input.files) {
        Array.from(input.files).forEach(file => {
            if (!imageNames.includes(file.name)) {
                imageNames.push(file.name);
                const reader = new FileReader();
                reader.onload = function (e) {
                    //Tạo một khối mới để bọc img
                    const divBlock = document.createElement('div');
                    divBlock.className = 'position-relative divImg d-flex justify-content-center';
                    // Tạo một thẻ img mới
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'rounded p-1 col img ml-2 mb-2';
                    img.style.width = '100px';
                    img.style.height = '100px';
                    img.style.objectFit = 'cover';
                    img.setAttribute('data-filename', file.name);
                    //Tạo một nút xóa
                    const removeImgBtn = document.createElement('i');
                    removeImgBtn.className = 'position-absolute fas fa-trash text-danger cs-pt';
                    removeImgBtn.style.cursor = 'pointer';
                    removeImgBtn.style.right = '-2px';
                    removeImgBtn.style.top = '-5px';
                    removeImgBtn.id = 'removeImgBtn';
                    //Thêm ảnh và nút xóa vào khối
                    divBlock.appendChild(img);
                    divBlock.appendChild(removeImgBtn);
                    // Thêm ảnh vào container
                    previewContainer.appendChild(divBlock);
                }
                reader.readAsDataURL(file);
                notification('success', 'Image uploaded successfully', 'Thành công');
            } else {
                notification('warning', 'Image already exists', 'Cảnh báo');
            };
        });
        // Reset lại giá trị của thẻ input sau khi xử lý
        input.value = '';
    }
    //Kiểm tra nếu có ảnh được tải lên thì hiển thị nút xóa tất cả
    if (imageNames.length != 0) {
        const removeAllBtn = document.getElementById('removeAllBtn');
        removeAllBtn.style.display = 'block';
    }
}
//Xử lý xóa ảnh đơn (từng cái một)
$(document).on('click', '#removeImgBtn', function () {
    const imgElm = $(this).closest('.divImg').find('.img');
    const srcImgRemove = imgElm.data('filename');
    imageNames = imageNames.filter(function (item) {
        return item != srcImgRemove;
    })
    if (imageNames.length == 0) {
        const removeAllBtn = document.getElementById('removeAllBtn');
        removeAllBtn.style.display = 'none';
    }
    imgElm.closest('.divImg').remove();
    notification('success', 'Image removed successfully', 'Thành công');
})

//Xử lý xóa tất cả ảnh
$(document).on('click', '#removeAllBtn', function () {
    $('#imagePreview').find('.divImg').remove();
    imageNames = [];
    const removeAllBtn = document.getElementById('removeAllBtn');
    removeAllBtn.style.display = 'none';
})