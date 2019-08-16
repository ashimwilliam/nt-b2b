<?php

namespace App\Http\Controllers;

use App\Price;
use App\Product;
use Illuminate\Http\Request;
use Validator;
use Session;
use Illuminate\Support\Facades\File;
use App\Hsncode;
use App\Category;
use App\Subcategory;
use App\Brand;
use App\Color;
use App\Groupcolor;
use DB;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Product::with(['category', 'brand', 'hsncode', 'subcategory', 'prices'])->orderBy('id', 'DESC')->paginate(15);
        return view('admin.product.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hsncodes = Hsncode::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();
        $categories = Category::where('status', 1)->get();
        $subcategories = Subcategory::where('status', 1)->get();
        $groupcolors = Groupcolor::where('status', 1)->get();
        return view('admin.product.create', compact('hsncodes', 'brands', 'categories', 'subcategories', 'groupcolors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'sku_name' => 'required|unique:products',
            'hsncode_id' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'brand_id' => 'required',
            'groupcolor_id' => 'required',
            'mrp' => 'required',
            'image_1' => 'required|mimes:jpg,jpeg,bmp,png',
            'title' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            'status' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return redirect('admin/product/create')
                ->withErrors($validator)
                ->withInput();
        }else{
            // store
            $newRecord = new Product;
            $newRecord->sku_name = $request->get('sku_name');
            $newRecord->alias_name = $request->get('alias_name');
            $newRecord->sku_number = $request->get('sku_number');
            $newRecord->hsncode_id = $request->get('hsncode_id');
            $newRecord->category_id = $request->get('category_id');
            $newRecord->subcategory_id = $request->get('subcategory_id');
            $newRecord->brand_id = $request->get('brand_id');
            $newRecord->groupcolor_id = $request->get('groupcolor_id');
            $newRecord->weight = $request->get('weight');
            $newRecord->dimension = $request->get('dimension');
            $newRecord->mrp = $request->get('mrp');
            $newRecord->type_of_sale = $request->get('type_of_sale');
            $newRecord->description = $request->get('description');
            $newRecord->other_specifications = $request->get('other_specifications');
            $newRecord->any_cautions = $request->get('any_cautions');
            $newRecord->tags = $request->get('tags');
            $newRecord->image_1 = $this->uploadImage($request, 'product', 'image_1', '', '');
            if($request->image_2){
                $newRecord->image_2 = $this->uploadImage($request, 'product', 'image_2', '', '');
            }
            if($request->image_3){
                $newRecord->image_3 = $this->uploadImage($request, 'product', 'image_3', '', '');
            }
            if($request->image_4){
                $newRecord->image_4 = $this->uploadImage($request, 'product', 'image_4', '', '');
            }
            $newRecord->status = $request->get('status');
            $newRecord->save();

            //Insert/update manage prices
            $arrTitle = $request->title;
            $arrQuantity = $request->quantity;
            $arrPrice = $request->price;

            if($arrPrice && count($arrPrice) > 0){
                DB::table('prices')->where('product_id', $newRecord->id)->delete();

                foreach ($arrPrice as $key => $price){
                    $newPrice = new Price;
                    $newPrice->product_id = $newRecord->id;
                    $newPrice->title = $arrTitle[$key];
                    $newPrice->quantity = $arrQuantity[$key];
                    $newPrice->price = $arrPrice[$key];
                    $newPrice->save();
                }
            }

            // redirect
            Session::flash('success', 'Successfully created the record!');
            return redirect('admin/product');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Product - Edit';
        $record = Product::find($id);

        $hsncodes = Hsncode::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();
        $categories = Category::where('status', 1)->get();
        $subcategories = Subcategory::where('status', 1)->get();
        $groupcolors = Groupcolor::where('status', 1)->get();

        return view('admin.product.edit', compact('record', 'title', 'hsncodes', 'brands', 'categories', 'subcategories', 'groupcolors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = array(
            'sku_name' => 'required|unique:products,sku_name,'.$id,
            'hsncode_id' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'brand_id' => 'required',
            'groupcolor_id' => 'required',
            'mrp' => 'required',
            //'image_1' => 'required|mimes:jpg,jpeg,bmp,png',
            'title' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            'status' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return redirect('admin/'.$id.'/product')
                ->withErrors($validator)
                ->withInput();
        }else{
            $oldImage1 = $request->get('old_image_1');
            $oldImage2 = $request->get('old_image_2');
            $oldImage3 = $request->get('old_image_3');
            $oldImage4 = $request->get('old_image_4');

            // store
            $updRecord = Product::find($id);
            $updRecord->sku_name = $request->get('sku_name');
            $updRecord->alias_name = $request->get('alias_name');
            $updRecord->sku_number = $request->get('sku_number');
            $updRecord->hsncode_id = $request->get('hsncode_id');
            $updRecord->category_id = $request->get('category_id');
            $updRecord->subcategory_id = $request->get('subcategory_id');
            $updRecord->brand_id = $request->get('brand_id');
            $updRecord->groupcolor_id = $request->get('groupcolor_id');
            $updRecord->weight = $request->get('weight');
            $updRecord->dimension = $request->get('dimension');
            $updRecord->mrp = $request->get('mrp');
            $updRecord->type_of_sale = $request->get('type_of_sale');
            $updRecord->description = $request->get('description');
            $updRecord->other_specifications = $request->get('other_specifications');
            $updRecord->any_cautions = $request->get('any_cautions');
            $updRecord->tags = $request->get('tags');
            if($request->image_1) {
                $updRecord->image_1 = $this->uploadImage($request, 'product', 'image_1', $oldImage1, '1');
            }
            if($request->image_2){
                $updRecord->image_2 = $this->uploadImage($request, 'product', 'image_2', $oldImage2, '1');
            }
            if($request->image_3){
                $updRecord->image_3 = $this->uploadImage($request, 'product', 'image_3', $oldImage3, '1');
            }
            if($request->image_4){
                $updRecord->image_4 = $this->uploadImage($request, 'product', 'image_4', $oldImage4, '1');
            }
            $updRecord->status = $request->get('status');
            $updRecord->save();

            //Insert/update manage prices
            $arrTitle = $request->title;
            $arrQuantity = $request->quantity;
            $arrPrice = $request->price;

            if($arrPrice && count($arrPrice) > 0){
                DB::table('prices')->where('product_id', $id)->delete();

                foreach ($arrPrice as $key => $price){
                    $newPrice = new Price;
                    $newPrice->product_id = $id;
                    $newPrice->title = $arrTitle[$key];
                    $newPrice->quantity = $arrQuantity[$key];
                    $newPrice->price = $arrPrice[$key];
                    $newPrice->save();
                }
            }

            // redirect
            Session::flash('success', 'Successfully created the record!');
            return redirect('admin/product');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function getSubcategory(Request $request){
        $options = '<option value="">Select</option>';
        if(isset($request->catid) && $request->catid > 0){
            $records = Subcategory::where('category_id', $request->catid)->get();

            if($records){
                foreach ($records as $subcat){
                    $selected = '';
                    if($request->selected && $subcat->id == $request->selected){
                        $selected = 'selected="selected"';
                    }
                    $options .= '<option '.$selected.' value="'.$subcat->id.'">'.$subcat->title.'</option>';
                }
            }
            return response()->json([
               'success' => true,
               'data' => $records,
                'options' => $options
            ]);
        }else{
            return response()->json([
                'success' => false,
                'data' => '',
                'options' => $options
            ]);
        }
    }
}
