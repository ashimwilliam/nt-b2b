<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Validator;
use Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Category::orderBy('id', 'DESC')->paginate(15);
        return view('admin.category.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
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
            'title' => 'required|unique:categories',
            'status' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return redirect('admin/category/create')
                ->withErrors($validator)
                ->withInput();
        }else{
            // store
            $newRecord = new Category;
            $newRecord->title = $request->get('title');
            $newRecord->description = $request->get('description');
            $newRecord->slug = $this->createSlug($request->get('title'));
            $newRecord->status = $request->get('status');
            $newRecord->save();

            // redirect
            Session::flash('success', 'Successfully created the category!');
            return redirect('admin/category');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Category - Edit';
        $record = Category::find($id);

        return view('admin.category.edit', compact('record', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = array(
            'title' => 'required|unique:categories,title,'.$id,
            'status' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return redirect('admin/'.$id.'/category')
                ->withErrors($validator)
                ->withInput();
        }else{
            // store
            $updRecord = Category::find($id);
            $updRecord->title = $request->get('title');
            $updRecord->description = $request->get('description');
            $updRecord->slug = $this->createSlug($request->get('title'));
            $updRecord->status = $request->get('status');
            $updRecord->save();

            // redirect
            Session::flash('success', 'Successfully updated the category!');
            return redirect('admin/category');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }

    public function createSlug($str){
        $search = array(' ', '~', '`', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '+', '=');
        $replace = array('-', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
        return str_replace($search, $replace, strtolower($str));
    }
}
