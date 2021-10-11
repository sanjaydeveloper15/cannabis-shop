<style type="text/css">
   .product-img img{max-height: 100px;max-width: 100px;}
</style>
                  @if(!$products->isEmpty())
                     @foreach($products as $list)
                        <div class="col-sm-6 col-md-4 col-lg-4 mb-3">
                           <div class="product-lst">
                              <div class="product-img">
                                 <img src="{{imageBaseURL().$list->image}}" class="img-fluid" style="height: 78px;width: 78px;">
                              </div>

                              <div class="product-content pl-2">
                                 <div class="action-option">
                                   <div class="dropdown">
                                       <img class="dropdown-toggle" data-toggle="dropdown" src="{{asset('public/admin/assets/images/7_manage_project_17.png')}}" style="margin-left: 5px;cursor: pointer;position: absolute;right: 0px;">
                                       <ul class="dropdown-menu" style="margin-left:0px;min-width: 150px!important;max-width: 150px!important;background: #fff!important;border:1px dashed #ccc;">
                                         <li><a href="{{route('admin/corresponding_products',['type'=>'edit'])}}/{{$list->id}}"><i class="fa fa-pencil"></i> Edit</a></li>
                                       </ul>
                                   </div>
                                 </div>
                                 <div class="product-title">
                                    <span>
                                       <h5>{{ucwords($list->name)}}</h5>
                                    </span>
                                 </div>
                                 <p class="text-green">Cost $ {{$list->cost}} @if($list->product_id_show!='') | Product ID {{$list->product_id_show}} @endif</p>
                                 <div class="product-title">
                                    <input type="checkbox" id="customSwitch{{$list->id}}" class="toggle" onclick="changeStatus('corresponding_products',{{$list->id}},{{$list->status}},'status','','1','{{route("admin/corresponding_product/listing")}}/{{$type}}','active-product .row')" value="{{$list->status}}" @if($list->status==1) checked @endif>
                                 </div>
                              </div>
                           </div>
                        </div>
                     @endforeach
                  @else
                     <div class="col-sm-12">
                        <h4 class="text-danger">No products found</h4>
                     </div>
                  @endif