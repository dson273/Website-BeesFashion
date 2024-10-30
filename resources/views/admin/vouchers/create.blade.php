<!-- Modal thêm sản phẩm -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thêm Voucher</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.vouchers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">


                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Tên Voucher</label>
                            <input type="text" class="form-control form-control-sm" name="name" id="name"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label for="code" class="form-label">Mã Voucher</label>
                            <input type="text" class="form-control form-control-sm" name="code" id="code"
                                required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="amount" class="form-label">Giá Trị Giảm</label>
                            <input type="number" class="form-control form-control-sm" name="amount" id="amount"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label for="quantity" class="form-label">Số Lượng</label>
                            <input type="number" class="form-control form-control-sm" name="quantity" id="quantity"
                                required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Ảnh Voucher</label>
                        <input type="file" class="form-control form-control-sm" name="image" id="image">
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="type" class="form-label">Loại Voucher</label>
                            <select class="form-control form-control-sm" name="type" id="type" required>
                                <option value="fixed">Cố định</option>
                                <option value="percent">Phần trăm</option>
                                <option value="free_ship">Miễn phí vận chuyển</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="start_date" class="form-label">Ngày Bắt Đầu</label>
                            <input type="date" class="form-control form-control-sm" name="start_date"
                                id="start_date">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="end_date" class="form-label">Ngày Hết Hạn</label>
                            <input type="date" class="form-control form-control-sm" name="end_date" id="end_date">
                        </div>
                        <div class="col-md-6">
                            <label for="minimum_order_value" class="form-label">Giá Tối Thiểu Đơn Hàng</label>
                            <input type="number" class="form-control form-control-sm" name="minimum_order_value"
                                id="minimum_order_value">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="is_active" class="form-label">Kích Hoạt</label>
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active') ? 'checked' : '' }} checked>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Thêm Voucher</button>
                </div>
            </form>
        </div>
    </div>
</div>
