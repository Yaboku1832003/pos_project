<?php
namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Rating;
use App\Models\Comment;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    //user dashboard
    public function homepage()
    {
        $products = Product::select('products.id', 'products.name', 'products.sale_price', 'products.description', 'products.image', 'products.updated_at',
            'categories.id as category_id', 'categories.name as category_name')
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->paginate(9);

        $categories = Category::all();

        // Calculate avg rating per product
        foreach ($products as $product) {
            $product->star_count = number_format(Rating::where('product_id', $product->id)->avg('count')); //rating for each product id
                                                                                                           // echo $product->star_count.'<br>';
        }
        $topRatedProducts = (clone $products)
        ->sortByDesc('star_count')
        ->take(5);
        // dd($products->toArray());
        return view('user.home.userHomePage', compact('products', 'categories','topRatedProducts'));
    }

    public function category(Request $request)
    {
        $search     = $request->input('search');
        $categoryId = $request->input('category_id');
        //price range
        $min = $request->input('min_price') !== null ? (int) $request->input('min_price') : null;
        $max = $request->input('max_price') !== null ? (int) $request->input('max_price') : null;
        //sorting with dropdown
        $sort = $request->input('sort');

        // dd($request->toArray());
        $products = Product::select('products.id', 'products.name', 'products.description', 'products.sale_price', 'products.image', 'products.updated_at',
            'categories.id as category_id', 'categories.name as category_name', DB::raw('AVG(ratings.count) as star_count'))
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->leftJoin('ratings', 'ratings.product_id', '=', 'products.id')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
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
            ->when($sort, function ($query) use ($sort) {
                if ($sort == 'lowest_price') {
                    $query->orderBy('sale_price', 'asc');
                } elseif ($sort == 'highest_price') {
                    $query->orderBy('sale_price', 'desc');
                } elseif ($sort == 'top_rated') {
                    $query->orderBy('star_count', 'desc');
                } elseif ($sort == 'most_recent') {
                    $query->orderBy('updated_at', 'desc');
                }
            })
            ->paginate(9);

        $categoryName = null;
        if ($categoryId) {
            $category     = Category::find($categoryId);
            $categoryName = $category ? $category->name : null;
        }
        $productCount = $products->count();

        return view('user.home.category', compact('products', 'categoryName', 'productCount'));
    }

    // one specific product detail
    public function detail($id)
    {
        $product = Product::select('products.*', 'categories.id as category_id', 'categories.name as category_name')
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->where('products.id', $id)
            ->first();

        $relatedProducts = Product::select('products.*', 'categories.id as category_id', 'categories.name as category_name')
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->where('category_id', $product->category_id)
            ->where('products.id', '!=', $product->id)
            ->take(2)
            ->get();

        $comments = Comment::select('comments.id as comment_id', 'comments.comment', 'comments.created_at',
            'users.id as user_id', 'users.profile', 'users.name', 'ratings.count')
            ->where('comments.product_id', $id)
            ->leftJoin('users', 'comments.user_id', 'users.id')
            ->leftJoin('ratings', function ($join) use ($id) {
                $join->on('ratings.user_id', '=', 'comments.user_id')
                    ->where('ratings.product_id', '=', $id);
            })
            ->orderBy('created_at', 'desc')->get();

        $userComment = $comments->where('user_id', Auth::id())
            ->first();
        // dd($comments->toArray());
        // dd($userComment->toArray());

        $rating = number_format(Rating::where('product_id', $id)->avg('count')); //rating for one specific product id

        return view('user.home.productDetail', compact('product', 'relatedProducts', 'comments', 'userComment', 'rating'));
    }

    public function comment(Request $request)
    {

        $comment = Comment::updateOrCreate([
            'product_id' => $request->productId,
            'user_id'    => Auth::user()->id,
        ],
            [
                'comment' => $request->review,
            ]);

        Rating::updateOrCreate([
            'product_id' => $request->productId,
            'user_id'    => Auth::user()->id,
        ],
            [
                'comment_id' => $comment->id,
                'count'      => $request->rating,
            ]);
        Alert::success('Thank You', 'Your Review has been submitted!');
        return back();
    }

    public function deleteComment(Request $request)
    {
        // dd($request->currentComment);
        // $comment =Comment::select('comments.*')
        //                 ->where('id',$request->currentComment)
        //                 ->first();
        // $rating=Rating::select('ratings.*')
        //                 ->where('comment_id',$comment->id)
        //                 ->first();
        // dd($rating->toArray());
        $comment = Comment::where('id', $request->currentComment)->first();

        Rating::where('comment_id', $comment->id)
            ->delete();
        $comment->delete();
        return back();
    }

    //order
    public function order(Request $request){
        // dd($request->toArray());
        $request->validate([
            'name'=>'required',
            'phone'=>'required|numeric|digits_between:5,11',
            'address'=>'required|max:2000',
            'paymentType'=>'required',
            'paymentVoucher'=>'required|file|mimes:png,jpg,jpeg,webp,svg,gif'
        ]);

        $orderTemp = Session::get('tempCart');

        $paymentHistory = [
            'user_name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'payment_type' => $request->paymentType,
            'order_code' => $request->order_code,
            'final_total' => $request->finalTotal
        ];
        if ($request->hasFile('paymentVoucher')) {
            // get tmp name to save image
            $fileName = uniqid() . $request->file('paymentVoucher')->getClientOriginalName();
            // save image in public-productImage file
            $request->file('paymentVoucher')->move(public_path() . '/payment_voucher/', $fileName);
            // put $fileName in $data before put into db
            $paymentHistory['payment_voucher'] = $fileName;
        }
        // dd($paymentHistory);
        PaymentHistory::create($paymentHistory);
        // dd($orderTemp);
        foreach($orderTemp as $items){
            Order::create([
                'product_id' => $items['product_id'],
                'user_id' => $items['user_id'],
                'count' => $items['count'],
                'status' => $items['status'],
                'order_code' => $items['order_code'],
                'readStatus' => '0'
            ]);

        Cart::where('product_id',$items['product_id'])
                ->where('user_id',$items['user_id'])
                ->delete();

        }

        Alert::success('Order Success','Your order has been placed successfully');
        return to_route('user#cart');
    }


    //my order list
    public function orderList(){
        $profile = User::select('users.id', 'users.name', 'users.profile', 'users.created_at')
            ->where('id', Auth::user()->id)
            ->first();

        $pendingOrder = Order::where('user_id',Auth::user()->id)
                            ->groupBy('order_code')
                            ->orderBy('created_at',"desc")
                            ->get();
        // dd($pendingOrder->toArray());
        return view('',compact('pendingOrder','profile'));
    }
}
