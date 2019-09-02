<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Brand;
use App\Product;
use App\Category;
use App\Subcategory;

class ProductController extends ApiBaseController
{
    public function getBrands(){
        $brands = Brand::where('status', 1)->get();

        return response()->json([
            'success' => true,
            'records' => $brands
        ])->setStatusCode(200);
    }

    public function getProductsByBrand(Request $request){
        $brand_id = $request->brand_id;
        if($brand_id && $brand_id != '' && is_numeric($brand_id)){
            $products = Product::where('status', 1)->where('brand_id', $brand_id)->get();

            return response()->json([
                'success' => true,
                'records' => $products
            ])->setStatusCode(200);
        }else{
            return response()->json([
                'success' => false,
                'errors' => 'Please check the brand.',
                'error_message' => ''
            ])->setStatusCode(422);
        }
    }

    public function getCategories(){
        $categories = Category::where('status', 1)->get();

        return response()->json([
            'success' => true,
            'records' => $categories
        ])->setStatusCode(200);
    }

    public function getProductsByCategory(Request $request){
        $category_id = $request->category_id;
        if($category_id && $category_id != '' && is_numeric($category_id)){
            $products = Product::where('status', 1)->where('category_id', $category_id)->get();

            return response()->json([
                'success' => true,
                'records' => $products
            ])->setStatusCode(200);
        }else{
            return response()->json([
                'success' => false,
                'errors' => 'Please check the category.',
                'error_message' => ''
            ])->setStatusCode(422);
        }
    }

    public function getSubCategories(Request $request){
        $category_id = $request->category_id;
        if($category_id && $category_id != '' && is_numeric($category_id)){
            $subcategories = Subcategory::where('status', 1)->where('category_id', $category_id)->get();

            return response()->json([
                'success' => true,
                'records' => $subcategories
            ])->setStatusCode(200);
        }else{
            return response()->json([
                'success' => false,
                'errors' => 'Please check the category.',
                'error_message' => ''
            ])->setStatusCode(422);
        }
    }

    public function getProductsBySubCategory(Request $request){
        $subcategory_id = $request->subcategory_id;
        if($subcategory_id && $subcategory_id != '' && is_numeric($subcategory_id)){
            $products = Product::where('status', 1)->where('subcategory_id', $subcategory_id)->get();

            return response()->json([
                'success' => true,
                'records' => $products
            ])->setStatusCode(200);
        }else{
            return response()->json([
                'success' => false,
                'errors' => 'Please check the subcategory.',
                'error_message' => ''
            ])->setStatusCode(422);
        }
    }
}
