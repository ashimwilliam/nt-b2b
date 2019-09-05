<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Brand;
use App\Product;
use App\Category;
use App\Subcategory;
use App\Banner;

class ProductController extends ApiBaseController
{
    public function getBrands(){
        $brands = Brand::where('status', 1)->get();

        return response()->json([
            'success' => true,
            'message' => '',
            'records' => $brands
        ])->setStatusCode(200);
    }

    public function getProductsByBrand(Request $request){
        $brand_id = $request->brand_id;
        if($brand_id && $brand_id != '' && is_numeric($brand_id)){
            $products = Product::where('status', 1)->where('brand_id', $brand_id)->get();

            return response()->json([
                'success' => true,
                'message' => '',
                'records' => $products
            ])->setStatusCode(200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Please check the brand.',
                'errors' => ''
            ])->setStatusCode(422);
        }
    }

    public function getCategories(){
        $categories = Category::where('status', 1)->get();

        return response()->json([
            'success' => true,
            'message' => '',
            'records' => $categories
        ])->setStatusCode(200);
    }

    public function getProductsByCategory(Request $request){
        $category_id = $request->category_id;
        if($category_id && $category_id != '' && is_numeric($category_id)){
            $products = Product::where('status', 1)->where('category_id', $category_id)->get();

            return response()->json([
                'success' => true,
                'message' => '',
                'records' => $products
            ])->setStatusCode(200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Please check the category.',
                'errors' => ''
            ])->setStatusCode(422);
        }
    }

    public function getSubCategories(Request $request){
        $category_id = $request->category_id;
        if($category_id && $category_id != '' && is_numeric($category_id)){
            $subcategories = Subcategory::where('status', 1)->where('category_id', $category_id)->get();

            return response()->json([
                'success' => true,
                'message' => '',
                'records' => $subcategories
            ])->setStatusCode(200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Please check the category.',
                'errors' => ''
            ])->setStatusCode(422);
        }
    }

    public function getProductsBySubCategory(Request $request){
        $subcategory_id = $request->subcategory_id;
        if($subcategory_id && $subcategory_id != '' && is_numeric($subcategory_id)){
            $products = Product::where('status', 1)->where('subcategory_id', $subcategory_id)->get();

            return response()->json([
                'success' => true,
                'message' => '',
                'records' => $products
            ])->setStatusCode(200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Please check the subcategory.',
                'errors' => ''
            ])->setStatusCode(422);
        }
    }

    public function getAllBanners(){
        $cuser = $this->currentUser();

        if($cuser) {
            $records = Banner::select('id', 'title', 'slug', 'image')->where('status', 1)->get();
            return response()->json([
                'success' => true,
                'message' => '',
                'records' => $records
            ])->setStatusCode(200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Unauthorised',
                'errors' => ''
            ])->setStatusCode(422);
        }
    }

    public function getBannerProducts(Request $request, $slug){
        $cuser = $this->currentUser();

        if($cuser) {
            if($slug == ''){
                return response()->json([
                    'success' => false,
                    'message' => 'Please check the slug.',
                    'errors' => ''
                ])->setStatusCode(422);
            }else {
                $records = Banner::select('id', 'title', 'slug', 'image')->with('products')->where('slug', $slug)->get();
                if($records) {
                    /*foreach ($records as $banner){
                        foreach ($banner->products as $product) {
                            $product->image_1 = env('APP_URL').'/uploads/product/'.$product->image_1;
                        }
                    }*/
                    return response()->json([
                        'success' => true,
                        'message' => '',
                        'records' => $records
                    ])->setStatusCode(200);
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'No products are associated with this banner.',
                        'records' => $records
                    ])->setStatusCode(422);
                }
            }
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Unauthorised',
                'errors' => ''
            ])->setStatusCode(422);
        }
    }
}
