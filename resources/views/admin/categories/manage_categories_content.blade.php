                     @if(!$categories->isEmpty())
                        @foreach($categories as $list)
                           <div class="col-sm-4 col-6 col-md-3 col-lg-2 mb-3">
                              <div class="category-manage">
                                 <div class="action-option">
                                   <div class="dropdown">
                                       <img class="dropdown-toggle" data-toggle="dropdown" src="{{asset('public/admin/assets/images/7_manage_project_17.png')}}" style="margin-left: 5px;cursor: pointer;position: absolute;right: 0px;">
                                       <ul class="dropdown-menu" style="margin-left:0px;min-width: 150px!important;max-width: 150px!important;background: #fff!important;border:1px dashed #ccc;">
                                         <li><a onclick="editCategory({{$list->id}})"><i class="fa fa-pencil"></i> Edit</a></li>
                                         <li><a onclick="deleteRow('categories',{{$list->id}},'','Category','1','{{route("admin/categories/list")}}/{{$type}}','active-category .row')"><i class="fa fa-trash"></i> Delete</a></li>
                                       </ul>
                                   </div>
                                 </div>
                                 {{-- <div class="float-right">
                                    <img src="{{asset('public/admin/assets/images/7_manage_project_17.png')}}" data-toggle="dropdown" class="img-fluid" style="cursor: pointer;">
                                 </div>
                                 <div class="dropdown-menu">
                                     <a class="dropdown-item" href="#">Action</a>
                                     <a class="dropdown-item" href="#">Another action</a>
                                     <a class="dropdown-item" href="#">Something else here</a>
                                     <div class="dropdown-divider"></div>
                                     <a class="dropdown-item" href="#">Separated link</a>
                                   </div> --}}
                                 <div class="text-center">
                                    <img src="{{makeImageURL($list->icon)}}" class="img-fluid">
                                    <h6 title="{{$list->name}}">{{ucwords($list->name)}}</h6>
                                    <div class="product-content">
                                       <input type="checkbox" id="customSwitch{{$list->id}}" class="toggle" onclick="changeStatus('categories',{{$list->id}},{{$list->status}},'status','','1','{{route("admin/categories/list")}}/{{$type}}','active-category .row')" value="{{$list->status}}" @if($list->status==1) checked @endif>
                                       {{-- <label onclick="changeStatus('categories',{{$list->id}},{{$list->status}},'status','','1','{{route("admin/categories/list")}}/{{$type}}','active-category .row')" for="customSwitch{{$list->id}}"></label> --}}
                                    </div>
                                 </div>
                              </div>
                           </div>
                        @endforeach
                     @else
                        <div class="col-sm-12">
                           <h4 class="text-danger">No categories found</h4>
                        </div>
                     @endif

                     <script type="text/javascript">
                        
                     </script>
                        