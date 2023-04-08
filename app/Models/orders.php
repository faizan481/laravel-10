<?php
namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Product;
use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    //
    protected $fillable = ['total', 'status'];


    public function orderFields() {
       return $this->belongsToMany(Product::class)->withPivot('qty', 'total');
    }

    public static function createOrder() {

        // for order inserting to database

           // echo 'order done';

          $user = Auth::user();
          $order = $user->orders()->create(['total' => Cart::total(), 'status' => 'pending']);

         $cartItems = Cart::content();

         foreach ($cartItems as $cartItem) {
            $order->orderFields()->attach($cartItem->id, ['qty' => $cartItem->qty, 'tax' => Cart::tax(), 'total' => $cartItem->qty * $cartItem->price]);
        }
     }

}
