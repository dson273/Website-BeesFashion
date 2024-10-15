<?php

namespace App\Http\Controllers\admin;

use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Models\AttributeType;
use App\Http\Controllers\Controller;

class AttributeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('admin.attribute_types.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $listAttributeTypes = AttributeType::query()->get();
        return view('admin.attribute_types.create',compact('listAttributeTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    if ($request->isMethod('POST')) {
        $params = $request->except('_token');
        AttributeType::create($params);
        return redirect()->route('admin.attribute_types.create')->with('success', 'Thêm loại thuộc tính thành công');
    }
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
        //
        $listAttributeTypes = AttributeType::query()->get();
        $AttributeTypes = AttributeType::query()->findOrFail($id);
        return view('admin.attribute_types.edit', compact('AttributeTypes','listAttributeTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        if ($request->isMethod('PUT')) {
            $params = $request->except('_token', '_method');
            $AttributeTypes = AttributeType::findOrFail($id);
            $AttributeTypes->update($params);
            return redirect()->route('admin.attribute_types.create')->with('success', 'Thêm loại thuộc tính thành công');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $AttributeTypes = AttributeType::findOrFail($id);

        if ($AttributeTypes) {

            $AttributeTypes->delete();

            return redirect()->route('admin.attribute_types.create')->with('success', 'Xóa loại thuộc tính thành côngs!');
        }
    }
}
