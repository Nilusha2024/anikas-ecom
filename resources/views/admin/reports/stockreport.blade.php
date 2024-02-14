@extends('admin.layouts.master')
@section('title','Stock reports all products')
@section('body')
    <div class="box">
        <div class="box-header with-border">
            <div class="box-title">
                Stock Report
            </div>
        </div>

        <div class="box-body">

            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs" role="tablist" id="myTab">
    
                    <li role="presentation" class="active">
                        <a href="#variant_p" aria-controls="home" role="tab" data-toggle="tab">
                            <i class="fa fa-bars" aria-hidden="true"></i> {{ __("Variant Products") }}
                        </a>
                    </li>

                    <li role="presentation">
                        <a href="#simple_pro" aria-controls="home" role="tab" data-toggle="tab">
                            <i class="fa fa-bars" aria-hidden="true"></i> {{ __("Simple Products") }}
                        </a>
                    </li>
        
                  </ul>
    
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="variant_p">
                        <table style="width:100%;" id="stock_report_vp" class="table table-striped table-bordered">
                            <thead>
                                <th>#</th>
                                <th>Product name</th>
                                <th>Variant detail</th>
                                <th>Store name</th>
                                <th>Stock</th>
                            </thead>
                        </table>
                    </div>

                    <div role="tabpanel" class="tab-pane fade in" id="simple_pro">
                        <table style="width:100%;" id="stock_report_sp" class="table table-striped table-bordered">
                            <thead>
                                <th>#</th>
                                <th>Product name</th>
                                <th>Store name</th>
                                <th>Stock</th>
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
            var table = $('#stock_report_vp').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("admin.stock.report") }}',
                language: {
                    searchPlaceholder: "Search in reports..."
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable : false, orderable : false},
                    {data : 'product_name', name : 'products.name'},
                    {data : 'variant', name : 'variant'},
                    {data : 'store_name', name : 'products.store.name'},
                    {data : 'stock', name : 'add_sub_variants.stock'}
                ],
                dom : 'lBfrtip',
                buttons : [
                    'csv','excel','pdf','print','colvis'
                ],
                order : [[0,'DESC']]
            });
            
        });

        $(function () {
            "use strict";
            var table = $('#stock_report_sp').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("admin.stock.report.sp") }}',
                language: {
                    searchPlaceholder: "Search in reports..."
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable : false, orderable : false},
                    {data : 'product_name', name : 'simple_products.product_name'},
                    {data : 'store_name', name : 'store.name'},
                    {data : 'stock', name : 'simple_products.stock'}
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