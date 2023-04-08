<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Gloudemans\Shoppingcart\Facades\Cart;

use App\Models\Product;

use Illuminate\Http\Request;

class CartController extends Controller
{
    //
    public function index() {
        $cartItems = Cart::content();
        return view('cart.index', compact('cartItems'));
    }

    // public function addItem($id) {
         // echo $id;
         // $product = Product::findOrFail($id);
         // $products = products::find($id);

         // Cart::add($id, $products->pro_name, 1, $products->pro_price);
    //      Cart::add($id, $product->pro_name, 1, $product->pro_price, ['img' => $product->image, 'stock' => $product->stock]);
    //       return back();
    // }


     public function addItem(Request $request, $id) {
         // echo $id;

         $product = Product::find($id);

         if(isset($request->newPrice))
        {
          $price = $request->newPrice; // if size select
        }
        else{
          $price = $product->pro_price; // default price
        }



         // $products = products::find($id);

         // Cart::add($id, $products->pro_name, 1, $products->pro_price);
         Cart::add($id, $product->pro_name, 1, $price, ['img' => $product->image, 'stock' => $product->stock]);
          return back();
    }

    public function destroy($id){
        Cart::remove($id);
        // echo $id;
        return back();
    }

   // public function  update(Request $request, $id){

   //    Cart::update($id, $request->qty);
   //    return back();
   //  }


   public function  update(Request $request, $id){

        $qty = $request->qty;
      $proId = $request->proId;

      $rowId = $request->rowId; // for update

      Cart::update($rowId, $qty);
      // $cartItems = Cart::update($rowId, $qty);
      $cartItems = Cart::content();
      return view('cart.upCart', compact('cartItems'))->with('status', 'cart updated');
      // echo Cart::content(); // for display all new data of cart


      // $product = product::find($proId);
      // $stock = $product->stock;



      // if($qty<$stock) {
      //     $msg = 'Cart is updated';
      //    Cart::update($id, $request->qty);
      //    return back()->with('status', $msg);
      // } else{
      //    $msg = 'Please check your qty is more than product stock';
      //    return back()->with('error', $msg);

      // }

      }
}
