   <div class="table-responsive text-center table-brdr">
      <table class="table storetable">
         <thead class="text-center">
            <tr>
               <th scope="col">Order Id</th>
               <th scope="col">Product Names </th>
               <th scope="col">Total Items</th>
               <th scope="col">Date</th>
               <th scope="col">Time</th>
               <th scope="col">Amount</th>
               <th scope="col">Action</th>
            </tr>
         </thead>
         <tbody>
            @if(!$orders->isEmpty())
               @foreach($orders as $order)
                  <tr>
                     <td>{{$order->order_id_show}}</td>
                     <td>{{$order->product_name_str}}</td>
                     <td>{{$order->total_items}}</td>
                     <td>{{date('j M,Y',strtotime($order->created_at))}}</td>
                     <td>{{date('H:i A',strtotime($order->created_at))}}</td>
                     <td>$ {{$order->price}}</td>
                     <td>
                        <div class="d-flex justify-content-center action">
                           <button class="btn" onclick="orderDetails({{$order->id}})"><img src="{{asset('public/admin/assets/images/2_manage_order_26.png')}}" class=""></button> 
                           @if($order->status==0 || $order->status==1 || $order->status==2)
                              <button class="badge badge-info" onclick="changeProductStatus({{$order->id}},{{$order->status}})">
                                 @if($order->status==0)
                                    Move In Process
                                 @elseif($order->status==1)
                                    Move to Shipped
                                 @elseif($order->status==2) 
                                    Move to Completed
                                 @endif
                              </button>
                           @endif
                        </div>
                     </td>
                  </tr>
               @endforeach
            @endif
      </table>
      @if($orders->isEmpty())
         <div class="col-sm-12">
            <h4 class="text-danger">No orders found</h4>
         </div>
      @endif
   </div>