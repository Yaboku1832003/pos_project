<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable =['name','cost_price','sale_price','description','category_id','stock','image'];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
