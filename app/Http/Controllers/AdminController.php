<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use App\Models\Category;
use App\Models\about;

use App\Models\products;

use App\Models\altimages;

use Illuminate\Http\Request;

use Storage;

use App\Models\pro_cat;

use Image;

use App\Models\products_properties;




// use App\products as Products;

class AdminController extends Controller
{
    //
     public function index()
   {
    return view('admin.home');
   }

   public function cats() {
     return view('admin.home');
   }

   // public function index() {

   //    $cat_data = DB::table('pro_cat')->get();
   //    // $Products = DB::table('products')->get();
   //    // $cat_data=Pro_cat::all();
   //      // return view('admin.home');
   //      return view('admin.home', compact('cat_data'));
   //  }

   public function create()
    {
        // $categories=Category::pluck('name','id');
        // return view('admin.home',compact('categories'));
    }

    //  public function home()
    // {
    //   $cat_data = DB::table('pro_cat')->get();
    //     // return view('admin.home');
    //     return view('admin.home', compact('cat_data'));
    // }

    // public function addpro_form(){
    //   $cat_data = DB::table('pro_cat')->get();

    //   return view('admin.home', compact('cat_data'));
    // }


    //  public function cats()
    // {
    //     return view('admin.home');
    // }

    // public function addpro_form(){
    //   $cat_data = DB::table('pro_cat')->get();

    //   return view('admin.home', compact('cat_data'));
    // }



   public function store(Request $request)

    {


        $formInput=$request->except('image');
//        validation

        $this->validate($request,[
            'pro_name'=>'required',
            'pro_code'=>'required',
            'pro_price'=>'required',
            'pro_info'=>'required',
            'spl_price'=>'required',
            'stock'=>'required',
            'image'=>'image|mimes:png,jpg,jpeg|max:10000'
        ]);



        $image=$request->image;
        if($image){
            $imageName=$image->getClientOriginalName();
            $image->move('images',$imageName);
            $formInput['image']=$imageName;
        }
        $cat_data = DB::table('pro_cat')->get();
        $categories=Category::all();
        Products::create($formInput);
        return redirect()->back();
        // return redirect()->action('AdminController@index')->with('status', 'Product uploaded');

}


public function show($id)
    {
        $product = Product::findOrFail($id);
        // $blog = Blog::whereSlug($slug)->first();
        return view('product.show', compact('products'));
        // var_dump($product);
    }



   public function view_products(Request $request) {


        $Products = DB::table('products')->get();

        return view('admin.products', compact('Products'));



    }



    public function add_cat(Request $request) {


        return 'view products';



    }



    public function view_cats(Request $request) {


        return 'view products';



    }




}
