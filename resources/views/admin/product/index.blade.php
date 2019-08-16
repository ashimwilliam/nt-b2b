@extends('layouts.admin')

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>List Product</h3>
                </div>
                <div class="pull-right">
                    <a href="{{ URL::to('admin/product/create')  }}">
                        <button type="button" class="btn btn-success">Create New Record</button>
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">

                            <div class="table-responsive">
                                <table class="table table-striped jambo_table bulk_action">
                                    <thead>
                                    <tr class="headings">
                                        <th class="column-title">Name</th>
                                        <th class="column-title">SKU</th>
                                        <th class="column-title">Image</th>
                                        <th class="column-title">HSN Code</th>
                                        <th class="column-title">Category</th>
                                        <th class="column-title">Sub Category</th>
                                        <th class="column-title">Brand</th>
                                        <th class="column-title">Status </th>
                                        <th class="column-title no-link last"><span class="nobr">Action</span>
                                        </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @if($records && count($records) > 0)
                                        @foreach($records as $item)
                                        <tr class="even pointer">
                                            <td class=" ">{{ $item->sku_name }}</td>
                                            <td class=" ">{{ $item->sku_number }}</td>
                                            <td class=" ">
                                                @if($item->image_1 != 0)
                                                    <img src="{{ asset('uploads/product/'.$item->image_1) }}" width="50" style="" />
                                                @endif
                                            </td>
                                            <td class=" ">{{ $item->hsncode->hsncode }}</td>
                                            <td class=" ">{{ $item->category->title }}</td>
                                            <td class=" ">{{ $item->subcategory->title }}</td>
                                            <td class=" ">{{ $item->brand->title }}</td>
                                            <td class="a-right a-right ">
                                                @if($item->status == 1)
                                                    <span class="label label-success">Active</span>
                                                @else
                                                    <span class="label label-danger">In-Active</span>
                                                @endif
                                            </td>
                                            <td class=" last"><a href="{{ URL::to('admin/product/'.$item->id).'/edit' }}">Edit</a></td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr class="even pointer">
                                            <td colspan="9">No record found.</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                                {{ $records->links() }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
