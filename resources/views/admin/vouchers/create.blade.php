<!-- Modal thêm sản phẩm -->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Danh sách sản phẩm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    @csrf
            
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên Voucher</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
            
                    <div class="mb-3">
                        <label for="code" class="form-label">Mã Voucher</label>
                        <input type="text" class="form-control" name="code" id="code" required>
                    </div>
            
                    <div class="mb-3">
                        <label for="amount" class="form-label">Giá Trị Giảm</label>
                        <input type="number" class="form-control" name="amount" id="amount" required>
                    </div>
            
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Số Lượng</label>
                        <input type="number" class="form-control" name="quantity" id="quantity" required>
                    </div>
            
                    <div class="mb-3">
                        <label for="image" class="form-label">Ảnh Voucher</label>
                        <input type="file" class="form-control" name="image" id="image">
                    </div>
            
                    <div class="mb-3">
                        <label for="type" class="form-label">Loại Voucher</label>
                        <select class="form-select" name="type" id="type" required>
                            <option value="fixed">Cố định</option>
                            <option value="percent">Phần trăm</option>
                            <option value="free_ship">Miễn phí vận chuyển</option>
                        </select>
                    </div>
            
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Ngày Bắt Đầu</label>
                        <input type="date" class="form-control" name="start_date" id="start_date">
                    </div>
            
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Ngày Hết Hạn</label>
                        <input type="date" class="form-control" name="end_date" id="end_date">
                    </div>
            
                    <div class="mb-3">
                        <label for="minimum_order_value" class="form-label">Giá Tối Thiểu Đơn Hàng</label>
                        <input type="number" class="form-control" name="minimum_order_value" id="minimum_order_value">
                    </div>
            
                    <div class="mb-3">
                        <label for="is_active" class="form-label">Kích Hoạt</label>
                        <input type="checkbox" name="is_active" id="is_active" checked>
                    </div>
            
                    <button type="submit" class="btn btn-primary">Thêm Voucher</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
            </div>
        </div>
    </div>
</div>
