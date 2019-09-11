@extends('layouts.admin')

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Create Main Category</h3>
                </div>
                <div class="pull-right">
                    <a href="{{ URL::to('admin/category')  }}">
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
                            {!! Form::open(array('url' => URL::to('admin/subcategory'), 'method' => 'post', 'class'=>"form-horizontal form-label-left",'id'=>'frmAddSubCategory','files'=> true,'autocomplete'=>false)) !!}

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_id">Category <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" id="category_id" name="category_id">
                                            <option value="">Select Category</option>
                                            @if($category && count($category) > 0)
                                                @foreach($category as $cat)
                                                    <option value="{{ $cat->id }}" {{ (Request::old("category_id") == $cat->id ? "selected":"") }}>{{ $cat->title }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

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

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">Image
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="file" name="image" id="image" value="{{ old('image') }}" class="form-control col-md-7 col-xs-12" />
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

