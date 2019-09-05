<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Groupcolor;
use App\Product;
use Illuminate\Http\Request;
use Validator;
use Session;
use Illuminate\Support\Facades\File;

class BannerController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Banner::orderBy('id', 'DESC')->paginate(15);
        return view('admin.banner.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::where('status', 1)->get();
        return view('admin.banner.create', compact('products'));
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
            'title' => 'required|unique:banners',
            'slug' => 'required|unique:banners',
            'status' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return redirect('admin/banner/create')
                ->withErrors($validator)
                ->withInput();
        }else{
            // store
            $newRecord = new Banner;
            $newRecord->title = $request->get('title');
            $newRecord->slug = $request->get('slug');
            $newRecord->description = $request->get('description');
            //$browseField = $request->get('image');
            $newRecord->image = $this->uploadImage($request, 'banner', 'image', '', '');
            $newRecord->status = $request->get('status');
            $newRecord->save();

            $newGC = Banner::find($newRecord->id);
            $newGC->products()->attach($request->product_id);

            // redirect
            Session::flash('success', 'Successfully created the record!');
            return redirect('admin/banner');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Banner - Edit';
        $record = Banner::find($id);
        $products = Product::where('status', 1)->get();

        return view('admin.banner.edit', compact('record', 'title', 'products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $oldImage = $request->get('old_image');
        $rules = array(
            'title' => 'required|unique:banners,title,'.$id,
            'slug' => 'required|unique:banners,slug,'.$id,
            'status' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return redirect('admin/'.$id.'/banner')
                ->withErrors($validator)
                ->withInput();
        }else{
            // store
            $updRecord = Banner::find($id);
            $updRecord->title = $request->get('title');
            $updRecord->slug = $request->get('slug');
            $updRecord->description = $request->get('description');
            if($request->image) {
                $updRecord->shade_img = $this->uploadImage($request, 'banner', 'image', $oldImage, '1');
            }
            $updRecord->status = $request->get('status');
            $updRecord->save();

            $updGC = Banner::find($id);
            $updGC->products()->sync($request->product_id);

            // redirect
            Session::flash('success', 'Successfully updated the banner!');
            return redirect('admin/banner');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        //
    }
}
