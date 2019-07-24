@extends('layouts.admin')

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Edit HSN Code</h3>
                </div>
                <div class="pull-right">
                    <a href="{{ URL::to('admin/hsncode')  }}">
                        <button type="button" class="btn btn-success">Back</button>
                    </a>
                </div>
            </div>

            <div class="clearfix"></div>
            @include('partials.admin.message')

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">

                        <div class="x_content">
                            {!! Form::open(array('url' => URL::to('admin/hsncode/'.$record->id), 'method' => 'PUT', 'class'=>"form-horizontal form-label-left",'id'=>'frmEditHsncode','files'=> true,'autocomplete'=>false)) !!}

                            <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="hsncode">HSN Code <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="hsncode" name="hsncode" value="{{ $record->hsncode }}" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Description</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea id="description" name="description" class="form-control" rows="3" placeholder="description">{{ $record->description }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="wef_date">WEF Date <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class='input-group date' id='wefDatepicker'>
                                            <input type='text' id="wef_date" name="wef_date" value="{{ $record->wef_date }}" class="form-control"/>
                                            <span class="input-group-addon">
                                               <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tax">Tax (%) <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="tax" name="tax" value="{{ $record->tax }}" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="additional_tax">Additional Tax (%)</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="additional_tax" name="additional_tax" value="{{ $record->additional_tax }}" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Status <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" id="status" name="status">
                                            <option value="1" @if($record->status == 1) selected="selected" @endif>Active</option>
                                            <option value="0" @if($record->status == 0) selected="selected" @endif>In-Active</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="ln_solid"></div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">&nbsp;</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </div>

                            {!! Form::close() !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(function() {
            $('#wefDatepicker').datetimepicker({
                format: 'YYYY-MM-DD',
                ignoreReadonly: false,
                allowInputToggle: true,
                useCurrent: true
            });
        });
    </script>
@endsection

