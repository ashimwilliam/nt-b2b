@extends('layouts.admin')

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>List HSN Code</h3>
                </div>
                <div class="pull-right">
                    <a href="{{ URL::to('admin/hsncode/create')  }}">
                        <button type="button" class="btn btn-success">Create HSN Code</button>
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
                                        <th class="column-title">HSN Code</th>
                                        <th class="column-title">Description</th>
                                        <th class="column-title">wef Date</th>
                                        <th class="column-title">Tax %</th>
                                        <th class="column-title">Other Tax %</th>
                                        <th class="column-title">Status </th>
                                        <th class="column-title no-link last"><span class="nobr">Action</span>
                                        </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @if($records)
                                        @if($records && count($records) > 0)
                                        <tr class="even pointer">
                                            <td class=" ">{{ $item->hsncode }}</td>
                                            <td class=" ">{{ $item->description }}</td>
                                            <td class=" ">{{ $item->wef_date }}</td>
                                            <td class=" ">{{ $item->tax }}</td>
                                            <td class=" ">{{ $item->additional_tax }}</td>
                                            <td class="a-right a-right ">
                                                @if($item->status == 1)
                                                    <span class="label label-success">Active</span>
                                                @else
                                                    <span class="label label-danger">In-Active</span>
                                                @endif
                                            </td>
                                            <td class=" last"><a href="{{ URL::to('admin/hsncode/'.$item->id).'/edit' }}">Edit</a></td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr class="even pointer">
                                            <td colspan="7">No record found.</td>
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