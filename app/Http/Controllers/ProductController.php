<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function store(Request $request){
        $validator =Validator::make($request->all(),[
            'name' => 'required|unique:categories',
            'slug' => 'required|unique:categories',
            'category_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $categories = Category::where('id',$request->category_id)->first();
        if(!isset($categories->id)){
            return response()->json([
                'status'=> false,
                'message' => 'Category not found.'
            ]);
        }

        if($validator->passes()){

            $product = new Product();
            $product->name = $request->name;
            $product->slug = $request->slug;
            $product->category_id = $request->category_id;

            $path = public_path('images/');

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move($path, $imageName);

            $product->image = $imageName;
            
            $product->save();


            return response()->json([
                'status'=> true,
                'message' => 'Product added succesfully'
            ]);

        }else{
            return response()->json([
                'status'=> false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function index(){
        $products = Product::get();
        
            return Response([ 'products' => $products],200);
    }


    public function update($productID, Request $request){

        $product = Product::find($productID);

        // return response($request) ;

        if(empty($product)){
            return response()->json([
                'status'=> false,
                'notFound'=> true,
                'message' => 'product not found',
            ]);
        }
 
        $validator =Validator::make($request->all(),[
            'name' => 'required|unique:categories',
            'slug' => 'required|unique:categories,slug,'.$product->id.',id',
            'category_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if($validator->passes()){

            $product->name = $request->name;
            $product->slug = $request->slug;
            $product->category_id = $request->category_id;

            $path = public_path('images/');

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move($path, $imageName);

            $product->image = $imageName;
            
            $product->save();

            return response()->json([
                'status'=> true,
                'message' => 'Product updated succesfully'
            ]);

        }else{
            return response()->json([
                'status'=> false,
                'errors' => $validator->errors()
            ]);
        }
        
    }

    public function destory($productID){

        $product = Product::find($productID);

        if(empty($product)){
            return response()->json([
                'status'=> false,
                'message' =>'Product not found'
            ]);
        }

        $product->delete();

        return response()->json([
            'status'=> true,
            'message' =>'Product deleted succesfully'
        ]);
        
    }
}
