						<div class="row rowMarginHalf colpad-half align-items-center justify-content-between">
	                        <div class="col-sm-6 col-md-9 col-lg-9 mb-4">
	                           
	                        </div>
	                        <div class="col-lg-3 d-flex  justify-content-end align-items-center col-sm-6 col-md-3 mb-4">
	                        	@if(!$customers->isEmpty())
	                           		<a href="{{route('admin/customers/export')}}/{{$type}}/{{$keyword}}" class="export-customer"><img src="{{asset('public/admin/assets/images/12_manage_customers_23.png')}}" class="img-fluid"> Export</a>
	                           	@endif
	                        </div>
	                     </div>
						<table class="table storetable">
                           <thead class="text-center">
                              <tr>
                                 <th scope="col">S.No.</th>
                                 <th scope="col">First Name</th>
                                 <th scope="col">Last Name </th>
                                 <th scope="col">Mobile Number</th>
                                 <th scope="col">Email address</th>
                                 <th scope="col">Order</th>
                                 <th scope="col">Action</th>
                              </tr>
                           </thead>
                           <tbody>
                           	  @if(!$customers->isEmpty())
                           	  	@php $i = 1; @endphp
                           	  	@foreach($customers as $customer)
	                              <tr>
	                                 <td>{{$i}}</td>
	                                 <td class="text-green">{{$customer->first_name}}</td>
	                                 <td class="text-green">{{$customer->last_name}}</td>
	                                 <td>{{$customer->country_code}} {{$customer->mobile_number}}</td>
	                                 <td>{{strtolower($customer->email)}}</td>
	                                 <td class="text-dark-green">0</td>
	                                 <td>
	                                    <div class="d-flex justify-content-center action  product-content">
	                                       {{-- <button class="btn"><img src="{{asset('public/admin/assets/images/2_manage_order_23.png')}}" class=""></button>  --}}
	                                       {{-- <button class="btn"><input type="checkbox" class="toggle" checked></button> --}}
	                                       <input type="checkbox" id="customSwitch{{$customer->id}}" class="toggle" onclick="changeStatus('users',{{$customer->id}},{{$customer->active}},'active','','1','{{route("admin/customers/list")}}/{{$type}}','customer-list')" value="{{$customer->active}}" @if($customer->active==1) checked @endif>
	                                    </div>
	                                 </td>
	                              </tr>
	                              @php $i++; @endphp
	                            @endforeach
                              @endif
                        </table>
                        @if($customers->isEmpty())
	                        <div class="col-sm-12">
	                           <h4 class="text-danger">No customers found</h4>
	                        </div>
                        @endif