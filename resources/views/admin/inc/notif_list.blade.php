	@if(!$notifications->isEmpty())
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
    @else
    	<li>No notifications found</li>
    @endif
   