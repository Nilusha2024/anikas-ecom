@extends("admin.layouts.master")
@section('title',"Shipping Item : $inv_cus->prefix$invoice->inv_no$inv_cus->postfix | ")
@section("body")
    
    <div class="row">
        <div class="col-md-8">
            <div class="box box-danger">
                <div class="box-header with-border">
            
                    <div class="box-title">
                        <a title="Go Back" href="{{ route('admin.order.edit',$invoice->order->order_id) }}" class="btn btn-md btn-default"><i class="fa fa-reply"
                                aria-hidden="true"></i>
                        </a> 
                        @if($invoice->variant)
                            {{ __("Shipping Item :") }} {{ $invoice->variant->products->name }} ({{ variantname($invoice->variant) }})  {{ '#'.$inv_cus->prefix.$invoice->inv_no.$inv_cus->postfix }}
                        @endif

                        @if($invoice->simple_product)
                        {{ __("Shipping Item :") }} {{ $invoice->simple_product->product_name }}  {{ '#'.$inv_cus->prefix.$invoice->inv_no.$inv_cus->postfix }}
                        @endif
                    </div>
            
                    
                </div>
            
                <div class="box-body">
                    <form action="{{ route("ship.item",$invoice->id) }}" method="POST">
                        @csrf
            
                        <div class="form-group">
                            
                            <label>
                                {{__("Courier Channel:")}} <span class="text-red">*</span>
                            </label>
                            <input required placeholder="DHL" name="courier_channel" type="text" class="form-control" value="{{ $invoice->courier_channel }}"/>
                               
                        </div>

                        <div class="form-group">
                            <label>
                                {{__("Courier tracking link OR Consignment No:")}} <span class="text-red">*</span>
                            </label>

                            <input required placeholder="2132500" name="tracking_link" type="text" class="form-control" value="{{ $invoice->tracking_link }}"/>

                        </div>

                        <div class="form-group">
                            <label>
                                {{__("Expected Delivery date:")}} <span class="text-red">*</span>
                            </label>

                            <input required placeholder="{{ now()->addDays(7)->format('d-M-Y') }}" name="exp_delivery_date" type="text" class="deliverydate form-control" value="{{ date("Y-m-d",strtotime($invoice->exp_delivery_date)) }}"/>

                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-md btn-success">
                                <i class="fa fa-plane"></i> {{__("Ship")}}
                            </button>
                        </div>
                        
            
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('custom-script')
    <script>
        $(".deliverydate").datepicker({
            dateFormat: "yy-mm-dd",
            minDate : "{{ date('Y-m-d',strtotime($invoice->created_at)) }}"
        });
    </script>
@endsection