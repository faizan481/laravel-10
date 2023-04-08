<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
// use DB;
use App\Models\wishList;
use Image;
use App\Models\recommends;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

     public function __construct() {
        return view('front.home');
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=Product::all();
        $categories=Category::all();
        return view('front.home');
    }

     public function shop()
    {
        $products=Product::all();
        $categories=Category::all();
        // dd($products);
        return view('front.shop',compact(['categories','products']));

    }



    public function product_details($id)


    {


        if(Auth::check()){
        $recommends = new recommends;
        $recommends ->uid = Auth::user()->id;
        $recommends ->pro_id = $id;
        $recommends ->save();
        }

        // $products = Product::findOrFail($id);

        // return view('front.product_details', compact('products'));

        //  $products = DB::table('products')->where('id',$id)->get();
        // return view('front.product_details', compact('products'));


        $Products = DB::table('products')->where('id',$id)->get();
        return view('front.product_details', compact('Products'));

    }

    public function wishlist(Request $request) {

        $wishList = new wishlist;
        $wishList->user_id = Auth::user()->id;
        $wishList->pro_id = $request->pro_id;

        $wishList->save();

        $Products = DB::table('products')->where('id', $request->pro_id)->get();

        return view('front.product_details', compact('Products'));
    }

    public function View_wishList() {

        $Products = DB::table('wishlist')->leftJoin('products', 'wishlist.pro_id', '=', 'products.id')->get();
        return view('front.wishList', compact('Products'));
    }

    public function removeWishList($id) {

        DB::table('wishlist')->where('pro_id', '=', $id)->delete();

        return back()->with('msg', 'Item Removed from Wishlist');
    }


    // public function shop()
    // {
    //     return view('front.shop');
    // }

    public function contact()
    {
        return view('front.contact');
    }

   public function selectSize(Request $request) {
        // echo $request->proDum; // see it in console

        $proDum = $request->proDum;
        $size = $request->size;

        $s_price = DB::table('products_properties')->where('pro_id', $proDum)
        ->where('size', $size)
        ->get();


        foreach($s_price as $sPrice){
            echo "US $ " .$sPrice->p_price;?>

             <input type="hidden" value="<?php echo $sPrice->p_price;?>" name="newPrice"/>
             <div style="background:<?php echo $sPrice->color;?>; width:40px; height:40px"></div>
             <?php
        }
    }

    public function newArrival(){
                  $products = DB::table('products')->where('new_arrival', 1)->paginate(6); // now we are fetching all products
                  return view('front.newArrival', compact('products'));

    }


   public function addReview(Request $request){


    DB::table('reviews')->insert(
    ['person_name' => $request->person_name, 'person_email' => $request->person_email,
  'review_content' => $request->review_content,
  'created_at' => date("Y-m-d H:i:s"),'updated_at' =>date("Y-m-d H:i:s")]
      );
      return back();
    }

    public function search(Request $request)
    {

         $search = $request->site_search;

         if ($search == '') {
            return view('front.shop');
        } else {
        $products = DB::table('products')->where('pro_name', 'like', '%' . $search . '%')->paginate(2);
        return view('front.shop', ['msg' => 'Results: '. $search ], compact('products'));
    }
  }

    // public function shop()
    // {
    //     $products=Product::all();
    //     $categories=Category::all();
    //     return view('front.shop',compact(['categories','products']));

    // }




}
