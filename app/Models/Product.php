<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public function category(){
    return $this->belongsTo(Category::class);
    }
    public function ScopeFilter($query,$filter){
      $query->when($filter['search'] ?? false,function($query,$search){
         $query->where('title','LIKE','%'.$search.'%');
      });

      $query->when($filter['category'] ?? false,function($query,$slug){
        $query->whereHas('category',function($query) use ($slug){
            $query->where('slug',$slug);
        });
      });
    }
}
