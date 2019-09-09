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

    public function getProductDetails(Request $request, $id){
        $cuser = $this->currentUser();

        if($cuser) {
            if($id != '' && is_numeric($id)){
                $product = Product::with('prices')->where('id', $id)->get()->first();
                if($product){
                    return response()->json([
                        'success' => true,
                        'message' => '',
                        'records' => $product
                    ])->setStatusCode(200);
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'Product not found.',
                        'records' => ''
                    ])->setStatusCode(422);
                }
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Please check the product id.',
                    'records' => ''
                ])->setStatusCode(422);
            }
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Unauthorised',
                'errors' => ''
            ])->setStatusCode(422);
        }
    }

    public function getFaqs(Request $request){
        $cuser = $this->currentUser();

        if($cuser) {
            $content['faq'] = "Where does it come from?
Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of de Finibus Bonorum et Malorum (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, Lorem ipsum dolor sit amet.., comes from a line in section 1.10.32.";
            return response()->json([
                'success' => true,
                'message' => '',
                'records' => $content
            ])->setStatusCode(200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Unauthorised',
                'errors' => ''
            ])->setStatusCode(422);
        }
    }

    public function getSupport(Request $request){
        $cuser = $this->currentUser();

        if($cuser) {
            $content['support'] = "Where can I get some?
There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.";
            return response()->json([
                'success' => true,
                'message' => '',
                'records' => $content
            ])->setStatusCode(200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Unauthorised',
                'errors' => ''
            ])->setStatusCode(422);
        }
    }

    public function addToCart(Request $request){
        $cuser = $this->currentUser();

        if($cuser) {

        }else{
            return response()->json([
                'success' => false,
                'message' => 'Unauthorised',
                'errors' => ''
            ])->setStatusCode(422);
        }
    }
}
