<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use App\Components\Recusive;

class CategoryController extends Controller
{
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listCategory = Category::whereNull('parent_category_id')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.categories.index', compact('listCategory'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $htmlOption = $this->getCategory($parentId = '');
        return view('admin.categories.create', compact('htmlOption'));
    }

    public function getCategory($parentId)
    {
        $data = $this->category->all();
        $recusive = new Recusive($data);
        $htmlOption = $recusive->categoryRecursive($parentId);

        return $htmlOption;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'required|string',
        ], [
            'name.required' => 'Tên danh mục chưa được nhập.',
            'name.string' => 'Tên danh mục phải là một chuỗi ký tự.',
            'name.max' => 'Tên danh mục không được quá 255 ký tự.',

            'image.required' => 'Không được để trống ảnh.',
            'image.image' => 'Tệp tải lên phải là một hình ảnh.',
            'image.mimes' => 'Hình ảnh phải có định dạng jpeg, png, jpg, gif, svg.',

            'description.required' => 'Mô tả danh mục chưa được nhập.',
            'description.string' => 'Mô tả phải là một chuỗi ký tự.',
        ]);
        if ($request->isMethod('POST')) {
            $params = $request->except('_token');

            // Kiểm tra và xử lý ảnh nếu có
            if ($request->hasFile('image')) {
                // Lấy tên ảnh và tạo tên mới duy nhất
                $image = $request->file('image');
                $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
                // Lưu ảnh vào thư mục 'uploads/categories/images'
                $image->storeAs('uploads/categories/images', $imageName, 'public');
                // Lưu chỉ tên ảnh vào params
                $params['image'] = $imageName;
            } else {
                $params['image'] = null;  // Trường hợp không có ảnh
            }

            $params['is_active'] = $request->has('is_active') ? 1 : 0;

            // Tạo danh mục mới
            Category::create($params);

            return redirect()->route('admin.categories.index')->with('statusSuccess', 'Thêm danh mục thành công');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        $cate_parent = Category::where('is_active', 1)->get();
        $parentCategory = Category::findOrFail($id);
        $htmlOption = $this->getCategory($parentId = '');
        // Lấy tất cả danh mục con có parent_category_id bằng ID của danh mục cha
        $childCategories = $this->getAllChildCategories($parentCategory->id);
        return view('admin.categories.detail', compact('parentCategory', 'childCategories', 'cate_parent', 'htmlOption'));
    }


    private function getAllChildCategories($parentId)
    {
        // Lấy danh sách các danh mục con trực tiếp
        $childCategories = Category::where('parent_category_id', $parentId)->get();

        // Biến lưu trữ tất cả các danh mục con
        $allCategories = collect($childCategories);

        // Duyệt qua từng danh mục con và lấy thêm các danh mục cháu của nó
        foreach ($childCategories as $child) {
            $allCategories = $allCategories->merge($this->getAllChildCategories($child->id));
        }

        return $allCategories;
    }
    /**
     * Show the form for editing the specified resource.
     */


    public function edit(string $id)
    {
        // $cate_parent = Category::where('is_active', 1)->get();
        // $sub_parent = Category::where('parent_category_id', $id)->pluck('id')->toArray();
        $Cate = $this->category->find($id);
        $htmlOption = $this->getCategory($Cate->parent_category_id);

        return view('admin.categories.edit', compact('htmlOption', 'Cate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($request->isMethod('PUT')) {
            $params = $request->except('_token', '_method');
            $Cate = Category::findOrFail($id);

            // Kiểm tra xem danh mục hiện tại có phải là danh mục cha không
            if ($Cate->parent_category_id === null) {
                // Lấy danh mục con hiện tại của danh mục cha (nếu có)
                $childCategories = Category::where('parent_category_id', $Cate->id)->pluck('id')->toArray();

                // Nếu danh mục cha đang được sửa chọn chính nó là con
                if (in_array($request->parent_category_id, $childCategories)) {
                    return redirect()->back()->with('statusError', 'Bạn không thể chọn danh mục con của danh mục cha này.');
                }
            }

            // Xử lý ảnh nếu có
            if ($request->hasFile('image')) {
                // Nếu có ảnh cũ và ảnh mới được tải lên, xóa ảnh cũ
                if ($Cate->image && Storage::disk('public')->exists('uploads/categories/images/' . $Cate->image)) {
                    Storage::disk('public')->delete('uploads/categories/images/' . $Cate->image);
                }

                // Tạo tên ảnh duy nhất
                $image = $request->file('image');
                $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('uploads/categories/images', $imageName, 'public');

                // Lưu tên ảnh mới
                $params['image'] = $imageName;
            } else {
                // Nếu không có ảnh mới, giữ ảnh cũ
                $params['image'] = $Cate->image;
            }

            // Cập nhật trạng thái hoạt động
            $params['is_active'] = $request->has('is_active') ? 1 : 0;

            // Cập nhật thông tin danh mục
            $Cate->update($params);

            return redirect()->route('admin.categories.index')->with('statusSuccess', 'Cập nhật danh mục thành công');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Cate = Category::findOrFail($id);

        $childCategories = Category::where('parent_category_id', $Cate->id)->count();
        if ($childCategories > 0) {
            return redirect()->route('admin.categories.index')->with('statusError', 'Không thể xóa danh mục vì có danh mục con.');
        }

        if ($Cate->image && Storage::disk('public')->exists($Cate->image)) {
            Storage::disk('public')->delete($Cate->image);
        }

        $Cate->delete();

        return redirect()->route('admin.categories.index')->with('statusSuccess', 'Xóa danh mục thành công!');
    }

    public function product()
    {
        // Lấy danh mục bán chạy
        $bestSellingCategory = Category::where('fixed', 0)->first();
        // Lấy tất cả sản phẩm thuộc danh mục bán chạy
        $bestSellingProducts = $bestSellingCategory ? $bestSellingCategory->products : [];

        // Lấy tất cả sản phẩm
        $allProducts = Product::where('is_active', 1)->get();

        $bestSellingProductIds = $bestSellingProducts->pluck('id')->toArray();
        return view('admin.categories.topproduct', compact('allProducts', 'bestSellingCategory', 'bestSellingProducts', 'bestSellingProductIds'));
    }

    public function updateBestSelling(Request $request)
    {
        $bestSellingCategory = Category::where('fixed', 0)->first();

        // Kiểm tra nếu có danh mục bán chạy và có sản phẩm được chọn
        if ($bestSellingCategory && $request->has('product_ids')) {
            // Lấy danh sách ID sản phẩm được chọn
            $productIds = $request->input('product_ids');

            // Gắn các sản phẩm vào danh mục bán chạy
            // Tạo mảng dữ liệu cho việc chèn
            $Data = [];
            foreach ($productIds as $productId) {
                $Data[] = [
                    'product_id' => $productId,
                    'category_id' => $bestSellingCategory->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Chèn dữ liệu vào bảng trung gian
            $bestSellingCategory->product_categories()->insert($Data);

            return back()->with('statusSuccess', 'Sản phẩm đã được thêm vào danh mục bán chạy.');
        }

        return back()->with('statusError', 'Không có sản phẩm nào được chọn.');
    }

    public function remove($id)
    {
        $product = Product::find($id);

        if ($product) {
            // Gỡ sản phẩm khỏi danh mục bán chạy
            $product->categories()->detach(); // Gỡ tất cả danh mục liên quan

            return back()->with('statusSuccess', 'Sản phẩm đã được gỡ khỏi danh mục bán chạy.');
        }

        return back()->with('statusError', 'Không tìm thấy danh mục bán chạy.');
    }
    public function fake_sales(Request $request, $id)
    {

        $validated = $request->validate([
            'fake_sales' => 'required|integer|min:1',
        ]);

        try {
            $newFakeSales = $validated['fake_sales']; // Lấy số lượng nhập từ request

            $product = Product::findOrFail($id);

            $product->update([
                'fake_sales' => $newFakeSales,
            ]);

            // Trả về thông báo thành công
            return redirect()->back()->with('statusSuccess', 'Số lượng ảo đã được cập nhật!');
        } catch (\Exception $e) {
            // Nếu có lỗi, trả về thông báo lỗi
            return redirect()->back()->with('statusError', 'Có lỗi xảy ra, vui lòng thử lại!');
        }
    }
}
