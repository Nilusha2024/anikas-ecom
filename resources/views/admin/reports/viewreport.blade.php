@extends('admin.layouts.master')
@section('title','Most viewed products')
@section('body')
    <div class="box">
        <div class="box-header with-border">
            <div class="box-title">
                Most viewed products
            </div>
        </div>

        <div class="box-body">

            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs" role="tablist" id="myTab">
    
                    <li role="presentation" class="active">
                        <a href="#variant_p" aria-controls="variant_p" role="tab" data-toggle="tab">
                            <i class="fa fa-eye" aria-hidden="true"></i> {{ __("Variant Products") }}
                        </a>
                    </li>

                    <li role="presentation">
                        <a href="#simple_pro" aria-controls="simple_pro" role="tab" data-toggle="tab">
                            <i class="fa fa-eye" aria-hidden="true"></i> {{ __("Simple Products") }}
                        </a>
                    </li>
        
                </ul>

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="variant_p">
                        <table style="width: 100%;" id="most_viewed_vp" class="table table-striped table-bordered">
                            <thead>
                                <th>#</th>
                                <th>Product name</th>
                                <th>Total views</th>
                            </thead>
                        </table>
                    </div>

                    <div role="tabpanel" class="tab-pane fade in" id="simple_pro">
                        <table style="width: 100%;" id="most_viewed_sp" class="table table-striped table-bordered">
                            <thead>
                                <th>#</th>
                                <th>Product name</th>
                                <th>Total views</th>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>

            
        </div>
    </div>
@endsection
@section('custom-script')
    <script>
        $(function () {
            "use strict";
            var most_viewed_vp = $('#most_viewed_vp').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("admin.report.mostviewed") }}',
                language: {
                    searchPlaceholder: "Search in reports..."
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable : false, orderable : false},
                    {data : 'product_name', name : 'name'},
                    {data : 'views', name : 'views'}
                ],
                dom : 'lBfrtip',
                buttons : [
                    'csv','excel','pdf','print','colvis'
                ],
                order : [[0,'DESC']]
            });
            
       
            var most_viewed_vp = $('#most_viewed_sp').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("admin.report.mostviewed.sp") }}',
                language: {
                    searchPlaceholder: "Search in reports..."
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable : false, orderable : false},
                    {data : 'product_name', name : 'simple_products.product_name'},
                    {data : 'views', name : 'views'}
                ],
                dom : 'lBfrtip',
                buttons : [
                    'csv','excel','pdf','print','colvis'
                ],
                order : [[0,'DESC']]
            });
            
        });
    </script>
@endsection