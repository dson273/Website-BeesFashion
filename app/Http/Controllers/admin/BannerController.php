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
            'file_name.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // Thêm các điều kiện hợp lệ hóa khác nếu cần
        ]);

        try {
            if ($request->isMethod('POST')) {
                $params = $request->except('_token');
                $params['is_active'] = $request->has('is_active') ? 1 : 0;

                $Ban = Banner::create($params);
                $banID = $Ban->id;

                // Xử lý thêm album
                if ($request->hasFile('file_name')) {
                    foreach ($request->file('file_name') as $image) {
                        if ($image) {
                            $imageName = $image->getClientOriginalName();
                            $image->storeAs('uploads/banners/images/id_' . $banID, $imageName, 'public');
                            $Ban->banner_images()->create([
                                'ban_id' => $banID,
                                'file_name' => $imageName,
                            ]);
                        }
                    }
                }

                return redirect()->route('admin.banner.index')->with('statusSuccess', 'Thêm thành công');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('statusError', 'Đã xảy ra lỗi khi thêm banner');
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

            // Xử lý ảnh mới hoặc cập nhật ảnh hiện có
            foreach ($request->file_name as $key => $image) {
                if (!array_key_exists($key, $arrayCombine)) {
                    // Thêm ảnh mới
                    if ($request->hasFile("file_name.$key")) {
                        $imageName = $image->getClientOriginalName();
                        $image->storeAs('uploads/banners/images/id_' . $id, $imageName, 'public');
                        $Ban->banner_images()->create([
                            'ban_id' => $id,
                            'file_name' => $imageName,
                        ]);
                    }
                } elseif (is_file($image) && $request->hasFile("file_name.$key")) {
                    // Cập nhật ảnh hiện có
                    $banner_image = Banner_image::find($key);

                    // Xóa ảnh cũ nếu tồn tại
                    if ($banner_image && Storage::disk('public')->exists('uploads/banners/images/id_' . $id . '/' . $banner_image->file_name)) {
                        Storage::disk('public')->delete('uploads/banners/images/id_' . $id . '/' . $banner_image->file_name);
                    }

                    // Lưu ảnh mới với tên gốc
                    $imageName = $image->getClientOriginalName();
                    $image->storeAs('uploads/banners/images/id_' . $id, $imageName, 'public');
                    $banner_image->update([
                        'file_name' => $imageName,
                    ]);
                }
            }

            // Cập nhật các thông tin khác của banner
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
