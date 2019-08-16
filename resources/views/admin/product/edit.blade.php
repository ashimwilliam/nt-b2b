@extends('layouts.admin')

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Edit Product</h3>
                </div>
                <div class="pull-right">
                    <a href="{{ URL::to('admin/product')  }}">
                        <button type="button" class="btn btn-success">Back</button>
                    </a>
                </div>
            </div>

            <div class="clearfix"></div>
            @include('partials.admin.message')

            {!! Form::open(array('url' => URL::to('admin/product/'.$record->id), 'method' => 'PUT', 'class'=>"form-horizontal form-label-left",'id'=>'frmEdirProduct','files'=> true,'autocomplete'=>false)) !!}
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">

                        <div class="x_content">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="alias_name">SKU Name</label>
                                    <input type="text" class="form-control" value="{{ $record->sku_name }}" name="sku_name" id="sku_name" placeholder="Product name">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="alias_name">Alias Name</label>
                                    <input type="text" class="form-control" value="{{ $record->alias_name }}" name="alias_name" id="alias_name" placeholder="Alias Name">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="sku_number">SKU Number</label>
                                    <input type="text" class="form-control" value="{{ $record->sku_number }}" name="sku_number" id="sku_number" placeholder="SKU Number">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="description">Manage Price</label>

                                    <table id="myTable" class=" table order-list" style="margin-bottom:0px;">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @if($record->prices && count($record->prices) > 0)
                                            @foreach($record->prices as $price)
                                            <tr>
                                                <td class="col-sm-4" style="border-top:0px">
                                                    <input value="{{ $price->title }}" type="text" name="title[]" class="form-control" />
                                                </td>
                                                <td class="col-sm-4" style="border-top:0px">
                                                    <input value="{{ $price->quantity }}" type="text" name="quantity[]"  class="form-control"/>
                                                </td>
                                                <td class="col-sm-4" style="border-top:0px">
                                                    <input value="{{ $price->price }}" type="text" name="price[]"  class="form-control"/>
                                                </td>
                                                <td><input type="button" class="ibtnDel btn btn-md btn-danger" value="Delete"></td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4" class="col-sm-4" style="border-top:0px; color:red;">
                                                    No record found.
                                                </td>
                                            </tr>
                                        @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th style="padding:0px;">&nbsp;</th>
                                                <th style="padding:0px;">&nbsp;</th>
                                                <th style="padding:0px;">&nbsp;</th>
                                                <th style="padding:0px;">&nbsp;</th>
                                            </tr>
                                            <tr>
                                                <td style="text-align: left; border-top:0px">
                                                    <input type="button" class="btn-primary btn-sm btn-block " id="addrow" value="Add Row" />
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>

                                </div>

                                <div class="clearfix"></div>
                                <div class="ln_solid"></div>

                                <div class="form-group col-md-4">
                                    <label for="hsncode_id">HSN Code</label>
                                    <select class="form-control" id="hsncode_id" name="hsncode_id">
                                        <option value="">Select</option>
                                        @if(count($hsncodes) > 0)
                                            @foreach($hsncodes as $hsn)
                                                <option value="{{ $hsn->id }}" {{ ($record->hsncode_id == $hsn->id ? "selected":"") }}>{{ $hsn->hsncode }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="category_id">Category</label>
                                    <select class="form-control" id="category_id" name="category_id">
                                        <option value="">Select</option>
                                        @if(count($categories) > 0)
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}" {{ ($record->category_id == $cat->id ? "selected":"") }}>{{ $cat->title }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="subcategory_id">Subcategory</label>
                                    <select class="form-control" id="subcategory_id" name="subcategory_id">
                                        <option value="">Select</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="brand_id">Brand</label>
                                    <select class="form-control" id="brand_id" name="brand_id">
                                        <option value="">Select</option>
                                        @if(count($brands) > 0)
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}" {{ ($record->brand_id == $brand->id ? "selected":"") }}>{{ $brand->title }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="groupcolor_id">Color Group</label>
                                    <select class="form-control" id="groupcolor_id" name="groupcolor_id">
                                        <option value="">Select</option>
                                        @if(count($groupcolors) > 0)
                                            @foreach($groupcolors as $grpcolor)
                                                <option value="{{ $grpcolor->id }}" {{ ($record->groupcolor_id == $grpcolor->id ? "selected":"") }}>{{ $grpcolor->title }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="clearfix"></div>
                                <div class="ln_solid"></div>

                                <div class="form-group col-md-4">
                                    <label for="weight">Weight</label>
                                    <input type="text" class="form-control" value="{{ $record->weight }}" name="weight" id="weight" placeholder="Weight">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="dimension">Dimension</label>
                                    <input type="text" class="form-control" value="{{ $record->dimension }}" name="dimension" id="dimension" placeholder="Dimension">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="mrp">MRP</label>
                                    <input type="text" class="form-control" value="{{ $record->mrp }}" name="mrp" id="mrp" placeholder="MRP">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="type_of_sale">Type Of Sale</label>
                                    <select class="form-control" id="type_of_sale" name="type_of_sale">
                                        <option value="1">Active</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <div class="form-group col-sm-10">
                                        <label for="image_1">Image 1</label>
                                        <input type="file" class="form-control" name="image_1" id="image_1">
                                    </div>
                                    <div class="form-group col-sm-2">
                                        @if($record->image_1 != 0)
                                            <img src="{{ asset('uploads/product/'.$record->image_1) }}" width="50" style="margin-top: 10px;" />
                                        @endif
                                        <input type="hidden" name="old_image_1" value="{{ $record->image_1 }}" />
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <div class="form-group col-sm-10">
                                        <label for="image_2">Image 2</label>
                                        <input type="file" class="form-control" name="image_2" id="image_2">
                                    </div>
                                    <div class="form-group col-sm-2">
                                        @if($record->image_2 != 0)
                                            <img src="{{ asset('uploads/product/'.$record->image_2) }}" width="50" style="margin-top: 10px;" />
                                        @endif
                                        <input type="hidden" name="old_image_2" value="{{ $record->image_2 }}" />
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <div class="form-group col-sm-10">
                                        <label for="image_3">Image 3</label>
                                        <input type="file" class="form-control" name="image_3" id="image_3">
                                    </div>
                                    <div class="form-group col-sm-2">
                                        @if($record->image_3 != 0)
                                            <img src="{{ asset('uploads/product/'.$record->image_3) }}" width="50" style="margin-top: 10px;" />
                                        @endif
                                        <input type="hidden" name="old_image_2" value="{{ $record->image_3 }}" />
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <div class="form-group col-sm-10">
                                        <label for="image_4">Image 4</label>
                                        <input type="file" class="form-control" name="image_4" id="image_4">
                                    </div>
                                    <div class="form-group col-sm-2">
                                        @if($record->image_4 != 0)
                                            <img src="{{ asset('uploads/product/'.$record->image_4) }}" width="50" style="margin-top: 10px;" />
                                        @endif
                                        <input type="hidden" name="old_image_4" value="{{ $record->image_4 }}" />
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="1" @if($record->status == 1) selected="selected" @endif>Active</option>
                                        <option value="0" @if($record->status == 0) selected="selected" @endif>In-Active</option>
                                    </select>
                                </div>

                                <div class="clearfix"></div>
                                <div class="ln_solid"></div>

                                <div class="form-group col-md-6">
                                    <label for="description">Description</label>
                                    <textarea rows="5" id="description" name="description" class="form-control">{{ $record->description }}</textarea>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="other_specifications">Other Specifications</label>
                                    <textarea rows="5" id="other_specifications" name="other_specifications" class="form-control">{{ $record->other_specifications }}</textarea>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="any_cautions">Any Cautions</label>
                                    <textarea style="height: 100px;" id="any_cautions" name="any_cautions" class="form-control">{{ $record->any_cautions }}</textarea>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="tags">Tags</label>
                                    <input id="tags_1" name="tags" type="text" style="height: 150px;" class="tags form-control" value="{{ $record->tags }}" />
                                    <div id="suggestions-container" style="position: relative; float: left; width: 250px; margin: 10px;"></div>
                                </div>

                                <div class="clearfix"></div>
                                <div class="ln_solid"></div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection

@section('scripts')
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>
    <script>
        //$('textarea').ckeditor();
        $('#description').ckeditor(); // if class is prefered.
        $('#other_specifications').ckeditor(); // if class is prefered.
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            var counter = 0;

            $("#addrow").on("click", function () {
                var newRow = $("<tr>");
                var cols = "";

                cols += '<td><input type="text" class="form-control" name="title[]' + counter + '"/></td>';
                cols += '<td><input type="text" class="form-control" name="quantity[]' + counter + '"/></td>';
                cols += '<td><input type="text" class="form-control" name="price[]' + counter + '"/></td>';

                cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';
                newRow.append(cols);
                $("table.order-list").append(newRow);
                counter++;
            });

            $("table.order-list").on("click", ".ibtnDel", function (event) {
                $(this).closest("tr").remove();
                counter -= 1
            });

            $('#category_id').change(function(e){
                var catid = $(this).val();
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('/admin/product/get-sub-category/') }}",
                    method: 'GET',
                    data: {
                        catid: catid, selected: '<?php echo $record->subcategory_id; ?>'
                    },
                    success: function(result){
                        console.log(result);
                        $('#subcategory_id').html(result.options);
                    }
                });
            });

            @if($record->category_id)
            $('#category_id').trigger('change');
            @endif;
        });

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

