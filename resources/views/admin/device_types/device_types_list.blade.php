                     @if(!$device_types->isEmpty())
                        @foreach($device_types as $list)
                           <div class="col-sm-4 col-6 col-md-4 col-lg-3 mb-3">
                              <div class="category-manage">
                                 <div class="action-option">
                                   <div class="dropdown">
                                       <img class="dropdown-toggle" data-toggle="dropdown" src="{{asset('public/admin/assets/images/7_manage_project_17.png')}}" style="margin-left: 5px;cursor: pointer;position: absolute;right: 0px;">
                                       <ul class="dropdown-menu" style="margin-left:0px;min-width: 150px!important;max-width: 150px!important;background: #fff!important;border:1px dashed #ccc;">
                                         <li><a onclick="editDeviceType({{$list->id}})"><i class="fa fa-pencil"></i> Edit</a></li>
                                         <li><a onclick="deleteRow('device_types',{{$list->id}},'','device type','1','{{route("admin/device_types/list")}}/{{$type}}','active-devicetype .row')"><i class="fa fa-trash"></i> Delete</a></li>
                                       </ul>
                                   </div>
                                 </div>
                                 <div class="text-center">
                                    <h5>{{ucwords($list->name)}}</h5>
                                    <div class="product-content">
                                       <input type="checkbox" id="customSwitch{{$list->id}}" class="toggle" onclick="changeStatus('device_types',{{$list->id}},{{$list->status}},'status','','1','{{route("admin/device_types/list")}}/{{$type}}','active-devicetype .row')" value="{{$list->status}}" @if($list->status==1) checked @endif>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        @endforeach
                     @else
                        <div class="col-sm-12">
                           <h4 class="text-danger">No device types found</h4>
                        </div>
                     @endif
