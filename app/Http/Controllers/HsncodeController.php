<?php

namespace App\Http\Controllers;

use App\Hsncode;
use Illuminate\Http\Request;
use Validator;
use Session;

class HsncodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Hsncode::orderBy('id', 'DESC')->paginate(15);
        return view('admin.hsncode.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.hsncode.create');
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
            'hsncode' => 'required|unique:hsncodes',
            'wef_date' => 'required',
            'tax' => 'required',
            'status' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return redirect('admin/hsncode/create')
                ->withErrors($validator)
                ->withInput();
        }else{
            // store
            $newRecord = new Hsncode;
            $newRecord->hsncode = $request->get('hsncode');
            $newRecord->description = $request->get('description');
            $newRecord->wef_date = $request->get('wef_date');
            $newRecord->tax = $request->get('tax');
            $newRecord->additional_tax = $request->get('additional_tax') ? $request->get('additional_tax') : 0;
            $newRecord->status = $request->get('status');
            $newRecord->save();

            // redirect
            Session::flash('success', 'Successfully created the HSN code!');
            return redirect('admin/hsncode');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Hsncode  $hsncode
     * @return \Illuminate\Http\Response
     */
    public function show(Hsncode $hsncode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Hsncode  $hsncode
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'HSN Code - Edit';
        $record = Hsncode::find($id);

        return view('admin.hsncode.edit', compact('record', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Hsncode  $hsncode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = array(
            'hsncode' => 'required|unique:hsncodes,hsncode,'.$id,
            'wef_date' => 'required',
            'tax' => 'required',
            'status' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return redirect('admin/'.$id.'/hsncode')
                ->withErrors($validator)
                ->withInput();
        }else{
            // store
            $updRecord = Hsncode::find($id);
            $updRecord->hsncode = $request->get('hsncode');
            $updRecord->description = $request->get('description');
            $updRecord->wef_date = $request->get('wef_date');
            $updRecord->tax = $request->get('tax');
            $updRecord->additional_tax = $request->get('additional_tax') ? $request->get('additional_tax') : 0;
            $updRecord->status = $request->get('status');
            $updRecord->save();

            // redirect
            Session::flash('success', 'Successfully updated the hsn code!');
            return redirect('admin/hsncode');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Hsncode  $hsncode
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hsncode $hsncode)
    {
        //
    }
}
