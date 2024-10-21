<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staffs = User::where('role', 'staff')->paginate(10);
        return view('admin.staff.index', compact('staffs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.staff.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'full_name' => 'required|string|max:255',
                'username' => 'required|string|unique:users,username|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|regex:/^0\d{9,10}$/',
                'address' => 'nullable',
                'password' => 'required|string|min:6|confirmed',
            ],
            [
                'phone.regex' => 'Phone numbers start at 0 and have 10 or 11 digits'
            ]
        );

        User::create([
            'full_name' => $request->full_name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => bcrypt($request->password),
            'role' => 'staff',
        ]);

        return redirect()->route('admin.staffs.index')->with('statusSuccess', 'Thêm nhân viên thành công.');
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
        $staff = User::findOrFail($id);
        return view('admin.staff.edit', compact('staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $staff = User::findOrFail($id);
        $request->validate(
            [
                'full_name' => 'required|string|max:255',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users', 'email')->ignore($staff->id),
                ],
                'phone' => 'required|regex:/^0\d{9,10}$/',
                'address' => 'nullable',
            ],
            [
                'phone.regex' => 'Phone numbers start at 0 and have 10 or 11 digits'
            ]
        );

        $staff->update([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address
        ]);

        return redirect()->route('admin.staffs.index')->with('statusSuccess', 'Cập nhật nhân viên thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.staffs.index')->with('statusSuccess', 'Xóa nhân viên thành công.');
    }
}
