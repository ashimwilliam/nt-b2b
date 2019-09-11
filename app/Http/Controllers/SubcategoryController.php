<?php

namespace App\Http\Controllers;

use App\Subcategory;
use App\Category;
use Illuminate\Http\Request;
use Validator;
use Session;

class SubcategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Subcategory::with('category')->orderBy('id', 'DESC')->paginate(15);
        return view('admin.subcategory.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::where('status', 1)->get();
        return view('admin.subcategory.create', compact('category'));
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
            'category_id' => 'required',
            'title' => 'required|unique:subcategories',
            'status' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return redirect('admin/subcategory/create')
                ->withErrors($validator)
                ->withInput();
        }else{
            // store
            $newRecord = new Subcategory;
            $newRecord->category_id = $request->get('category_id');
            $newRecord->title = $request->get('title');
            $newRecord->description = $request->get('description');
            $newRecord->image = $this->uploadImage($request, 'subcategory', 'image', '', '');
            $newRecord->slug = $this->createSlug($request->get('title'));
            $newRecord->status = $request->get('status');
            $newRecord->save();

            // redirect
            Session::flash('success', 'Successfully created the subcategory!');
            return redirect('admin/subcategory');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function show(Subcategory $subcategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Category - Edit';
        $record = Subcategory::with('category')->find($id);
        $category = Category::where('status', 1)->get();

        return view('admin.subcategory.edit', compact('record', 'title', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $oldImage = $request->get('old_image');
        $rules = array(
            'category_id' => 'required',
            'title' => 'required|unique:subcategories,title,'.$id,
            'status' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return redirect('admin/'.$id.'/subcategory')
                ->withErrors($validator)
                ->withInput();
        }else {
            // store
            $updRecord = Subcategory::find($id);
            $updRecord->category_id = $request->get('category_id');
            $updRecord->title = $request->get('title');
            $updRecord->description = $request->get('description');
            if($request->image) {
                $updRecord->image = $this->uploadImage($request, 'subcategory', 'image', $oldImage, '1');
            }
            $updRecord->slug = $this->createSlug($request->get('title'));
            $updRecord->status = $request->get('status');
            $updRecord->save();

            // redirect
            Session::flash('success', 'Successfully updated the subcategory!');
            return redirect('admin/subcategory');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subcategory $subcategory)
    {
        //
    }

    public function createSlug($str){
        $search = array(' ', '~', '`', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '+', '=');
        $replace = array('-', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
        return str_replace($search, $replace, strtolower($str));
    }
}
