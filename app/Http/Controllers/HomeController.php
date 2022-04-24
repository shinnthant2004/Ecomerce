<?php

namespace App\Http\Controllers;

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
            return view('user.home',[
                'data'=>Product::latest()->filter(request(['category','search']))->paginate(3)->withQueryString(),
                'categories'=>Category::all()
            ]);
        }
    }
    public function index(){
     if(Auth::id()){
         return redirect('redirect');
     }else{
        return view('user.home',[
            'data'=>Product::latest()->filter(request(['category','search']))->paginate(3)->withQueryString(),
            'categories'=>Category::all()
        ]);
     }
    }
}
