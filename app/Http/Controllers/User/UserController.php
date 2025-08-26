<?php
namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\User;
use App\Models\Rating;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    //user dashboard
    public function homepage()
    {
        $products = Product::select('products.id','products.name','products.sale_price','products.description','products.image','products.updated_at',
                     'categories.id as category_id', 'categories.name as category_name')
                    ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
                    ->get();
        $categories = Category::all();

        // Calculate avg rating per product
        foreach ($products as $product) {
            $product->star_count = number_format( Rating::where('product_id', $product->id)->avg('count')); //rating for each product id
            // echo $product->star_count.'<br>';
        }
        // dd($products->toArray());
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
        $products = Product::select('products.id', 'products.name', 'products.description', 'products.sale_price', 'products.image', 'products.updated_at',
                             'categories.id as category_id','categories.name as category_name', DB::raw('AVG(ratings.count) as star_count'))
                            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
                            ->leftJoin('ratings', 'ratings.product_id', '=', 'products.id')
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
                            ->groupBy(
                                'products.id',
                                'products.name',
                                'products.description',
                                'products.sale_price',
                                'products.image',
                                'products.updated_at',
                                'categories.id',
                                'categories.name'
                            )
                            ->when($sort, function($query) use ($sort){
                                if($sort == 'lowest_price'){
                                    $query->orderBy('sale_price', 'asc');
                                }elseif ($sort == 'highest_price') {
                                    $query->orderBy('sale_price', 'desc');
                                }elseif($sort == 'top_rated'){
                                     $query->orderBy('star_count', 'desc');
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

        return view('user.home.category', compact('products','categoryName','productCount'));
    }
// one specific product detail
    public function detail($id){
        $product = Product::select('products.*', 'categories.id as category_id', 'categories.name as category_name')
                            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
                            ->where('products.id',$id)
                            ->first();

        $relatedProducts = Product::select('products.*', 'categories.id as category_id', 'categories.name as category_name')
                                    ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
                                    ->where('category_id', $product->category_id)
                                    ->where('products.id', '!=', $product->id)
                                    ->take(2)
                                    ->get();

        $comments = Comment::select('comments.id as comment_id','comments.comment','comments.created_at',
                                    'users.id as user_id','users.profile','users.name','ratings.count')
                            ->where('comments.product_id',$id)
                            ->leftJoin('users','comments.user_id','users.id')
                            ->leftJoin('ratings', function($join) use ($id) {
                                $join->on('ratings.user_id', '=', 'comments.user_id')
                                    ->where('ratings.product_id', '=', $id);
                                })
                            ->orderBy('created_at','desc')->get();

        $userComment = $comments->where('user_id', Auth::id())
                                ->first();
                                // dd($comments->toArray());
                                // dd($userComment->toArray());

        $rating = number_format(Rating::where('product_id',$id)->avg('count')); //rating for one specific product id

        return view('user.home.productDetail',compact('product','relatedProducts','comments','userComment','rating'));
    }


    public function comment(Request $request){

        $comment=Comment::updateOrCreate([
            'product_id'=>$request->productId,
            'user_id'=>Auth::user()->id
        ],
        [
            'comment'=>$request->review
        ]);

        Rating::updateOrCreate([
            'product_id'=>$request->productId,
            'user_id'=>Auth::user()->id
        ],
        [
            'comment_id'=>$comment->id,
            'count'=>$request->rating
        ]);
        Alert::success('Thank You', 'Your Review has been submitted!');
        return back();
    }

    public function deleteComment(Request $request){
        // dd($request->currentComment);
        // $comment =Comment::select('comments.*')
        //                 ->where('id',$request->currentComment)
        //                 ->first();
        // $rating=Rating::select('ratings.*')
        //                 ->where('comment_id',$comment->id)
        //                 ->first();
        // dd($rating->toArray());
        $comment =  Comment::where('id',$request->currentComment)->first();

                    Rating::where('comment_id',$comment->id)
                        ->delete();
                    $comment->delete();
        return back();
    }

    public function addToCart(Request $request){
        $userId = Auth::user()->id;
        $productId = $request->productId;
        $quantity = $request->quantity;
        // Check if cart already has this product
        $cart = Cart::where('user_id', $userId)
                    ->where('product_id', $productId)
                    ->first();
        if ($cart) {
            // Increase existing quantity
            $cart->qty += $quantity;
            $cart->save();
        } else {
            // Create a new cart item
            Cart::create([
                'user_id'    => $userId,
                'product_id' => $productId,
                'qty'   => $quantity
            ]);
        }
        return redirect()->back();
    }

    public function goToCart(Request $request){
        $profile = User::select('users.id','users.name','users.profile','users.created_at')
                    ->where('id', Auth::user()->id)
                    ->first();

        $cartData = Cart::select('carts.id as cart_id','carts.qty','carts.user_id',
                                'products.id as product_id','products.image','products.name','products.sale_price','products.stock')
                        ->leftJoin('products','carts.product_id','products.id')
                        ->where('carts.user_id',Auth::user()->id)
                        ->get();
        $totalPrice = 0;
        foreach ($cartData as $data) {
            $totalPrice += $data->sale_price * $data->qty;
        }

        return view('user.home.cart',compact('cartData',"profile","totalPrice"));
    }


}
