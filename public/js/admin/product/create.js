//---------------------------------------------------Show and hidden form---------------------------------------------------
function switchShowHidden(form, dataForm, chevron) {
    var status = $(form).data(dataForm);

    if (status === "show") {
        $(form).data(dataForm, 'hidden');
        $(form).addClass('hidden');
        $(chevron).removeClass('fa-chevron-up');
        $(chevron).addClass('fa-chevron-down');
    } else {
        $(form).data(dataForm, 'show');
        $(form).removeClass('hidden');
        $(chevron).addClass('fa-chevron-up');
        $(chevron).removeClass('fa-chevron-down');
    }
}
//BASE PRODUCT
$(document).on('click', '#baseProductSwitch', function () {
    switchShowHidden('#baseProduct', 'baseProduct', '#chevronBaseProduct');
});
//CUSTOM VARIANTS
$(document).on('click', '#baseCustomVariantsSwitch', function () {
    switchShowHidden('#customVariants', 'customVariants', '#chevronCustomVariants');
});

//---------------------------------------------------Upload images---------------------------------------------------
let imageNames = [];
let selectedImages = [];
//Xử lý xem trước ảnh sau khi chọn ảnh
function previewImages(input) {
    const previewContainer = document.getElementById('imagePreview');

    const maxSizeMB = 2; // Giới hạn dung lượng tối đa (MB)
    const maxSizeBytes = maxSizeMB * 1024 * 1024; // Chuyển đổi sang byte

    if (input.files) {
        Array.from(input.files).forEach(file => {
            if (file.size > maxSizeBytes) {
                notification('error', `File size exceeds ${maxSizeMB}MB. Please choose a smaller file.`, 'Error');
                input.value = ''; // Reset input nếu ảnh quá lớn
                return;
            }
            if (!imageNames.includes(file.name)) {
                imageNames.push(file.name);
                selectedImages.push(file);
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
                notification('success', 'Image uploaded successfully', 'Successfully');
            } else {
                notification('warning', 'Image already exists', 'Warning');
            };
        });
        // Reset lại giá trị của thẻ input sau khi xử lý
        input.value = '';
    }
    //Kiểm tra nếu có ảnh được tải lên thì hiển thị nút xóa tất cả
    if (imageNames.length != 0) {
        const removeAllImagesBtn = document.getElementById('removeAllImagesBtn');
        removeAllImagesBtn.style.display = 'block';
    }
}
//Xử lý xóa ảnh đơn (từng cái một)
$(document).on('click', '#removeImgBtn', function () {
    //Lấy thẻ img được xóa
    const imgElm = $(this).closest('.divImg').find('.img');
    //Lấy tên file
    const imgSrcRemove = imgElm.data('filename');
    //Xóa tên file khỏi mảng lưu trữ tên file
    imageNames = imageNames.filter(function (item) {
        return item != imgSrcRemove;
    })
    //Xóa đối tượng file trong mảng lưu trữ files
    selectedImages = selectedImages.filter(function (item) {
        return item.name != imgSrcRemove;
    })
    console.log(selectedImages);
    //Nếu mảng rỗng (không còn ảnh nào) thì ẩn nút 'xóa tất cả'
    if (imageNames.length == 0) {
        const removeAllImagesBtn = document.getElementById('removeAllImagesBtn');
        removeAllImagesBtn.style.display = 'none';
    }
    //Xóa thẻ div bao bọc thẻ img được click xóa
    imgElm.closest('.divImg').remove();
    notification('success', 'Image removed successfully', 'Successfully');
})

//Xử lý xóa tất cả ảnh
$(document).on('click', '#removeAllImagesBtn', function () {
    $('#imagePreview').find('.divImg').remove();
    imageNames = [];
    selectedImages = [];
    const removeAllImagesBtn = document.getElementById('removeAllImagesBtn');
    removeAllImagesBtn.style.display = 'none';
})

//---------------------------------------------------Upload videos---------------------------------------------------

let videoNames = [];
let selectedVideos = [];
//Xử lý xem trước video sau khi chọn video
function previewVideos(input) {
    const previewContainer = document.getElementById('videoPreview');

    const maxSizeMB = 50; // Giới hạn dung lượng tối đa (MB)
    const maxSizeBytes = maxSizeMB * 1024 * 1024; // Chuyển đổi sang byte

    if (input.files) {
        Array.from(input.files).forEach(file => {
            if (file.size > maxSizeBytes) {
                notification('error', `File size exceeds ${maxSizeMB}MB. Please choose a smaller file.`, 'Error');
                input.value = ''; // Reset input nếu video quá lớn
                return;
            }

            if (!videoNames.includes(file.name)) {
                videoNames.push(file.name);
                selectedVideos.push(file);
                const reader = new FileReader();
                reader.onload = function (e) {
                    //Tạo một khối mới để bọc video
                    const divBlock = document.createElement('div');
                    divBlock.className = 'position-relative divVideo d-flex justify-content-center';
                    // Tạo một thẻ video mới
                    const video = document.createElement('video');
                    video.src = e.target.result;
                    video.className = 'rounded p-1 col video ml-2 mb-2';
                    video.width = 600;
                    video.style.objectFit = 'cover';
                    video.controls = true;
                    video.setAttribute('data-filename', file.name);
                    //Tạo một nút xóa
                    const removeVideoBtn = document.createElement('i');
                    removeVideoBtn.className = 'position-absolute fas fa-trash text-danger cs-pt';
                    removeVideoBtn.style.cursor = 'pointer';
                    removeVideoBtn.style.right = '-6px';
                    removeVideoBtn.style.top = '-5px';
                    removeVideoBtn.id = 'removeVideoBtn';
                    //Thêm video và nút xóa vào khối
                    divBlock.appendChild(video);
                    divBlock.appendChild(removeVideoBtn);
                    // Thêm video vào container
                    previewContainer.appendChild(divBlock);
                }
                reader.readAsDataURL(file);
                notification('success', 'Video uploaded successfully', 'Successfully');
            } else {
                notification('warning', 'Video already exists', 'Warning');
            };
        });
        // Reset lại giá trị của thẻ input sau khi xử lý
        input.value = '';
    }
    //Kiểm tra nếu có video được tải lên thì hiển thị nút xóa tất cả
    if (videoNames.length != 0) {
        const removeAllVideosBtn = document.getElementById('removeAllVideosBtn');
        removeAllVideosBtn.style.display = 'block';
    }
}
//Xử lý xóa video đơn (từng cái một)
$(document).on('click', '#removeVideoBtn', function () {
    //Lấy thẻ video được xóa
    const videoElm = $(this).closest('.divVideo').find('.video');
    //Lấy tên file
    const videoSrcRemove = videoElm.data('filename');
    //Xóa tên file khỏi mảng lưu trữ tên file
    videoNames = videoNames.filter(function (item) {
        return item != videoSrcRemove;
    })
    //Xóa đối tượng file trong mảng lưu trữ files
    selectedVideos = selectedVideos.filter(function (item) {
        return item.name != videoSrcRemove;
    })
    console.log(selectedVideos);
    //Nếu mảng rỗng (không còn video nào) thì ẩn nút 'xóa tất cả'
    if (videoNames.length == 0) {
        const removeAllVideosBtn = document.getElementById('removeAllVideosBtn');
        removeAllVideosBtn.style.display = 'none';
    }
    //Xóa thẻ div bao bọc thẻ video được click xóa
    videoElm.closest('.divVideo').remove();
    notification('success', 'Video removed successfully', 'Thành công');
})

//Xử lý xóa tất cả video
$(document).on('click', '#removeAllVideosBtn', function () {
    $('#videoPreview').find('.divVideo').remove();
    videoNames = [];
    selectedVideos = [];
    const removeAllVideosBtn = document.getElementById('removeAllVideosBtn');
    removeAllVideosBtn.style.display = 'none';
})


//---------------------------------------------------Variants---------------------------------------------------
//Select attributes form
$(function () {
    new SlimSelect({
        select: '#selectAddExisting',
        settings: {
            placeholderText: 'Add existing',
        }
    })
});
//load Attribute Datas
$('#loadAttributeDatas').click(function () {
    $.ajax({
        url: getAllAttributesRoute,
        method: "POST",
        data: {
            _token: csrf
        },
        success: function (response) {
            console.log(response);
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            notification('error', 'Không thể lấy được dữ liệu thuộc tính!', 'Error');
        }
    })
})

$(document).on('click', '#loadAttributeDatas', function () {
});
//---------------------------------------------------SUBMIT---------------------------------------------------

//Xử lý khi submit form
document.getElementById('uploadForm').addEventListener('submit', function (e) {
    // Ngăn form gửi dữ liệu ngay lập tức
    e.preventDefault();
    // Tạo một đối tượng DataTransfer để lưu trữ các ảnh từ mảng
    const dataTransfer = new DataTransfer();
    // thêm dữ liệu vào đối tượng
    selectedImages.forEach(file => {
        dataTransfer.items.add(file);
    });
    //Lấy thẻ input img rồi truyền dữ liệu vào đó
    const inputImages = document.getElementById('imageUpload');
    inputImages.files = dataTransfer.files;
    //Làm rỗng đối tượng để truyền ảnh vào
    dataTransfer.files = '';
    //truyền dữ liệu từ mảng lưu trữ dữ liệu video được tải lên vào đối tượng
    selectedVideos.forEach(file => {
        dataTransfer.items.add(file);
    });
    //Lấy thẻ input video rồi truyền dữ liệu vào đó
    const inputVideos = document.getElementById('videoUpload');
    inputVideos.files = dataTransfer.files;
    //Submit
    this.submit();
})