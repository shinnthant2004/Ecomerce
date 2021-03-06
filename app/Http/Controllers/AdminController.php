<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function product(){
        return view('admin.product',[
            'categories'=>Category::all()
        ]);
    }

    public function uploadProduct(Request $request){
        $request->validate([
            'category_id'=>['required']
        ]);
      $data=new Product;
      $imagename=request()->file('image')->store('uploadImage');
      $data->image=$imagename;
      $data->title=$request->title;
      $data->price=$request->price;
      $data->description=$request->des;
      $data->quantity=$request->quantity;
      $data->category_id=$request->category_id;
      $data->save();
      return redirect()->back()->with('success','New Projuct Added');
    }

    public function products(){
        $data=Product::all();
      return view('admin.products',compact('data'));
    }

    public function destroy(Product $product){
    $product->delete();
    return back()->with('success','Successfully Deleted');
    }

    public function updateProduct(Product $product){
        $data=$product;
      return view('admin.update',compact('data'));
    }

    public function updateDProduct(Request $request,Product $product){
       if($request->image){
        $imagename=request()->file('image')->store('uploadImage');
        $product->image=$imagename;
       }
        $product->title=$request->title;
        $product->price=$request->price;
        $product->description=$request->des;
        $product->quantity=$request->quantity;
        $product->save();
        return redirect()->back()->with('success','Updating Completed');
    }
    public function orders(){
     return view('admin.orders',[
         'orders'=>Order::all()
     ]);
    }
    public function deliver(Order $order){
        $currentOrder=Order::find($order->id);
        $currentOrder->status='delivered';
        $currentOrder->save();
        return redirect()->back();
    }
}
