<?php

namespace App\Http\Controllers;

use App\Color;
use Illuminate\Http\Request;
use Validator;
use Session;
use Illuminate\Support\Facades\File;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Color::orderBy('id', 'DESC')->paginate(15);
        return view('admin.color.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.color.create');
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
            'title' => 'required|unique:colors',
            'status' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return redirect('admin/color/create')
                ->withErrors($validator)
                ->withInput();
        }else{
            // store
            $newRecord = new Color;
            $newRecord->title = $request->get('title');
            $newRecord->description = $request->get('description');
            //$browseField = $request->get('image');
            $newRecord->shade_img = $this->uploadImage($request, 'color', 'shade_img', '', '');
            $newRecord->color_code = $request->get('color_code');
            $newRecord->status = $request->get('status');
            $newRecord->save();

            // redirect
            Session::flash('success', 'Successfully created the record!');
            return redirect('admin/color');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Color - Edit';
        $record = Color::find($id);

        return view('admin.color.edit', compact('record', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $oldImage = $request->get('old_image');
        $rules = array(
            'title' => 'required|unique:colors,title,'.$id,
            'status' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return redirect('admin/'.$id.'/color')
                ->withErrors($validator)
                ->withInput();
        }else{
            // store
            $updRecord = Color::find($id);
            $updRecord->title = $request->get('title');
            $updRecord->description = $request->get('description');
            if($request->shade_img) {
                $updRecord->shade_img = $this->uploadImage($request, 'color', 'shade_img', $oldImage, '1');
            }
            $updRecord->color_code = $request->get('color_code');
            $updRecord->status = $request->get('status');
            $updRecord->save();

            // redirect
            Session::flash('success', 'Successfully updated the color!');
            return redirect('admin/color');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function destroy(Color $color)
    {
        //
    }

    public function uploadImage($request, $dir = '', $fieldName = '', $oldImgName = '', $flag_update = '') {
        if(!empty($dir) && !empty($fieldName)){

            if (!File::exists("uploads/" . $dir)) {
                $folderForFiles = File::makeDirectory("uploads/" . $dir, $mode = 0777, true, true);
            }

            $destinationPath = public_path() . "/uploads/" . $dir;
            $file = $request->file($fieldName);

            if (!empty($file)) {

                // Delete the old image
                if ($flag_update == 1) {
                    if (!empty($request->get($oldImgName))) {
                        File::Delete($destinationPath . $request->get($oldImgName));
                    }
                }

                $fileExtension = $file->getClientOriginalExtension();
                //$filename = date('d-m-Y+H-i-s') . str_replace(" ", "_", $file->getClientOriginalName());
                $filename = time().".".$fileExtension;
                $filedata = $file->move($destinationPath, $filename);

                if ($filedata) {
                    return $filename;
                }
            }else if($flag_update == 1){
                return $oldImgName;
            }else{}
        }
        return false;
    }
}
