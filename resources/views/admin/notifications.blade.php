@include('admin.inc.header')

<div class="admin-panel">
   <div class="container-fluid px-0">
      <div class="row no-gutters">
         @include('admin.inc.sidebar')
         <article class="col-lg-9">
            <header class="p-3">
               <div class="row rowMarginHalf colpad-half align-items-center justify-content-between">
                  <div class="col-sm-6 col-md-8 col-lg-8">
                     <div class="form-group flex-grow-1 mb-0">
                        <div class="custom-group-input pill left-icon">
                           <input type="text" name="" id="keyword" class="form-control " placeholder="Search Device Types">
                           <span class="group-icon-left"><img src="{{asset('public/admin/assets/images/2_manage_order_16.png')}}" class="img-fluid srch"></span>
                        </div>
                     </div>
                  </div>
                  @include('admin.inc.top_right_header')
               </div>
            </header>
            <div class="article-body store-bd-gy">
            	@if(!$notifications->isEmpty())
					<div class="notification-canvas">
						<ul>
							@foreach($notifications as $list)
								<li>
									@if($list->viewed==0)
							        	<span><img src="{{asset('public/admin/assets/images/notificaton_active.png')}}"></span>
							        @else
							        	<span><img src="{{asset('public/admin/assets/images/notificaiton_inactive.png')}}"></span>
							        @endif
							        <a class="pointer" style="color: #000;" href="{{route('admin/manage_orders')}}/{{$list->obj_id}}/{{$list->id}}">&nbsp;{{$list->message}}</a>
							        <span>{{date("j M, H:i A",strtotime($list->created_at))}}</span>
							    </li>
					    	@endforeach
						</ul>
					</div>
				@else
					<h5>No notifications found!</h5>
				@endif
            </div>
         </article>
      </div>
   </div>
</div>



@include('admin.inc.footer')