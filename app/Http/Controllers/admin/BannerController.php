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
        if ($request->isMethod('POST')) {
            $params = $request->except('_token');
            $Ban = Banner::query()->create($params);
            $banID = $Ban->id;

            //sử lí thêm album
            if ($request->hasFile('file_name')) {
                foreach ($request->file('file_name') as $image) {
                    if ($image) {
                        $path = $image->store('uploads/imageBanner/id_' . $banID, 'public');
                        $Ban->banner_images()->create([
                            'ban_id' => $banID,
                            'file_name' => $path,
                        ]);
                    }
                }
            }

            return redirect()->route('admin.banner.index')->with('success', 'Thêm thành công');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
       
    }

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
    public function update(Request $request, string $id)
    {
        if ($request->isMethod('PUT')) {

            $params = $request->except('_token', '_method');

            $Ban = Banner::query()->findOrFail($id);

            // if ($request->hasFile('file_name')) {

            // Lấy các ID của ảnh hiện tại từ DB
            $currentImages = $Ban->banner_images->pluck('id')->toArray();
            // dd($currentImages);
            $arrayCombine = array_combine($currentImages, $currentImages);

            // Trường hợp xóa ảnh - duyệt lại toàn bộ các ảnh hiện tại để kiểm tra
            foreach ($arrayCombine as $key => $value) {
                // dd($value);
                // die;
                // Kiểm tra xem ảnh có trong request không, nếu không có tức là đã bị xóa
                if (!array_key_exists($key, $request->file_name)) {
                    $banner_images = Banner_image::query()->find($key);

                    // Nếu ảnh tồn tại thì xóa cả file và record trong DB
                    if ($banner_images && Storage::disk('public')->exists($banner_images->file_name)) {
                        Storage::disk('public')->delete($banner_images->file_name);
                        $banner_images->delete();
                    }
                }
            }

            // Xử lý các ảnh mới hoặc cập nhật
            foreach ($request->file_name as $key => $image) {
                if (!array_key_exists($key, $arrayCombine)) {
                    // Ảnh mới
                    if ($request->hasFile("file_name.$key")) {
                        $path = $image->store('uploads/imageBanner/id_' . $id, 'public');
                        $Ban->banner_images()->create([
                            'ban_id' => $id,
                            'file_name' => $path,
                        ]);
                    }
                } else if (is_file($image) && $request->hasFile("file_name.$key")) {
                    // Cập nhật ảnh hiện có
                    $banner_images = Banner_image::query()->find($key);

                    // Nếu ảnh đã có và tồn tại trong storage, thì xóa file cũ
                    if ($banner_images && Storage::disk('public')->exists($banner_images->file_name)) {
                        Storage::disk('public')->delete($banner_images->file_name);
                    }
                    // Lưu file ảnh mới
                    $path = $image->store('uploads/imageBanner/id_' . $id, 'public');
                    $banner_images->update([
                        'file_name' => $path,
                    ]);
                }
            }
            // }

            // Cập nhật các thông tin khác của banner
            $Ban->update($params);

            return redirect()->route('admin.banner.index')->with('success', 'Cập nhật thành công!');
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
        $path = 'uploads/imageBanner/id_' . $id;
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->deleteDirectory($path);
        }

        // Xóa sản phẩm
        $Ban->delete();

        return redirect()->route('admin.banner.index')->with('success', 'Xóa thành công!');
    }


    public function onActive($id)
    {

        Banner::where('id',$id)->update(['is_active'=>1]);


        return redirect()->route('admin.banner.index')->with('success', 'Banner đã được bật.');
    }

    public function offActive($id)
    {

       Banner::where('id',$id)->update(['is_active'=>0]);

        return redirect()->route('admin.banner.index')->with('success', 'Banner đã được tắt.');
    }
}
