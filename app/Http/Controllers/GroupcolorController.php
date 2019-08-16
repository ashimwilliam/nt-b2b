<?php

namespace App\Http\Controllers;

use App\Groupcolor;
use Illuminate\Http\Request;
use Validator;
use Session;
use App\Color;

class GroupcolorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Groupcolor::with('colors')->orderBy('id', 'DESC')->paginate(10);
        return view('admin.groupcolor.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $colors = Color::where('status', 1)->get();
        return view('admin.groupcolor.create', compact('colors'));
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
            'title' => 'required|unique:groupcolors',
            'color_id' => 'required',
            'status' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return redirect('admin/group-color/create')
                ->withErrors($validator)
                ->withInput();
        }else{
            // store
            $newRecord = new Groupcolor;
            $newRecord->title = $request->get('title');
            $newRecord->description = $request->get('description');
            $newRecord->status = $request->get('status');
            $newRecord->save();

            $newGC = Groupcolor::find($newRecord->id);
            $newGC->colors()->attach($request->color_id);

            // redirect
            Session::flash('success', 'Successfully created the record!');
            return redirect('admin/group-color');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Groupcolor  $groupcolor
     * @return \Illuminate\Http\Response
     */
    public function show(Groupcolor $groupcolor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Groupcolor  $groupcolor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Group Color - Edit';
        $record = Groupcolor::with('colors')->find($id);
        $colors = Color::where('status', 1)->get();
        $selectedColors = $record->colors->pluck('id')->toArray();

        return view('admin.groupcolor.edit', compact('record', 'title', 'colors', 'selectedColors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Groupcolor  $groupcolor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = array(
            'title' => 'required|unique:colors,title,'.$id,
            'color_id' => 'required',
            'status' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return redirect('admin/'.$id.'/group-color')
                ->withErrors($validator)
                ->withInput();
        }else{
            // store
            $updRecord = Groupcolor::find($id);
            $updRecord->title = $request->get('title');
            $updRecord->description = $request->get('description');
            $updRecord->status = $request->get('status');
            $updRecord->save();

            $updGC = Groupcolor::find($id);
            $updGC->colors()->sync($request->color_id);

            // redirect
            Session::flash('success', 'Successfully updated the color!');
            return redirect('admin/group-color');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Groupcolor  $groupcolor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Groupcolor $groupcolor)
    {
        //
    }
}
