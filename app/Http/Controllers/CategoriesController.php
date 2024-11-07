<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoriesController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $category = Category::paginate(5);     
        if(isset($request->keyword) && $request->keyword != ''){
            $category = Category::where('category_name','like','%' .$request->keyword.'%')
                                ->orWhere('category_id','like','%' .$request->keyword.'%')
            ->paginate(5);
            
        }


        if ($category->isEmpty()) {
            return redirect()->route('category-list')->with([
                'category' => $category, 
                'error' => 'Không tìm thấy danh mục bạn cần tìm'
            ]);
        } 
        return view('admin.category')->with('category',$category);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.category.create_category');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $category = Category::create([
            'category_name' => $request->input('category_name'),
        ]);
        return redirect()->route('category-list')->with('success', 'Thêm danh mục sản phẩm thành công');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id 
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $category = Category::findOrFail($id);
        // return view('admin.category.show_category',compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit_category',compact('category'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update($request->all());
        return redirect()->route('category-list')->with('success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('category-list');
     
    }
    
}
