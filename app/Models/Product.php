<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
     protected $table = 'products';
     protected $primaryKey = 'id';
     protected $fillable=['pro_name','pro_code','pro_price','image','pro_info','spl_price','category_id','stock'];

     public function categories() {

        return $this->belongsToMany('Category', 'categories');
    }

   public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
