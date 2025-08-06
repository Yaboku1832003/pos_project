<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    //return route to page
    //compact carries data for "dropDown Categories"
    public function categoryList(){
        $categories = Category::select('id','name')->get();

        return view('admin.product.productCreate',compact('categories'));
    }

    //create product
    public function create(Request $request){
        $this->validationCheck($request,'create');
        $data = $this->getData($request);

        if ($request->hasFile('image')) {
            // get tmp name to save image
            $fileName = uniqid().$request->file('image')->getClientOriginalName();
            // save image in public-productImage file
            $request->file('image')->move (public_path().'/productImage/', $fileName);
            // put $fileName in $data before put into db
            $data['image'] = $fileName;
        }

        Product::create($data);
        Alert::success('Success Title', 'Created Product Successfully');
        return bacK();
    }


    //get product data to use in create product "upper function")
    public function getData($request){
        return [
            'name'=> $request->name,
            'cost_price'=> $request->cost_price,
            'sale_price'=> $request->sale_price,
            'description'=> $request->description,
            'category_id'=> $request->categoryId,
            'stock'=> $request->stock,
        ];
    }

    //delete product
public function delete($id){
    Product::where('id',$id)->delete();
    return back();
}

    //edit product
public function edit(){

}

    //return route to product list page
    //compact carries data to list in that page
    public function list($action = null){
        //action = null is necessary for dynamic//
        $products = Product::select('products.id','products.name','products.image','products.cost_price',
                                    'products.sale_price','products.stock','products.category_id',
                                    'categories.name as category_name')
                            ->leftJoin('categories','products.category_id','categories.id')
                            //this query works only when $action is lowAmt
                            ->when($action == 'lowAmt', function($upperTwoQuery){
                                $upperTwoQuery->where('products.stock','<=',3);
                            })
                            ->when(request('searchKey'), function($upperQuery){
                                $upperQuery->whereAny(['products.name','categories.name'],
                                                        'like', '%'.request('searchKey').'%');
                            })
                            ->orderBy('products.created_at','desc')
                            ->paginate(2);
        return view('admin.product.productList', compact('products'));
    }


    //validation check
    private function validationCheck($request,$action){
            $rule = [
                'image' => 'required|file|mimes:png,jpg,jpeg,webp,svg,gif',
                'name' => 'required|unique:products,name|min:2|max:20',
                'categoryId' => 'required',
                'cost_price' => 'required|numeric|min:3',
                'sale_price' => 'required|numeric|min:3',
                'stock' => 'required|numeric|min:1',
                'description' => 'required|max:2000'
            ];

            $message =[];

            $request->validate($rule,$message);
    }
}
