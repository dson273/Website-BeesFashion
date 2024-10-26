<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-3 mb-3">
                        <label for="" class="form-label">Tên danh mục</label>
                        <input type="text" name="name" class="form-control">

                    </div>
                    <div class="mt-3 mb-3">
                        <label for="" class="form-label">Ảnh</label>
                        <input type="file" name="image" class="form-control">

                    </div>
                    <div class="mt-3 mb-3">
                        <label for="" class="form-label">Mô tả</label>
                        <textarea name="description" id="" cols="40" rows="4" class="form-control"></textarea>

                    </div>
                    <div class="mt-3 mb-3">
                        <label for="" class="form-label">Thuộc danh mục</label>
                        <select name="parent_category_id" class="form-control">
                            <option value="" selected>--Danh mục cha--</option>
                            @foreach ($cate_parent as $key => $value)
                                <option value="{{ $value->id }}">
                                    @php
                                        $str = '';
                                        for ($i = 0; $i < $value->level; $i++) {
                                            echo $str;
                                            $str .= '-- ';
                                        }
                                    @endphp
                                    {{ $value->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-3 mb-3">
                        <label for="" class="form-label">Trạng thái</label>
                        <select name="is_active" class="form-control">
                            <option value="1" selected>Hiển Thị</option>
                            <option value="0">Ẩn</option>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Tạo mới</button>
            </div>
            </form>
        </div>
    </div>
</div>
