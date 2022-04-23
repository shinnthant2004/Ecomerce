<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function product(){
        return view('admin.product');
    }

    public function uploadProduct(Request $request){
      $data=new Product;
      $imagename=request()->file('image')->store('uploadImage');
      $data->image=$imagename;
      $data->title=$request->title;
      $data->price=$request->price;
      $data->description=$request->des;
      $data->quantity=$request->quantity;
      $data->save();
      return redirect()->back()->with('success','New Projuct Added');
    }

    public function products(){
        $data=Product::all();
      return view('admin.products',compact('data'));
    }

    public function destroy(Product $product){
    $product->delete();
    return back()->with('success','Successly Deleted');
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
}
