@extends('admin.layouts.sellermaster')
@section('title',__("Available Brands").' | ')
@section('body')
	<div class="box">
		<div class="box-header with-border">
			<div class="box-title">
				{{ __("Available Brands") }}
			</div>
			<a data-target="#requestbrand" data-toggle="modal" class="pull-right btn btn-md btn-flat bg-olive">
				<i class="fa fa-arrow-right" aria-hidden="true"></i>
				{{__("Request New Brand")}}
				</a>
		</div>
		<div class="box-body">
			
			<table id="brandTable" class="table table-striped table-bordered">
				
				<thead>
					<th>#</th>
					<th>{{ __("Brand Logo") }}</th>
					<th>{{ __("Brand Name") }}</th>
					<th>{{ __("Status") }}</th>
				</thead>

				<tbody>
					
				</tbody>
			</table>
		</div>
	</div>


@endsection

<!-- Modal -->
<div class="modal fade" id="requestbrand" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">{{__("Request New Brand")}}</h4>
      </div>
      <div class="modal-body">
       	<form action="{{ route('request.brand.store') }}" method="POST" enctype="multipart/form-data">
       		@csrf
       		
       		<div class="form-group">
       			<label>{{__("Brand Name")}}: <span class="required">*</span></label>
       			<input required="" name="name" type="text" class="form-control" placeholder="Enter brand name">
       		</div>

       		<div class="form-group">
       			<label for="">{{__("Brand Logo")}}: <span class="required">*</span></label>
       			<input required="" type="file" name="image" class="form-control">
       		</div>

       		<div class="form-group">
       			<label>{{__("Categories")}}: <span class="required">*</span></label>
       			<select style="width: 100%" required="" class="form-control select2" multiple="multiple" name="category_id[]" id="category_id">
       				@foreach(App\Category::where('status','=','1')->get() as $cat)
       					<option value="{{ $cat->id }}">{{ $cat->title }}</option>
       				@endforeach
       			</select>
       			<p class="help-block">({{__("Select categories for brand availability")}})</p>
       		</div>

       		<div class="form-group">
       			<label for="">{{__("Brand Proof")}}:</label>
       			<input type="file" name="brand_proof" class="form-control">
       			<p class="help-block">({{__("Required if you submitting your own brand")}})</p>
       		</div>

       		<button type="submit" class="btn btn-md btn-flat bg-blue"><i class="fa fa-arrow-right"></i> {{__("Request") }}</button>

       		
       	</form>
      </div>
     
    </div>
  </div>
</div>

@section('custom-script')
  <script>var url = {!! json_encode( route('seller.brand.index') ) !!};</script>
  <script src="{{ url('js/seller/sellerbrand.js') }}"></script>
@endsection