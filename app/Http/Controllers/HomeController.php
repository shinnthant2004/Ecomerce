<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function redirect(){
        if(Auth()->user()){
          $usertype=Auth::user()->usertype;
        }else{
          $usertype='0';
        }
        if($usertype=='1'){
            return view('admin.home');
        }else{
            if(Auth::user()){
                $user=Auth::user();
            $carts=Cart::where('phone',$user->phone);
            $cartCount=$carts->count();
            return view('user.home',[
                'data'=>Product::latest()->filter(request(['category','search']))->paginate(3)->withQueryString(),
                'categories'=>Category::all(),
                'cartCount'=>$cartCount
            ]);
            }else{
                return view('user.home',[
                    'data'=>Product::latest()->filter(request(['category','search']))->paginate(3)->withQueryString(),
                    'categories'=>Category::all(),
                ]);
            }
        }
    }
    public function index(){
     if(Auth::id()){
         return redirect('redirect');
     }else{
        return view('user.home',[
            'data'=>Product::latest()->filter(request(['category','search']))->paginate(3)->withQueryString(),
            'categories'=>Category::all(),
        ]);
     }
    }
    public function addcart(Request $request,Product $product){
       $selectedProduct= Product::find($product->id);
       $user=Auth::user();
       if(Auth::id()){
         $cart=new Cart;

         $client=$user->name;
         $phone=$user->phone;
         $address=$user->address;

         $cart->client_name=$client;
         $cart->phone=$phone;
         $cart->address=$address;
         $cart->product_name=$selectedProduct->title;
         $cart->price=$selectedProduct->price;
         $cart->quantity=$request->quantity;
         $cart->save();
         return redirect()->back()->with('success','Cart you chose is added');
       }else{
         return redirect('/login');
       }
    }
    public function mycarts(){
        $user=Auth::user();
        $carts=Cart::where('phone',$user->phone);
        $cartCount=$carts->count();
      return view('user.mycart',[
          'cartCount'=>$cartCount,
          'carts'=>$carts->get()
      ]);
    }
    public function destroy(Cart $cart){
        $cart->delete();
        return redirect()->back()->with('success','Removed That Cart');
    }
    public function confirmOrder(Request $request){
       $user=Auth::user();
       $name=$user->name;
       $phone=$user->phone;
       $address=$user->address;
       foreach($request->productname as $key=>$productname){
        $order=new Order;
        $order->product_name=$request->productname[$key];
        $order->quantity=$request->quantity[$key];
        $order->price=$request->price[$key];
        $order->status='not deliver';
        $order->client_name=$name;
        $order->phone=$phone;
        $order->address=$address;
        $order->save();
       };
       DB::table('carts')->where('phone',$phone)->delete();
       return redirect()->back()->with('success','Successfully Ordered');
    }
}
