<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //user dashboard
    public function homepage()
    {
        $products = Product::select('products.*', 'categories.id as category_id', 'categories.name as category_name')
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->get();
        $categories = Category::all();
        return view('user.home.userHomePage', compact('products', 'categories'));
    }

    public function category(Request $request)
    {
        $search     = $request->input('search');
        $categoryId = $request->input('category_id');
        //price range
        $min = $request->input('min_price') !== null ? (int)$request->input('min_price') : null;
        $max = $request->input('max_price') !== null ? (int)$request->input('max_price') : null;
        //sorting with dropdown
        $sort = $request->input('sort');

        // dd($request->toArray());
        $products = Product::select('products.*', 'categories.id as category_id', 'categories.name as category_name')
                            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
                            ->when($search, function ($query) use ($search) {
                                $query->where(function($query) use ($search){
                                    $query->where('products.name', 'like', "%{$search}%")
                                    ->orWhere('products.description', 'like', "%{$search}%");
                                });
                            })
                            ->when($categoryId, function ($query) use ($categoryId) {
                                    $query->where('products.category_id', $categoryId);
                            })
                            ->when($min !== null || $max !== null, function ($query) use ($min, $max) {
                                if ($min && $max) {
                                    $query->whereBetween('products.sale_price', [$min, $max]);
                                } elseif ($min) {
                                    $query->where('products.sale_price', '>=', $min);
                                } elseif ($max) {
                                    $query->where('products.sale_price', '<=', $max);
                                }
                            })
                            ->when($sort, function($query) use ($sort){
                                if($sort == 'lowest_price'){
                                    $query->orderBy('sale_price', 'asc');
                                }elseif ($sort == 'highest_price') {
                                    $query->orderBy('sale_price', 'desc');
                                }elseif($sort == 'top_rated'){
                                     $query->orderBy('rating', 'desc');
                                }elseif($sort == 'most_recent'){
                                    $query->orderBy('updated_at','desc');
                                }

                            })
                            ->paginate(9);
        $categoryName = null;
        if ($categoryId) {
            $category     = Category::find($categoryId);
            $categoryName = $category ? $category->name : null;
        }
        $productCount = $products->count();

        $categories = Category::all();

        return view('user.home.category', compact('products','categoryName','productCount','categories'));
    }
}
