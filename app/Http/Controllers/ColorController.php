<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;

class ColorController extends Controller
{
    public function index()
    {
        $perPage = 7;
        $colordm = Color::paginate($perPage);

        return view('admin.colors.index', compact('colordm'));
    }

    public function create()
    {
        return view('admin.colors.create_colors');
    }

    public function AddNewcolors(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|regex:/^[a-zA-Z0-9\s]+$/|min:3|max:30',
            'images' => 'nullable|mimes:jpg,jpeg,png,gif|dimensions:min_width=100,min_height=100|max:5120',
        ]);

        $color = new Color();
        $color->name = $validatedData['name'];

        if ($request->hasFile('images')) {
            $image = $request->file('images');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/colors'), $imageName);
            $color->images = 'uploads/colors/' . $imageName;
        }

        $color->save();

        return redirect()->route('colors-list')->with('success', 'Màu được thêm thành công!');
    }

    public function edit($id)
    {
        $color = Color::findOrFail($id);
        return view('admin.colors.update_colors', compact('color'));
    }
 

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|regex:/^[a-zA-Z0-9\s]+$/|min:3|max:30',
            'images' => 'nullable|mimes:jpg,jpeg,png,gif|dimensions:min_width=100,min_height=100|max:5120',
        ]);

        $color = Color::findOrFail($id);
        $color->name = $validatedData['name'];

        if ($request->hasFile('images')) {
            $image = $request->file('images');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/colors'), $imageName);
            $color->images = 'uploads/colors/' . $imageName;
        }

        $color->save();

        return redirect()->route('colors-list')->with('success', 'Màu được cập nhật thành công!');
    }

    public function destroy($id)
    {
        $color = Color::findOrFail($id);
        $color->delete();

        return redirect()->route('admin_colors.index')->with('success', 'Màu đã được xóa thành công!');
    }
}
