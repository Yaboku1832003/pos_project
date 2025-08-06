<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    //category list page
    public function list(){
        //fetch catagories and display
        $categories = Category::orderBy('created_at','desc')->paginate(5);
        return view('admin.category.list',compact('categories'));
    }


    //create category
    public function create(Request $request){
        $this->checkValidation($request);

        Category::create([
            'name' => $request->categoryName
        ]);
        Alert::success('Success Title', 'Created Category Successfully');

        return back();
    }

    //category delete
    public function delete($id){
        Category::where('id',$id)->delete();
        return back();
    }

    //category edit
    public function edit($id){
        $editCategory = Category::where('id',$id)->first();
        return view('admin.category.edit',compact('editCategory'));
    }

    //category update
    public function update($id, Request $request){
        $request['id'] = $id;
        $this->checkValidation($request);
        // dd($request->categoryName);
        Category::where('id',$id)->update([
            'name' => $request->categoryName
        ]);
        Alert::success('Success Title', 'Created Category Successfully');

        return to_route('category#list');
    }

    //category validation
    private function checkValidation($request){
        $request->validate([
            'categoryName' => 'required|min:2|max:30|unique:categories,name,'.$request->id
        ],[
            'categoryName.required' => 'Need to Fill This Field!',
            'categoryName.unique' => 'This Category Already Exists'
        ]);
    }
}
