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
            ->get();
        $categories = Category::all();

        // Calculate avg rating per product
        foreach ($products as $product) {
            $product->star_count = number_format(Rating::where('product_id', $product->id)->avg('count')); //rating for each product id
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

    public function addToCart(Request $request)
    {
        $userId    = Auth::user()->id;
        $productId = $request->productId;
        $quantity  = $request->quantity;
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
                'qty'        => $quantity,
            ]);
        }
        return redirect()->back();
    }

    // show profile and products in cart page
    public function goToCart(Request $request)
    {
        $profile = User::select('users.id', 'users.name', 'users.profile', 'users.created_at')
            ->where('id', Auth::user()->id)
            ->first();

        $cartData = Cart::select('carts.id as cart_id', 'carts.qty', 'carts.user_id',
            'products.id as product_id', 'products.image', 'products.name', 'products.sale_price', 'products.stock')
            ->leftJoin('products', 'carts.product_id', 'products.id')
            ->where('carts.user_id', Auth::user()->id)
            ->get();
        $totalPrice = 0;
        foreach ($cartData as $data) {
            $totalPrice += $data->sale_price * $data->qty;
        }
        $orderHistory = Order::where('user_id',Auth::user()->id)
                            ->groupBy('order_code')
                            ->orderBy('created_at',"desc")
                            ->get();

        return view('user.home.cart', compact('cartData', "profile", "totalPrice",'orderHistory'));
    }

    // delete item from cart
    public function cartDelete(Request $request)
    {
        $cartData = $request->cartId;
        // logger($cartData);
        Cart::where('id', $cartData)->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'cart deleted successfully',
        ], 200);
    }

    //qty update before leave url
    public function cartUpdate(Request $request)
    {
        $cartUpdates = $request->data;
        if ($cartUpdates) {
            foreach ($cartUpdates as $item) {
                Cart::whereId($item['cartId'])->update(['qty' => $item['quantity']]);
            }
            return response()->json([
                'status'  => 'success',
                'message' => 'Cart updated successfully',
            ], 200);
        }
    }
    //temporary store order data
    public function tempStorage(Request $request){
        // logger($request->all());
        $orderTemp = [];
        foreach ($request->all() as $data) {
            array_push($orderTemp,[
                //name from db table <-> name from the jQuery
                'product_id' => $data['product_id'],
                'user_id' => $data['user_id'],
                'count' => $data['count'],
                'status' => $data['status'],
                'order_code' => $data['order_code'],
                'subTotal' => $data['subTotal']
            ]);
        }
        // logger($orderTemp);
        Session::put('tempCart', $orderTemp);

        return response()->json([
                'status'  => 'success',
                'message' => 'Successfully store in session.',
            ], 200);
    }

    //direct to payment page
    public function paymentPage()
    {
        $orderTemp = Session::get('tempCart');
        $paymentAcc = Payment::select('id as payment_id','account_name','account_number','type')->orderBy('type','asc')->get();
        $products = Cart::select('carts.qty', 'carts.user_id', 'products.image',
                            'products.name', 'products.sale_price')
            ->leftJoin('products', 'carts.product_id', 'products.id')
            ->where('carts.user_id', Auth::user()->id)
            ->get();
        // dd($products->toArray());
        return view('user.home.paymentPage',compact('paymentAcc','orderTemp','products'));
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
                'order_code' => $items['order_code']
            ]);

        Cart::where('product_id',$items['product_id'])
                ->where('user_id',$items['user_id'])
                ->delete();

        }

        Alert::success('Order Success','Your order has been placed successfully');
        return to_route('user#cart');
    }


    //pending order list
    public function pendingOrderList(){
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
