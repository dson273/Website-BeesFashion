<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manager_setting;
use Illuminate\Http\Request;

class ManagerSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $managerSettings = Manager_setting::with('children_manager_setting')
            ->whereNull('parent_manager_setting_id')->orderBy('manager_name')->get();
        return view('admin.managerSettings.index', compact('managerSettings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentSettings = Manager_setting::whereNull('parent_manager_setting_id')->get();
        return view('admin.managerSettings.create', compact('parentSettings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'manager_name' => 'required|string|max:255',
            'parent_manager_setting_id' => 'nullable|exists:manager_settings,id'
        ]);

        Manager_setting::create($request->all());
        return redirect()->route('admin.managerSettings.index')->with('statusSuccess', 'Thêm chức năng thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $managerSetting = Manager_setting::findOrFail($id);
        $parentSettings = Manager_setting::whereNull('parent_manager_setting_id')->get();
        return view('admin.managerSettings.edit', compact('managerSetting', 'parentSettings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'manager_name' => 'required|string|max:255',
            'parent_manager_setting_id' => [
                'nullable',
                'exists:manager_settings,id',
                function ($attribute, $value, $fail) use ($id) {
                    if ($value == $id) {
                        session()->flash('statusError', 'Chức năng không thể chọn chính nó làm chức năng cha.');
                        $fail(''); // Ngăn tiếp tục xử lý
                    }
                },
            ],
        ]);

        $managerSetting = Manager_setting::findOrFail($id);
        $managerSetting->update($request->all());
        session()->flash('statusSuccess', 'Sửa chức năng thành công');
        return redirect()->route('admin.managerSettings.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $managerSetting = Manager_setting::findOrFail($id);
        $managerSetting->delete();
        return back()->with('statusSuccess', 'Xoá chức năng thành công');
    }
}
