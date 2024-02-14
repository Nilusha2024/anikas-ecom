@extends('admin.layouts.master')
@section('title','All Products | ')
@section('body')
<div class="box">
    <div class="box-header with-border">
        <div class="box-title">
            {{__("Create new product")}}
        </div>

        @can('products.import')
            <a data-toggle="modal" data-target="#importproductimages" class="pull-right btn btn-md btn-success">
                <i class="fa fa-file-excel-o"></i> {{__("Bulk import product images") }}
            </a>
        @endcan

        @can('products.create')
        
            <a href="{{ route("simple-products.create") }}" class="margin-right-8 pull-right btn btn-md btn-success">
                <i class="fa fa-plus"></i> {{__("Add new product") }}
            </a>

        @endcan

        @can('products.delete')
        
            <a href="{{ route("trash.simple.products") }}" class="margin-right-8 pull-right btn btn-md btn-danger">
                <i class="fa fa-trash"></i> {{__("Trash") }}
            </a>

        @endcan
    </div>

    <div class="box-body">
        <table style="width: 100%" id="d_products" class="table table-bordered table-striped">
            <thead>
                <th>#</th>
                <th>Product Image</th>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Product Pricing</th>
                <th>Product Status</th>
                <th>Action</th>
            </thead>
        </table>
    </div>

    <div id="importproductimages" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                    <h5 class="modal-title" id="my-modal-title">
                        <b>{{__("Bulk Import Simple Product Images")}}</b>
                    </h5>
                    
                </div>
                <div class="modal-body">
                    <a href="{{ url('files/SimpleProductImages.xlsx') }}" class="btn btn-md btn-success"> Download Example For xls/csv File</a>
						<hr>
						<form action="{{ route('simple.product.import.images') }}" method="POST" enctype="multipart/form-data">
							
                            @csrf
						
							<div class="row">
								<div class="form-group col-md-6">
									<label for="file">Choose your xls/csv File :</label>
									<input required="" type="file" name="file" class="form-control">
									@if ($errors->has('file'))
													<span class="invalid-feedback text-danger" role="alert">
														<strong>{{ $errors->first('file') }}</strong>
													</span>
									@endif
									<p></p>
									<button type="submit" class="btn btn-md bg-green">Import</button>
								</div>
								
							</div>
			
						</form>

                        <div class="box box-danger">
							<div class="box-header with-border">
								<div class="box-title">Instructions</div>
							</div>
					
							<div class="box-body">
								<p><b>Follow the instructions carefully before importing the file.</b></p>
								<p>The columns of the file should be in the following order.</p>
					
								<table class="table table-striped">
									<thead>
										<tr>
											<th>Column No</th>
											<th>Column Name</th>
                                            <th>Required</th>
											<th>Description</th>
										</tr>
									</thead>
					
									<tbody>
										<tr>
											<td>1</td>
											<td><b>product_id</b></td>
                                            <td><b>Yes</b></td>
											<td>Enter product id here</td>	
										</tr>

					
										<tr>
											<td>2</td>
											<td> <b>image</b> </td>
											<td><b>Yes</b></td>
											<td>Name your image eg: example.jpg <b>(Image must be already put in public/images/simple_products/gallery/) folder )</b> .</td>
										</tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
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
        var table = $('#d_products').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("simple-products.index") }}',
            language: {
                searchPlaceholder: "Search Products..."
            },
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable : false
                },
                {
                    data: 'image',
                    name: 'image',
                    searchable: false,
                    orderable : false
                },
                {
                    data: 'id',
                    name: 'simple_products.id'
                },
                {
                    data: 'product_name',
                    name: 'simple_products.product_name'
                },
                {
                    data: 'price',
                    name: 'simple_products.actual_selling_price'
                },
                {
                    data: 'status',
                    name: 'simple_products.status'
                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false,
                    orderable : false
                },
            ],
            dom: 'lBfrtip',
            buttons: [
                'csv', 'excel', 'pdf', 'print', 'colvis'
            ],
            order: [
                [0, 'DESC']
            ]
        });

    });
</script>
@endsection