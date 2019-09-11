<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\Request;
use Validator;
use Session;

class BrandController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Brand::orderBy('id', 'DESC')->paginate(15);
        return view('admin.brand.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.brand.create');
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
            'title' => 'required|unique:brands',
            'status' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return redirect('admin/brand/create')
                ->withErrors($validator)
                ->withInput();
        }else{
            // store
            $newRecord = new Brand;
            $newRecord->title = $request->get('title');
            $newRecord->description = $request->get('description');
            $newRecord->image = $this->uploadImage($request, 'brand', 'image', '', '');
            $newRecord->slug = $this->createSlug($request->get('title'));
            $newRecord->status = $request->get('status');
            $newRecord->save();

            // redirect
            Session::flash('success', 'Successfully created the brand!');
            return redirect('admin/brand');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Brand - Edit';
        $record = Brand::find($id);

        return view('admin.brand.edit', compact('record', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $oldImage = $request->get('old_image');
        $rules = array(
            'title' => 'required|unique:brands,title,'.$id,
            'status' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return redirect('admin/'.$id.'/brand')
                ->withErrors($validator)
                ->withInput();
        }else{
            // store
            $updRecord = Brand::find($id);
            $updRecord->title = $request->get('title');
            $updRecord->description = $request->get('description');
            if($request->image) {
                $updRecord->image = $this->uploadImage($request, 'brand', 'image', $oldImage, '1');
            }
            $updRecord->slug = $this->createSlug($request->get('title'));
            $updRecord->status = $request->get('status');
            $updRecord->save();

            // redirect
            Session::flash('success', 'Successfully updated the brand!');
            return redirect('admin/brand');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        //
    }

    public function createSlug($str){
        $search = array(' ', '~', '`', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '+', '=');
        $replace = array('-', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
        return str_replace($search, $replace, strtolower($str));
    }
}
