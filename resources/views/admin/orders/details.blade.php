<style type="text/css">
  .process-card{height: auto!important;}
</style>
           <div class="row">
             <div class="col-sm-12 col-md-12 mb-3">
                <div class="process-card">
                   <div class="order-card">
                      <span>Order Id: {{$order->order_id_show}}</span>
                      <span class="text-green">$ {{$order->price}}</span>
                   </div>
                   <h4>{{$order->product_name_str}}</h4>
                   <p>{{$order->total_items}} Items</p>
                   <p><img src="{{asset('public/website/img/date.png')}}"> {{date('j M, Y',strtotime($order->created_at))}} | {{date('H:i A',strtotime($order->created_at))}}</p>
                </div>
             </div>
             <div class="col-sm-12 col-md-12 mb-3">
                <h5>Items List</h5>
                @foreach($order->order_products as $product)
                  <div class="process-card mb-3">
                     <div class="order-card">
                        <span>Quantity: {{$product->quantity}} | Type: {{$product->quantity_option->name}}</span>
                        <span class="text-green">$ {{$product->cost-$product->discount}}</span>
                     </div>
                     <h4>{{$product->product->name}}</h4>
                  </div>
                @endforeach
             </div>
             <div class="col-sm-12 col-md-12">
                <h5>Delivery Address</h5>
                <div class="process-card">
                   <h4><img src="{{asset('public/website/img/11_myOrders_37.png')}}"> {{$order->user->first_name}}</h4>
                   <h4><img src="{{asset('public/website/img/11_myOrders_48.png')}}"> {{$order->order_address->country_code}} {{$order->order_address->mobile_number}}</h4>
                   <h4><img src="{{asset('public/website/img/11_myOrders_53.png')}}"> {{$order->order_address->address}} {{$order->order_address->street_name}} {{$order->order_address->apartment_name}} {{$order->order_address->residential_name}} {{$order->order_address->sector}}, Pincode - {{$order->order_address->area_code}}, {{$order->order_address->city_name}}, {{$order->order_address->country_name}}</h4>
                </div>
             </div>
          </div>