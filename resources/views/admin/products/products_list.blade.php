<style type="text/css">
   .product-img img{max-height: 100px;max-width: 100px;}
</style>
                  @if(!$products->isEmpty())
                     @foreach($products as $list)
                        <div class="col-sm-6 col-md-4 col-lg-4 mb-3">
                           <div class="product-lst">
                              <div class="product-img">
                                 <img src="{{imageBaseURL().$list->images->path}}" class="img-fluid">
                              </div>

                              <div class="product-content pl-2">
                                 <div class="action-option">
                                   <div class="dropdown">
                                       <img class="dropdown-toggle" data-toggle="dropdown" src="{{asset('public/admin/assets/images/7_manage_project_17.png')}}" style="margin-left: 5px;cursor: pointer;position: absolute;right: -5px;">
                                       <ul class="dropdown-menu" style="margin-left:0px;min-width: 150px!important;max-width: 150px!important;background: #fff!important;border:1px dashed #ccc;">
                                         <li><a href="{{route('admin/products',['type'=>'edit'])}}/{{$list->id}}"><i class="fa fa-pencil"></i> Edit</a></li>
                                       </ul>
                                   </div>
                                 </div>
                                 <div class="product-title">
                                    <span>
                                       <h5 class="pointer" onClick="productDetail({{$list->id}})">{{ucwords($list->name)}}</h5>
                                    </span>
                                    <!-- <span><i class="fa fa-ellipsis-v" aria-hidden="true"></i></span> -->
                                 </div>
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

                  <script type="text/javascript">
                     function productDetail(id){
                        window.location.href = `{{route('admin/product_details')}}/${id}`;
                     }
                  </script>