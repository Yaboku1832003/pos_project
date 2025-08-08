<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    //return route to page
    //compact carries data for "dropDown Categories"
    public function categoryList()
    {
        $categories = Category::select('id', 'name')->get();

        return view('admin.product.productCreate', compact('categories'));
    }

    //create product
    public function create(Request $request)
    {
        $this->validationCheck($request, 'create');
        $data = $this->getData($request);

        if ($request->hasFile('image')) {

            // get tmp name to save image
            $fileName = uniqid() . $request->file('image')->getClientOriginalName();

            // save image in public-productImage file
            $request->file('image')->move(public_path() . '/productImage/', $fileName);

            // put $fileName in $data before put into db
            $data['image'] = $fileName;
        }

        Product::create($data);
        Alert::success('Success Title', 'Created Product Successfully');
        return bacK();
    }

    //update product
    public function update(Request $request)
    {
        $this->validationCheck($request, 'update');
        $data = $this->getData($request);

        if ($request->hasFile('image')){
            $oldImageName = $request->oldImage;

            if(file_exists(public_path('productImage/'.$oldImageName))){
                unlink(public_path('productImage/'.$oldImageName));
            }
            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path(). '/productImage/', $fileName);
            $data['image'] = $fileName;
        }else{
            $data['image'] = $request->oldImage;
        }

        Product::where('id',$request->productId)->update($data);
        Alert::success('Success Title', 'Created Product Successfully');
        return to_route('product#list');
    }

    //get product data to use in create product && update product "upper functions")
    public function getData($request)
    {
        return [
            'name'        => $request->name,
            'cost_price'  => $request->cost_price,
            'sale_price'  => $request->sale_price,
            'description' => $request->description,
            'category_id' => $request->categoryId,
            'stock'       => $request->stock,
        ];
    }

    //return route to product list page
    //compact carries data to list in that page
    public function list($action = null)
    {
        //action = null is necessary for dynamic//
        $products = Product::select('products.id', 'products.name', 'products.image', 'products.cost_price',
            'products.sale_price', 'products.stock', 'products.category_id','products.description',
            'categories.name as category_name')
            ->leftJoin('categories', 'products.category_id', 'categories.id')
        //this query works only when $action is lowAmt
            ->when($action == 'lowAmt', function ($upperTwoQuery) {
                $upperTwoQuery->where('products.stock', '<=', 3);
            })
            ->when(request('searchKey'), function ($upperQuery) {
                $upperQuery->whereAny(['products.name', 'categories.name'],
                    'like', '%' . request('searchKey') . '%');
            })
            ->orderBy('products.created_at', 'desc')
            ->paginate(3);
        return view('admin.product.productList', compact('products'));
    }

    //delete product and also delete image
    public function delete($id)
    {
        $product = Product::find($id);

        if ($product) {
            // Check if the product has an image and delete it
            if ($product->image && File::exists(public_path('productImage/' . $product->image))) {
                File::delete(public_path('productImage/' . $product->image));
            }
            $product->delete();
        }
        return back();
    }

    //edit product
    public function edit($id)
    {
        $categories  = Category::get();
        $editProduct = Product::where('id', $id)->first();
        // dd($editProduct);
        return view('admin.product.productEdit', compact('categories', 'editProduct'));
    }



    //validation check
    private function validationCheck($request, $action)
    {
        $rule = [
            'name'        => 'required|min:2|max:20|unique:products,name,'. $request->productId,
            'categoryId'  => 'required',
            'cost_price'  => 'required|numeric|min:3',
            'sale_price'  => 'required|numeric|min:3',
            'stock'       => 'required|numeric|min:1',
            'description' => 'required|max:2000',
        ];

        $rule['image'] = $action == 'create' ? 'required|file|mimes:png,jpg,jpeg,webp,svg,gif' : 'file|mimes:png,jpg,jpeg,webp,svg,gif';

        $message = [];

        $request->validate($rule, $message);
    }
}
