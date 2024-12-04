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
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    </div>
                    <div class="mt-3 mb-3">
                        <label for="" class="form-label">Ảnh</label>
                        <input type="file" name="image" class="form-control" value="{{ old('image') }}">
                        @error('image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    </div>
                    <div class="mt-3 mb-3">
                        <label for="" class="form-label">Mô tả</label>
                        <textarea name="description" id="" cols="40" rows="4" class="form-control" value="{{ old('description') }}"></textarea>
                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    </div>
                    <div class="mt-3 mb-3">
                        <label for="" class="form-label">Thuộc danh mục</label>
                        <select name="parent_category_id" class="form-control">
                            <option value="" selected>Danh mục cha</option>
                            {!! $htmlOption !!}
                        </select>
                    </div>
                    <div class="mt-3 mb-3">
                        <label for="" class="form-label">Trạng thái</label>
                        <input type="checkbox" name="is_active" id="is_active" value="1"
                        {{ old('is_active') ? 'checked' : '' }} checked>
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
@if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $('#exampleModalCenter').modal('show');
        });
    </script>
@endif