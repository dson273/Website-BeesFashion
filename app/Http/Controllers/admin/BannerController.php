<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Banner_image;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::get();
        return view('admin.banner.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'file_name' => 'required|image|mimes:jpeg,png,jpg,gif,svg',

        ], [
            'name.required' => 'Tên banner chưa được nhập.',
            'name.string' => 'Tên banner phải là một chuỗi ký tự.',
            'name.max' => 'Tên banner không được quá 255 ký tự.',


            'file_name.required' => 'Không được để trống ảnh.',
            'file_name.image' => 'Tệp tải lên phải là một hình ảnh.',
            'file_name.mimes' => 'Hình ảnh phải có định dạng jpeg, png, jpg, gif, svg.',
        ]);

        if ($request->isMethod('POST')) {
            $params = $request->except('_token');
            $params['is_active'] = $request->has('is_active') ? 1 : 0;

            $Ban = Banner::create($params);
            $banID = $Ban->id;

            // Xử lý thêm album
            if ($request->hasFile('file_name')) {
                foreach ($request->file('file_name') as $image) {
                    if ($image) {
                        // Tạo tên ảnh duy nhất, giữ lại phần mở rộng của tệp
                        $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
                    
                        // Lưu ảnh vào thư mục với tên duy nhất
                        $image->storeAs('uploads/banners/images/id_' . $banID, $imageName, 'public');
                    
                        // Lưu thông tin ảnh vào bảng banner_images
                        $Ban->banner_images()->create([
                            'ban_id' => $banID,
                            'file_name' => $imageName,
                        ]);
                    }
                }
            }

            return redirect()->route('admin.banner.index')->with('statusSuccess', 'Thêm thành công');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {
        $Ban = Banner::query()->findOrFail($id);
        return view('admin.banner.edit', compact('Ban'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if ($request->isMethod('PUT')) {
            $params = $request->except('_token', '_method');
    
            $Ban = Banner::findOrFail($id);
    
            // Lấy các ID của ảnh hiện tại từ DB
            $currentImages = $Ban->banner_images->pluck('id')->toArray();
            $arrayCombine = array_combine($currentImages, $currentImages);
    
            // Kiểm tra xem có ảnh mới trong yêu cầu không
            $hasNewImages = isset($request->file_name) && is_array($request->file_name) && count($request->file_name) > 0;
    
            // Xử lý xóa ảnh nếu ảnh không còn trong yêu cầu
            foreach ($arrayCombine as $key => $value) {
                if (!array_key_exists($key, $request->file_name)) {
                    $banner_image = Banner_image::find($key);
    
                    // Nếu ảnh tồn tại, xóa file và bản ghi trong DB
                    if ($banner_image && Storage::disk('public')->exists('uploads/banners/images/id_' . $id . '/' . $banner_image->file_name)) {
                        Storage::disk('public')->delete('uploads/banners/images/id_' . $id . '/' . $banner_image->file_name);
                        $banner_image->delete();
                    }
                }
            }
    
            // Nếu không có ảnh mới và người dùng muốn xóa hết ảnh
            if (!$hasNewImages) {
                // Xóa tất cả ảnh nếu không có ảnh mới
                foreach ($currentImages as $imageId) {
                    $banner_image = Banner_image::find($imageId);
                    if ($banner_image && Storage::disk('public')->exists('uploads/banners/images/id_' . $id . '/' . $banner_image->file_name)) {
                        Storage::disk('public')->delete('uploads/banners/images/id_' . $id . '/' . $banner_image->file_name);
                        $banner_image->delete();
                    }
                }
            }
    
            // Xử lý ảnh mới hoặc cập nhật ảnh hiện có
            foreach ($request->file_name as $key => $image) {
                if (!array_key_exists($key, $arrayCombine)) {
                    // Thêm ảnh mới
                    if ($request->hasFile("file_name.$key")) {
                        // Tạo tên ảnh duy nhất để tránh trùng lặp
                        $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
                        $image->storeAs('uploads/banners/images/id_' . $id, $imageName, 'public');
                        $Ban->banner_images()->create([
                            'ban_id' => $id,
                            'file_name' => $imageName,
                        ]);
                    }
                } elseif (is_file($image) && $request->hasFile("file_name.$key")) {
                    $banner_image = Banner_image::find($key);
    
                    // Xóa ảnh cũ nếu tồn tại
                    if ($banner_image && Storage::disk('public')->exists('uploads/banners/images/id_' . $id . '/' . $banner_image->file_name)) {
                        Storage::disk('public')->delete('uploads/banners/images/id_' . $id . '/' . $banner_image->file_name);
                    }
    
                    $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->storeAs('uploads/banners/images/id_' . $id, $imageName, 'public');
                    $banner_image->update([
                        'file_name' => $imageName,
                    ]);
                }
            }
    
            $params['is_active'] = $request->has('is_active') ? 1 : 0;
            $Ban->update($params);
    
            return redirect()->route('admin.banner.index')->with('statusSuccess', 'Cập nhật thành công!');
        }
    }
    
    



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        $Ban = Banner::query()->findOrFail($id);


        // Xóa hình ảnh sản phẩm liên quan
        $Ban->banner_images()->delete();

        // Xóa thư mục chứa hình ảnh sản phẩm nếu tồn tại
        $path = 'uploads/banners/images/id_' . $id;
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->deleteDirectory($path);
        }

        // Xóa sản phẩm
        $Ban->delete();

        return redirect()->route('admin.banner.index')->with('statusSuccess', 'Xóa thành công!');
    }


    public function onActive($id)
    {

        Banner::where('is_active', 1)->update(['is_active' => 0]);

        // Bật banner được chọn
        $banner = Banner::find($id);
        $banner->is_active = 1;
        $banner->save();


        return redirect()->route('admin.banner.index')->with('statusSuccess', 'Banner đã được bật');
    }

    public function offActive($id)
    {

        $activeBanner = Banner::where('is_active', 1)->count();

        // Nếu chỉ còn một banner đang bật và nó là banner cần tắt
        if ($activeBanner <= 1) {
            return redirect()->route('admin.banner.index')->with('statusError', 'Phải có ít nhất một banner đang bật');
        }
        // Tắt banner được chọn
        $banner = Banner::find($id);
        $banner->is_active = 0;
        $banner->save();

        return redirect()->route('admin.banner.index')->with('statusSuccess', 'Banner đã được tắt');
    }
}
