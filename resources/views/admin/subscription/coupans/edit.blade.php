@extends("admin/layouts.master")
@section('title',__("Edit Voucher |"))
@section("body")
 <div class="col-md-8">
    <div class="box">
    
    <div class="box-header with-border">
      <div class="box-title">
          {{__("Edit Voucher : $voucher->code ")}}
      </div>
    </div>
 <form action="{{ route('subscription-vouchers.update',$voucher->id) }}" method="POST">
    @csrf
    @method("PUT")
    <div class="box-body">
         
        <div class="form-group">
          <label> {{__("Voucher code:")}} <span class="required">*</span></label>
          <input required="" type="text" class="form-control" name="code" value="{{ $voucher->code }}">
        </div>
        <div class="form-group">
          <label> {{__("Discount type:")}} <span class="required">*</span></label>
          
            <select required name="distype" id="distype" class="form-control">
              
              <option {{ $voucher->distype == 'fix' ? "selected" : "" }} value="fix">
                  {{__('Fixed')}}
              </option>
              <option {{ $voucher->distype == 'per' ? "selected" : "" }} value="per">
                  {{__("% Percentage")}}
              </option>
              
            </select>
          
        </div>
        <div class="form-group">
            <label> {{__("Discount apply type:")}} <span class="required">*</span></label>
            
              <select required="" name="dis_applytype" id="dis_applytype" class="form-control">
                
                <option {{ $voucher->dis_applytype == 'fixed' ? "selected" : "" }} value="fixed"> {{__("Fixed Discount")}} </option>
                <option {{ $voucher->dis_applytype == 'upto' ? "selected" : "" }} value="upto"> {{__("Up to")}} </option>
                
              </select>
            
          </div>
        <div class="form-group">
            <label> {{__("Amount:")}} <span class="required">*</span></label>
            <input required="" type="text"  class="form-control" name="amount" value="{{ $voucher->amount }}">
          
        </div>
        <div class="form-group">
          <label> {{{__("Linked to:")}}} <span class="required">*</span></label>
          
            <select required="" name="link_by" id="link_by" class="form-control">
                
                <option {{ $voucher->link_by == 'allplans' ? "selected" : "" }} value="allplans">
                    {{__("Applicable on all plans")}}
                </option>
                <option {{ $voucher->link_by == 'linktoplan' ? "selected" : "" }} value="linktoplan">
                    {{__("Link to Plan")}}
                </option>
              
            </select>
          
        </div>
        
        <div id="plans"  class="{{ $voucher->link_by == 'allplans' ? 'display-none' : "" }} form-group">
          <label> {{__("Select Plan:")}} <span class="required">*</span> </label>
          <br>
          <select name="plan_id" class="select2 form-control">
              @foreach(App\SellerPlans::where('status','1')->get() as $plan)
               
                <option {{ $voucher->plan_id == $plan->id ? "selected" : "" }} value="{{ $plan->id }}">{{ $plan['name'] }}</option>
               
              @endforeach
          </select>
        </div>

        <div class="form-group">
          <label> {{__("Max Usage Limit: ")}} <span class="required">*</span></label>
          <input value="{{ $voucher->maxusage }}" required="" type="number" min="1" class="form-control" name="maxusage">
        </div>
        
        
         <div class="form-group">
          <label> {{__("Expiry Date:")}} </label>
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            <input value="{{ date('Y-m-d',strtotime($voucher->expirydate)) }}" required="" id="expirydate" type="text" class="form-control" name="expirydate">
          </div>
        </div>

        <div class="form-group">
          <label> {{ __("Status :") }} </label>
          <br>
          <label class="switch">
            <input id="status" type="checkbox" name="status"
              {{ $voucher->status == 1 ? "checked" : "" }}>
            <span class="knob"></span>
          </label>
        </div>
        
     
    </div>

    <div class="box-footer">
      <button type="submit" class="btn btn-md bg-blue btn-flat">
        <i class="fa fa-save"></i> {{__("Save")}}
      </button>
    </form>
      <a href="{{ route('subscription-vouchers.index') }}" title="Cancel and go back" class="btn btn-md btn-default btn-flat">
        <i class="fa fa-reply"></i> {{__("Back")}}
      </a>
    </div>
  </div>       
 </div>
@endsection
@section('custom-script')
 <script>
     "use Strict";

      $("#link_by").on('change',function(){

        var val = $("#link_by").val();

        if(val == 'linktoplan' ){

            $('#plans').show();

        }else{

            $('#plans').hide();

        } 


      });

 </script>
@endsection