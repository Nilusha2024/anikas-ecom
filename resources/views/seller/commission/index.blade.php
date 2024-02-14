@extends("admin/layouts.sellermaster")
@section('title','Commission Setting | ')
@section("body")
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">
              {{__("Commission Setting (Applied by admin)")}}
            </h3>
          </div>
              <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>{{ __("ID") }}</th>
                    <th> {{__("Category")}} </th>
                    <th> {{__("Rate")}} </th>
                    <th> {{__("Amount Type")}} </th>
                    <th> {{__("Commision Type")}} </th>

                  </tr>
                </thead>
                <tbody>
                  @foreach($commissions as $key => $commission)
                  @if($commission->type=='flat')
                  <tr>
                  <td>{{ ++$key }}</td>
                  <td>{{$commission->category->title ?? __('All')}}</td>
                  
                   <td>{{$commission->rate ?? ''}}</td>
                  <td> 
                    @if($commission->p_type == 'p')
								      {{__('Percentage')}}
					         @else($commission->p_type == 'f')
                      {{__('Fix Amount')}}
                   
						        @endif
    							</td>
                  <td>
                    @if($commission->type == 'c')
                          {{__('Category')}}
                      @else
                          {{__('Flat For All')}}
                    @endif
                  </td>
                  
                  </tr>
                  @else
                  @foreach(App\Commission::get() as $key => $commission)
                  
                  <tr>
                  <td>{{$key + 1}}</td>
                  <td>{{$commission->category->title ?? ''}}</td>
                  
                  <td>{{$commission->rate ?? ''}}</td>
                  <td> 
                    @if($commission->type == 'p')
                      {{__('Percentage')}}
                   @else
                      {{ __('Fix Amount') }}
                    
                    @endif
                  </td>
                  <td>
                    @if($commission->type == 'flat')
                         {{ __('Flat For All') }}
                      @else
                          {{ __('Category') }}
                    @endif
                  </td>
                  
                  </tr>
                  
                  @endforeach
                  @endif
                  @endforeach
                  
                  </tbody>
                </table>
            
              </div>
              <!-- /.box-body -->
            </div>
         
@endsection
