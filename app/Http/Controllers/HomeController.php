<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            $user=Auth::user();
            $carts=Cart::where('phone',$user->phone);
            $cartCount=$carts->count();
            return view('user.home',[
                'data'=>Product::latest()->filter(request(['category','search']))->paginate(3)->withQueryString(),
                'categories'=>Category::all(),
                'cartCount'=>$cartCount
            ]);
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
}
