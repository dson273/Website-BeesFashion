@extends('admin.layouts.master')

@section('title')
Tạo mới sản phẩm
@endsection

@section('style-libs')
<link rel="stylesheet" href="{{asset('css/admin/product/create.css')}}">
@endsection

@section('script-libs')
<script src="{{asset('js/admin/product/create.js')}}"></script>
@endsection

@section('content')
<div class="mb-2 ml-3">
    <a href="{{route('admin.products.index')}}" class="btn btn-dark text-white text-decoration-none"><i class="fas fa-arrow-left"></i> Quay lại</a>
</div>
<div class="card shadow mb-4">
    <h1 class="h2 mt-3 text-center text-gray-800 fw-bold">Create new product</h1>
    <div class="card-body">
        <form id="uploadForm" action="{{route('admin.products.store')}}" method="POST" enctype="multipart/form-data">
            <div class="mt-1 d-flex justify-content-end">
                <button type="submit" class="btn btn-success" type="submit">Publish</button>
            </div>
            @csrf
            <div class="mt-3 shadow mb-3 bg-body-tertiary rounded">
                <div class="w-100 border-bottom p-2 d-flex justify-content-between align-items-center cspt no-select hoverTextBlack" id="baseProductSwitch">
                    <span class="font-weight-bold">Base product</span>
                    <i class="fas fa-chevron-up fa-xl" id="chevronBaseProduct"></i>
                </div>
                <div class="d-flex flex-row mt-2 p-3" id="baseProduct" data-baseProduct="show">
                    <div class="w-50">
                        <div class="mb-3">
                            <label for="" class="form-label">SKU</label>
                            <input type="text" name="sku" class="form-control">
                        </div>
                        <div class="mt-3 mb-3">
                            <label for="" class="form-label">Product name</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="mt-3 mb-3">
                            <label for="" class="form-label">Description</label>
                            <textarea name="description" id="" cols="40" rows="4" class="form-control"></textarea>
                        </div>
                        <div class="mt-3 mb-3">
                            <label for="" class="form-label">Status</label>
                            <input type="checkbox" name="is_active" class="form-input" checked>
                        </div>
                    </div>
                    <div class="ml-3 w-50 d-flex flex-column">
                        <div>
                            <div class="d-flex justify-content-between">
                                <label for="" class="form-label no-select">Images</label>
                                <span class="text-dange" id="removeAllImagesBtn">Remove all</span>
                            </div>
                            <div class="row row-cols-5" id="imagePreview">
                                <div class="col mb-2">
                                    <div class="card d-flex" style="width: 100px; height: 100px; border: 2px dashed #6c757d;">
                                        <div class="form-group text-center">
                                            <label for="imageUpload" class="form-label" style="cursor: pointer;">
                                                <svg width="20" height="20" fill="#6c757d" class="bi bi-cloud-upload mt-2" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M4.406 1.342A5.53 5.53 0 0 1 8 0c1.657 0 3.156.832 4.094 2.122a3.993 3.993 0 0 1 4.902 4.252A4.5 4.5 0 0 1 14.5 16h-13a4.5 4.5 0 0 1-.93-8.906 5.53 5.53 0 0 1 3.836-5.752zM7.5 8.5V12a.5.5 0 0 0 1 0V8.5H11a.5.5 0 0 0 0-1H8.5V5a.5.5 0 0 0-1 0v2.5H5a.5.5 0 0 0 0 1h2.5z" />
                                                </svg>
                                                <div class="mt-2">Click to upload</div>
                                            </label>
                                            <input type="file" class="form-control d-none" id="imageUpload" name="images[]" multiple accept="image/*" onchange="previewImages(this)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between">
                                <label for="" class="form-label no-select">Videos</label>
                                <span class="text-dange" id="removeAllVideosBtn">Remove all</span>
                            </div>
                            <div class="row row-cols-4" id="videoPreview">
                                <div class="col mb-2">
                                    <div class="card d-flex" style="width: 100px; height: 100px; border: 2px dashed #6c757d;">
                                        <div class="form-group text-center">
                                            <label for="videoUpload" class="form-label" style="cursor: pointer;">
                                                <svg width="20" height="20" fill="#6c757d" class="bi bi-cloud-upload mt-2" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M4.406 1.342A5.53 5.53 0 0 1 8 0c1.657 0 3.156.832 4.094 2.122a3.993 3.993 0 0 1 4.902 4.252A4.5 4.5 0 0 1 14.5 16h-13a4.5 4.5 0 0 1-.93-8.906 5.53 5.53 0 0 1 3.836-5.752zM7.5 8.5V12a.5.5 0 0 0 1 0V8.5H11a.5.5 0 0 0 0-1H8.5V5a.5.5 0 0 0-1 0v2.5H5a.5.5 0 0 0 0 1h2.5z" />
                                                </svg>
                                                <div class="mt-2">Click to upload</div>
                                            </label>
                                            <input type="file" class="form-control d-none" id="videoUpload" name="videos[]" multiple accept="video/*" onchange="previewVideos(this)">
                                            <video src=""></video>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="shadow mb-3 bg-body-tertiary rounded">
                <div class="w-100 border-bottom p-2 d-flex justify-content-between align-items-center cspt no-select hoverTextBlack" id="baseCustomVariantsSwitch">
                    <span class="font-weight-bold">Custom variants</span>
                    <i class="fas fa-chevron-up fa-xl" id="chevronCustomVariants"></i>
                </div>
                <div class="p-3" id="customVariants" data-customVariants="show">
                    <div class="w-50 mr-2">
                        <li class="text-primary">Attributes</li>
                        <div class="mt-2 border-bottom d-flex flex-row pb-3">
                            <span class="btn btn-primary btn-sm mr-2 white-space">Add new</span>
                            <div class="w-50" id="loadAttributeDatas">
                                <select name="selectAddExisting" id="selectAddExisting" class="w-100">
                                </select>
                            </div>
                        </div>
                        <div>
                            <div class="attributeItem mt-2 border-bottom pb-3">
                                <div class="d-flex justify-content-between cspt border-bottom">
                                    <span>New attribute</span>
                                    <div class="d-flex align-items-center">
                                        <span class="text-danger cspt no-select mr-2" style="font-size:14px" onclick="return confirm('If you remove this attribute, customers will no longer be able to purchase some variations of this product.')">Remove</span>
                                        <i class="fas fa-chevron-up fa-md p-2 hoverTextBlack" id="chevronAttributeItem"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="d-flex flex-row">
                                        <div class="w-25 mr-2">
                                            <label for="" class="small">Name:</label>
                                            <input type="text" class="form-control" name="attributeItem[]" placeholder="f.e. size or color">
                                        </div>
                                        <div class="d-flex flex-column w-75" style="margin-top:3.2px">
                                            <label for="" class="small">Value(s):</label>
                                            <textarea name="" id="" class="form-control" rows="3" placeholder="Enter options for customers to choose from, f.e. “Blue” or “Large”. Use “|” to separate different options."></textarea>
                                            <div class="d-flex flex-row justify-content-between mt-2">
                                                <div class="d-flex flex-row">
                                                    <span class="btn btn-outline-secondary btn-sm">Select all</span>
                                                    <span class="btn btn-outline-secondary btn-sm ml-2">Select none</span>
                                                </div>
                                                <span class="btn btn-outline-secondary btn-sm">Create value</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="btn btn-primary btn-sm">Save attributes</span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection