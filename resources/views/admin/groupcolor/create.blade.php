@extends('layouts.admin')

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Create Group Color</h3>
                </div>
                <div class="pull-right">
                    <a href="{{ URL::to('admin/group-color')  }}">
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
                            {!! Form::open(array('url' => URL::to('admin/group-color'), 'method' => 'post', 'class'=>"form-horizontal form-label-left",'id'=>'frmAddGroupColor','files'=> true,'autocomplete'=>false)) !!}

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Title <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Description</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea id="description" name="description" class="form-control" rows="3" placeholder="description">{{ old('description') }}</textarea>
                                    </div>
                                </div>

                                {{--<div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="color_id">Colors <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" id="color_id" name="color_id[]" multiple>
                                            @if($colors && count($colors) > 0)
                                                @foreach($colors as $color)
                                                <option value="{{ $color->id }}">{{ $color->title }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>--}}

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="color_id">Colors <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        @if($colors && count($colors) > 0)
                                            <ul style="margin: 0px; padding: 0px;">
                                                @foreach($colors as $color)
                                                    <li style="list-style: none; float: left; width: 33%;"><div class="checkbox">
                                                            <input name="color_id[]" type="checkbox" class="flat" value="{{ $color->id }}"> {{ $color->title }}
                                                        </div></li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Status <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" id="status" name="status">
                                            <option value="1">Active</option>
                                            <option value="0">In-Active</option>
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

