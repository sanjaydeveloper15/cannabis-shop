				@if(!$area_codes->isEmpty())
					@foreach($area_codes as $list)
	                    <div class="col-sm-4 col-6 col-md-2 col-lg-2 mb-3">
	                        <div class="area-manage">
	                           <span>{{$list->area_code}}</span>
	                           <a class="pointer" onclick="deleteRow('area_zips',{{$list->id}},'','Area Code','1','{{route("admin/area_codes/list")}}','manageArea .row')"><img src="{{asset('public/admin/assets/images/12_manage_customers_42.png')}}" class="area-close"></a>
	                        </div>
	                    </div>
                    @endforeach
                @else
                	<h4 class="text-danger">No area codes found!</h4>
                @endif