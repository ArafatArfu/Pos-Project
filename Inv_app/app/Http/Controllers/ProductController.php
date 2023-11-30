<?php


namespace App\Http\Controllers;

use App\Models\Product;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;


class ProductController extends Controller
{
    function ProductPage(Request $request){
        return view('pages.dashboard.product-page');
    }


    function CreateProduct(Request $request){
        $user_id= $request->header('id');

        $img= $request->file('img');
        $t= time();
        $file_name= $img->getClientOriginalName();
        $img_name="{$user_id}-{$t}-{$file_name}";
        $img_url="uploads/{$img_name}";

                //Upload
        $img->move(public_path('uploads'),$img_name);

            //Save to database
        return product::create([
            'name'=> $request->input('name'),
            'unit'=> $request->input('unit'),
            'price'=> $request->input('price'),
            'img_url'=>$img_url,
            'category_id'=> $request->input('category_id'),
            'user_id'=>$user_id
        ]);
    }


    function DeleteProduct(Request $request)
    {
        $user_id=$request->header('id');
        $product_id=$request->input('id');
        $filePath=$request->input('file_path');
        File::delete($filePath);
        return product::where('id',$product_id)->where('user_id',$user_id)->delete();

    }


    function ListProduct(Request $request){
        $user_id= $request->header('id');
        return product::where('user_id',$user_id)->get();
    }



    function UpdateProduct(Request $request){
        $user_id= $request->header('id');
        $product_id= $request->input('id');

       if($request->hasFile('img')){
            //upload new file
         $img= $request->file('img');
         $t= time();
         $file_name= $img->getClientOriginalName();
         $img_name="{$user_id}-{$t}-{$file_name}";
         $img_url="uploads/{$img_name}";
         $img->move(public_path('uploads'),$img_name);

                //Delete old file
        $filePath= $request->input('file_path');
        File::delete($filePath);

                //update Product
        return product::where('id',$product_id)->where('user_id',$user_id)->update([
            'name'=>$request->input('name'),
            'price'=>$request->input('price'),
            'unit'=>$request->input('unit'),
            'img_url'=>$img_url,
            'category_id'=>$request->input('category_id')
        ]);
       }
       else{
        return product::where('id',$product_id)->where('user_id',$user_id)->update([
            'name'=>$request->input('name'),
            'price'=>$request->input('price'),
            'unit'=>$request->input('unit'),
            'category_id'=>$request->input('category_id')
        ]);
       }
    }

    function ProductById(Request $request){
        $user_id=$request->header('id');
        $product_id=$request->input('id');
        return Product::where('id',$product_id)->where('user_id',$user_id)->first();
    }
}
