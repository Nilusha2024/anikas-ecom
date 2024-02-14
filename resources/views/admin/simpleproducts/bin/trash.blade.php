@extends(!in_array('Seller',auth()->user()->getRoleNames()->toArray()) ? "admin.layouts.master" : "admin.layouts.sellermaster")
@section('title','Trashed Simple Products |')
@section("body")
    <div class="box">
        <div class="box-header with-border">
            <div class="box-title">
                {{__("Trashed Simple Products")}}
            </div>
        </div>

        <div class="box-body">
            <table id="productTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product Name</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('custom-script')
    <script>
        $(function () {

            "use strict";

            var table = $('#productTable').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                stateSave: true,
                ajax: "{{ route('trash.simple.products') }}",
                language: {
                    searchPlaceholder: "Search trashed simple products..."
                },
                columns: [
                    
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable : false, orderable : false},
                    {data : 'name', name : 'simple_products.product_name'},
                    {data : 'status', name : 'simple_products.status',searchable : false},
                    {data : 'action', name : 'action', searchable : false,orderable : false}

                ],
                dom : 'lBfrtip',
                buttons : [
                    'csv','excel','pdf','print','colvis'
                ],
                order : [
                    [0,'DESC']
                ]
            });

            });
    </script>
@endsection