<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;


class CategoryController extends Controller
{
    public function store(Request $request){
        $validator =Validator::make($request->all(),[
            'name' => 'required|unique:categories',
            'slug' => 'required|unique:categories',
        ]);

        if($validator->passes()){

            $category = new Category();
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->save();


            return response()->json([
                'status'=> true,
                'message' => 'Category added succesfully'
            ]);

        }else{
            return response()->json([
                'status'=> false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function index(){
        $categories = Category::get();
        
            return Response([ 'categories' => $categories],200);
    }


    public function update($categoryID, Request $request){

        $category = Category::find($categoryID);

        if(empty($category)){
            return response()->json([
                'status'=> false,
                'notFound'=> true,
                'message' => 'Category not found',
            ]);
        }

        $validator =Validator::make($request->all(),[
            'name' => 'required|unique:categories',
            'slug' => 'required|unique:categories,slug,'.$category->id.',id',
        ]);

        if($validator->passes()){

            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->save();


            return response()->json([
                'status'=> true,
                'message' => 'Category updated succesfully'
            ]);

        }else{
            return response()->json([
                'status'=> false,
                'errors' => $validator->errors()
            ]);
        }
        
    }

    public function destory($categoryID, Request $request){

        $category = Category::find($categoryID);

        if(empty($category)){
            return response()->json([
                'status'=> false,
                'message' =>'Category not found'
            ]);
        }

        $category->delete();

        return response()->json([
            'status'=> true,
            'message' =>'Category deleted succesfully'
        ]);
        
    }
}
