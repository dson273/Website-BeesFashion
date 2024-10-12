function previewImages(input) {
    const previewContainer = document.getElementById('imagePreview');

    if (input.files) {
        Array.from(input.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function (e) {
                // Tạo một thẻ img mới
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'rounded p-2 col';
                img.style.width = '100px';
                img.style.height = '100px';
                img.style.objectFit = 'cover';

                // Thêm ảnh vào container
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    }
}