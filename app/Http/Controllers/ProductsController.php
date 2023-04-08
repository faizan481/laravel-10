<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use App\Models\Category;
use App\Models\about;

use App\Models\Product;

use App\Models\altimages;

use Illuminate\Http\Request;

use Storage;

use App\Models\products_properties;

use Image;




class ProductsController extends Controller
{



   //    public function index()
   // {
   //  return view('admin.index');
   // }

     public function index()
    {

        $Products = DB::table('categories')->rightJoin('products', 'products.category_id', '=', 'categories.id')->get(); // now we are fetching all products

        // now we are fetching all products and categories
        $Products=Product::all();
        return view('admin.product.index',compact('Products'));
    }

   // public function cats() {
   //   return view('admin.index');
   // }

   // public function index() {

   //    $cat_data = DB::table('pro_cat')->get();
   //    // $Products = DB::table('products')->get();
   //    // $cat_data=Pro_cat::all();
   //      // return view('admin.home');
   //      return view('admin.home', compact('cat_data'));
   //  }

   public function create()
    {
        $categories=Category::pluck('name','id');
        return view('admin.product.create',compact('categories'));
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
            'image'=>'image|mimes:png,jpg,jpeg|max:10000'
        ]);



        $image=$request->image;
        if($image){
            $imageName=$image->getClientOriginalName();
            $image->move('images',$imageName);
            $formInput['image']=$imageName;
        }

        $categories=Category::all();
        Product::create($formInput);
        // return redirect()->route('admin.index');
        return redirect()->back();

}


public function show($id)
    {
        $product = Product::findOrFail($id);
        // $blog = Blog::whereSlug($slug)->first();
        return view('product.show', compact('products'));
        // var_dump($product);
    }


public function ProductEditForm($id) {


        $Products = Product::findOrFail($id);
        $categories = Category::all();

        $prots = products_properties::all();

        return view('admin.product.editProducts', compact('Products', 'categories', 'prots'));
    }



public function editProducts(Request $request, $id) {


        // $pro_id = $reqeust->id;
        $Products = DB::table('products')->where('id', '=', $id)->get();

        // $category = Category::findOrFail($id); // now we are fetching all products

        // Product::findOrFail($id)->update($request->all());


        $proid = $request->id;

        $pro_name = $request->pro_name;
        $category_id = $request->cat_id;
        $pro_code = $request->pro_code;
        $pro_price = $request->pro_price;
        $pro_info = $request->pro_info;
        $spl_price = $request->spl_price;

        if($request->new_arrival =='NULL'){
          $new_arrival = '1';
        }else {
          $new_arrival = $request->new_arrival;
        }


        DB::table('products')->where('id', $proid)->update([
            'pro_name' => $pro_name,
            'category_id' => $category_id,
            'pro_code' => $pro_code,
            'pro_price' => $pro_price,
            'pro_info' => $pro_info,
            'spl_price' => $spl_price,
             'new_arrival' => $new_arrival

        ]);







        // $Product::findOrFail($id)->update($request->all());
        // return view('admin.product.update', compact('product','category'));

        return view('admin.product.index', compact('Products','category'));

        // return redirect()->back();
    }



    public function ImageEditForm($id) {

        $Products = Product::findOrFail($id);

        return view('admin.product.ImageEditForm', compact('Products'));
    }

public function editProImage(Request $request) {


        $proid = $request->id;


        $image=$request->image;
        if($image){
            $imageName=$image->getClientOriginalName();
            $image->move('images',$imageName);
            $formInput['image']=$imageName;
        }





        DB::table('products')->where('id', $proid)->update(['image' => $imageName]);


        return redirect()->back();

    }


public function destroy($id)
    {
        //
          Product::findOrFail($id)->delete();

        return redirect()->back();
    }



  public function addProperty($id) {


        $Products = Product::findOrFail($id);



        return view('admin.product.addProperty', compact('Products'));
    }



  public function sumbitProperty(Request $request){

    $properties = new products_properties;
    $properties->pro_id = $request->pro_id;
    $properties->size = $request->size;
    $properties->color = $request->color;
    $properties->p_price = $request->p_price;
    $properties->save();

    return redirect()->back();



  }


 public function editProperty(Request $request){
         $uptProts = DB::table('products_properties')
          ->where('pro_id', $request->pro_id)
          ->where('id', $request->id)
          ->update($request->except('_token'));
          if($uptProts){
          return back()->with('msg', 'updated');
        }else {
        return back()->with('msg', 'check value again');
      }
  }


  public function addSale(Request $request){



   $salePrice = $request->salePrice;
      $pro_id = $request->pro_id;
      DB::table('products')->where('id', $pro_id)->update(['spl_price' => $salePrice]);
      echo 'added successfully';


    }





}
