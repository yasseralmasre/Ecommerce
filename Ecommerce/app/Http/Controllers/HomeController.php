<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Comment;
use App\Models\Replay;

use Session;
use Stripe;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function redirect()
    {

        $usertype = Auth::user()->usertype;

        if($usertype == '1')
        {

            $total_product = Product::all()->count();

            $total_order = Order::all()->count();

            $total_user = User::all()->count();

            $order = Order::all();

            $total_revenue = 0;

            foreach($order as $order)
            {
                $total_revenue = $total_revenue + $order->price;
            }

            $total_delivered = Order::where('delivery_status','=','delivered')->get()->count();

            $total_processing = Order::where('delivery_status','=','processing')->get()->count();

            return view('admin.home' ,compact('total_product','total_order',
            'total_user','total_revenue','total_delivered','total_processing'));

        }

        else {
 
            $product = Product::paginate(10);

            $comment = Comment::orderby('id','desc')->get();

            $replay = Replay::all();

        return view('home.userpage' , compact('product','comment','replay'));
        }


    }

    public function index()
    {

        $product = Product::paginate(10);

        $comment = Comment::orderby('id','desc')->get();

        $replay = Replay::all();

        return view('home.userpage' , compact('product','comment','replay'));

    }

    public function product_details($id)
    {
        $product = Product::find($id);

        return view('home.product_details' , compact('product'));

    }

    public function add_cart(Request $request , $id)
    {

        if(Auth::id()){

            $user=Auth::user();   
            
            $user_id=$user;
            
            $product=Product::find($id);

            $product_exist_id=Cart::where('product_id','=',$id)
            ->where('user_id','=',$user_id)
            ->get('id')->first();

            if($product_exist_id)
            {

                $cart=Cart::find($product_exist_id)->first();

                $quantity=$cart->quantity;

                $cart->quantity=$quantity + $request->quantity ;

                if($product->discount_price!=null)
                {
                    $cart->price=$product->discount_price * $cart->quantity;    
                }
    
                else
                {
                    $cart->price=$product->price * $cart->quantity;
                }

                $cart->save();

                return redirect()->back()->with('message','Product Added succesfully');

            }
            else
            {

                $cart= new Cart;

                $cart->user_id=$user->id;
                $cart->name=$user->name;
                $cart->email=$user->email;
                $cart->phone=$user->phone;
                $cart->address=$user->address;
              
                if($product->discount_price!=null)
                {
                    $cart->price=$product->discount_price * $request->quantity;    
                }
    
                else
                {
                    $cart->price=$product->price * $request->quantity;
                }
    
                $cart->product_id=$product->id;
                $cart->product_title=$product->title;
                $cart->image=$product->image;
               
                $cart->quantity=$request->quantity;
    
                $cart->save();
    
                return redirect()->back()->with('message','Product Added succesfully');
    
            }

            }

        else
        {
            return redirect('login');
        }
    }

    public function show_cart()
    {

        if(Auth::id())
        {
            $id=Auth::user()->id;
            $cart=Cart::where('user_id','=',$id)->get();
   
           return view('home.show_cart',compact('cart'));
        }
        else
        {
            return redirect('login');
        }

    }

    public function remove_cart($id){

        $cart=Cart::find($id);
        $cart->delete();
        return redirect()->back();

    }

    public function cash_order(){

        $user=Auth::user();
        $user_id=$user->id;
        $data=Cart::where('user_id','=', $user_id)->get();

        foreach($data as $data)
        {
            $order = new Order;

            $order->name=$data->name;
            $order->email=$data->email;
            $order->phone=$data->phone;
            $order->address=$data->address;
            $order->user_id=$data->user_id;

            $order->product_title=$data->product_title;
            $order->price=$data->price;
            $order->quantity=$data->quantity;
            $order->image=$data->image;
            $order->product_id=$data->product_id;
           
            $order->payment_status='cash on delivery';
            $order->delivery_status='processing';

            $order->save();

            $cart_id=$data->id;

            $cart=Cart::find($cart_id);

            $cart->delete();
            
        }



        return redirect()->back()->with('message', 'We recieved your order . 
        We will connect with you soon');

    }

    public function stripe($totalprice)
    {

            return view('home.stripe' , compact('totalprice'));

    }

    public function stripePost(Request $request , $totalprice)
    {

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    
        Stripe\Charge::create ([
                "amount" => $totalprice * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Thanks For Payment" 
        ]);

        {

            $user=Auth::user();
            $user_id=$user->id;
            $data=Cart::where('user_id','=', $user_id)->get();
    
            foreach($data as $data)
            {
                $order = new Order;
    
                $order->name=$data->name;
                $order->email=$data->email;
                $order->phone=$data->phone;
                $order->address=$data->address;
                $order->user_id=$data->user_id;
    
                $order->product_title=$data->product_title;
                $order->price=$data->price;
                $order->quantity=$data->quantity;
                $order->image=$data->image;
                $order->product_id=$data->product_id;
               
                $order->payment_status='Paid : ';
                $order->delivery_status='processing';
    
                $order->save();
    
                $cart_id=$data->id;
    
                $cart=Cart::find($cart_id);
    
                $cart->delete();
                
            }

    
        }
      
        Session::flash('success', 'Payment successful!');
              
        return back();
    }

    
    public function show_order()
    {

        if(Auth::id())
        {

            $user=Auth::user();
            $user_id=$user->id;
            $order=Order::where('user_id' , '=' , $user_id)->get();

            return view('home.order', compact('order'));    
        }
        else
        {
            return redirect('login');
        }
        

    }

    public function cancel_order($id)
    {

        $order=Order::find($id);
        $order->delivery_status='You Cancel The Order';
        $order->save();

        return redirect()->back();

    }
    
    public function add_comment (Request $request)
    {

        if (Auth::id())
        {

            $comment= new Comment;

            $comment->name = Auth::user()->name;

            $comment->user_id = Auth::user()->id;

            $comment->comment = $request->comment;

            $comment->save();

            return redirect()->back();

        }

        else
        {
            return redirect('login');
        }

    }

    public function add_replay (Request $request)
    {

        if (Auth::id())
        {

            $replay= new Replay;

            $replay->name = Auth::user()->name;

            $replay->user_id = Auth::user()->id;

            $replay->comment_id = $request->commentId;

            $replay->replay = $request->replay;

            $replay->save();

            return redirect()->back();

        }

        else
        {
            return redirect('login');
        }

    }

    public function product_search(Request $request)
    {

        $search_text=$request->search;

        $product=Product::where('title','LIKE',"%$search_text%")->paginate(10);

        $comment = Comment::orderby('id','desc')->get();

        $replay = Replay::all();
        
        return view('home.userpage',compact('product','comment','replay'));

    }

    public function products()
    {

        $product=Product::paginate(10);

        $comment = Comment::orderby('id','desc')->get();

        $replay = Replay::all();


        return view('home.products',compact('product','comment','replay'));

    }

    public function products_search(Request $request)
    {

        $search_text=$request->search;

        $product=Product::where('title','LIKE',"%$search_text%")->paginate(10);

        $comment = Comment::orderby('id','desc')->get();

        $replay = Replay::all();
        
        return view('home.all_products',compact('product','comment','replay'));

    }

}
