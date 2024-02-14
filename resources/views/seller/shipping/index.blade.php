@extends('admin.layouts.sellermaster')
@section('title',__("Available Shipping Methods"))
@section('body')
<div class="box">
	<div class="box-header with-border">
		<div class="box-title">
			
			{{__("Available Shipping Methods")}}

		</div>
	
	</div>

	<div class="box-body">
		<div class="row">
			@foreach($shippings as $shipping)
				@if($shipping->name != 'UPS Shipping')
					<div class="col-md-6">
						<div class="box box-solid">
							<div class="box-header with-border">
								<div class="box-title">
									{{ $shipping['name'] }} 

									@if($shipping['default_status'] == '1')
										<span class="badge badge-primary">
											{{__("Default")}}
										</span>
									@endif
								</div>
							</div>
							<div class="box-body text-center">
								@if($shipping->name != 'Free Shipping' && $shipping->name != 'Shipping Price')
									<h5>
										<b>Price: </b>&nbsp;
										<i class="fa {{ $defCurrency->currency_symbol }}"></i>
										{{ $shipping['price']}}
										<br><br>
										<p><i class="fa fa-info-circle"></i> {{__("Price Can be changed by admin.") }}</p>
										@if($shipping->name == 'Local Pickup')
											<p><i class="fa fa-info-circle"></i> {{ __("Localpick up will choosen by user at time of order review.") }}</p>
										@endif
										@if($shipping->name == 'Flat Rate')
											<p><i class="fa fa-info-circle"></i> {{ __('Any item shipped with this method means global shipping charge will apply on all products.') }}</p>
										@endif
									</h5>
								@endif

								@if($shipping->name == 'Free Shipping')
									<h5>
										<p>
											{{__("Free Shipping not need any price changes when item is shipped  with this method there is no shipping charge will apply.")}}
										</p>
									</h5>
								@endif

								@if($shipping->name == 'Shipping Price')
									<h5>
										{{__("Shipping Price mean Shipping price by weight")}}
									</h5>

									<div class="box-footer">
										<a class="pointer" data-toggle="modal" data-target="#shippingweightinfo">
											{{__("View more here shipping price by weight")}}
										</a>
									</div>
								@endif
							</div>
						</div>
					</div>
				@endif
			@endforeach	
		</div>
	</div>

	<!-- Shipping weight Modal -->
	<div class="modal fade" id="shippingweightinfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">
				{{__("Shipping Weight Price")}}
			</h4>
	      </div>
	      <div class="modal-body">
	        <h5>
	        	<i class="fa fa-info-circle"></i> {{ __("Shipping Price is available in two methods and from given weight to given weight eg. 0 kg to 10kg given price is applied") }}</b>.
	        	<br><br>
	        	<ul>
	        		<li>
	        			{{__("Per Order")}}
	        		</li>
	        		<li>
	        			{{__("Per Quanity")}}
	        		</li>
	        	</ul>
				
	        	<table class="table table-bordered table-striped">
	        		<thead>
	        			<th>
	        				{{__("Weight From")}}
	        			</th>
	        			<th>
	        				{{__("Weight To")}}
	        			</th>
	        			<th>
	        				{{__("Price")}}
	        			</th>
	        			<th>
	        				{{__("Apply On")}}
	        			</th>
	        		</thead>

	        		<tbody>
	        			<tr>
	        				<td>
	        					{{ $sw->weight_from_0 }}
	        				</td>
	        				<td>
	        					{{ $sw->weight_to_0 }}
	        				</td>
	        				<td>
	        					<i class="fa {{ $defCurrency->currency_symbol }}"></i> {{ $sw->weight_price_0 }}
	        				</td>
	        				<td>
	        					@if($sw->per_oq_0 == 'po')
								{{__("Per Order")}}
	        					@else
								{{__("Per Quanity")}}
	        					@endif
	        				</td>


	        			</tr>

	        			<tr>
	        				<td>
	        					{{ $sw->weight_from_1 }}
	        				</td>
	        				<td>
	        					{{ $sw->weight_to_1 }}
	        				</td>
	        				<td>
	        					<i class="fa {{ $defCurrency->currency_symbol }}"></i> {{ $sw->weight_price_1 }}
	        				</td>
	        				<td>
	        					@if($sw->per_oq_1 == 'po')
								{{__("Per Order")}}
	        					@else
								{{__("Per Quanity")}}
	        					@endif
	        				</td>
	        			</tr>

	        			<tr>
	        				<td>
	        					{{ $sw->weight_from_2 }}
	        				</td>
	        				<td>
	        					{{ $sw->weight_to_2 }}
	        				</td>
	        				<td>
	        					<i class="fa {{ $defCurrency->currency_symbol }}"></i> {{ $sw->weight_price_2 }}
	        				</td>
	        				<td>
	        					@if($sw->per_oq_2 == 'po')
								{{__("Per Order")}}
	        					@else
								{{__("Per Quanity")}}
	        					@endif
	        				</td>
	        			</tr>

	        			<tr>
	        				<td>
	        					{{ $sw->weight_from_3 }}
	        				</td>
	        				<td>
	        					{{ $sw->weight_to_3 }}
	        				</td>
	        				<td>
	        					<i class="fa {{ $defCurrency->currency_symbol }}"></i> {{ $sw->weight_price_3 }}
	        				</td>
	        				<td>
	        					@if($sw->per_oq_3 == 'po')
								{{__("Per Order")}}
	        					@else
								{{__("Per Quanity")}}
	        					@endif
	        				</td>
	        			</tr>

	        			<tr>
	        				<td>
	        					{{ $sw->weight_from_4 }}
	        				</td>
	        				<td>
	        					-
	        				</td>
	        				<td>
	        					<i class="fa {{ $defCurrency->currency_symbol }}"></i> {{ $sw->weight_price_4 }}
	        				</td>
	        				<td>
	        					@if($sw->per_oq_4 == 'po')
								{{__("Per Order")}}
	        					@else
								{{__("Per Quanity")}}
	        					@endif
	        				</td>
	        			</tr>
	        		</tbody>
	        	</table>
	        </h5> 
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">
				{{__("Close")}}
			</button>
	      </div>
	    </div>
	  </div>
	</div>
</div>
@endsection