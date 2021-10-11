                     @foreach($products as $list)
                        <div class="col-sm-6 col-md-4 col-lg-4 mb-3">
                           <div class="promo-product">
                              <div class="product-lst-promo">
                                 <div class="product-img">
                                    <img src="{{imageBaseURL().$list->images->path}}" class="img-fluid" style="max-height: 90px;max-width: 110px;">
                                 </div>
                                 <div class="product-content pl-2">
                                    <div class="product-title">
                                       <span>
                                          <h5>{{ucwords($list->name)}}</h5>
                                       </span>
                                       {{-- <span><i class="fa fa-ellipsis-v" aria-hidden="true"></i></span> --}}
                                    </div>
                                    <small>{{$list->costs[0]->quantity}} {{$list->costs[0]->quantity_option->name}}</small>
                                    <p>Category: {{$list->category->name}}</p>
                                    <p class="text-green">$ {{$list->costs[0]->cost}}</p>
                                    <div class="product-title">
                                       <span class="{{stockClass($list->costs[0]->available_stock)}}">Stock : {{$list->costs[0]->available_stock}}</span>
                                       {{-- <span><input type="checkbox" class="toggle"></span> --}}
                                       {{-- <input type="checkbox" id="customSwitch{{$list->id}}" class="toggle" onclick="changeStatus('products',{{$list->id}},{{$list->status}},'status','','1','{{route("admin/product/listing")}}/{{$type}}','active-product .row')" value="{{$list->status}}" @if($list->status==1) checked @endif> --}}
                                    </div>
                                 </div>
                              </div>
                              <hr>
                              <div class="per-but">
                                 <div class="col-sm-6 cost-block">
                                   <div class="input-container">
                                       <input type="number" step="any" class="form-control pl-5" placeholder="" id="pro-disc-{{$list->id}}" min="1" name="cost" value="@if($list->product_discount){{$list->product_discount->discount}}@endif" style="border: none;">
                                       <select class="number-code" id="pro-disc-type-{{$list->id}}">
                                          @if($list->product_discount)
                                           <option value="1" @if($list->product_discount->type==1) selected @endif>%</option>
                                           <option value="2" @if($list->product_discount->type==2) selected @endif>$</option>
                                         @else
                                          <option value="1">%</option>
                                          <option value="2">$</option>
                                         @endif
                                       </select>
                                       <img src="{{asset('public/admin/assets/images/7_manage_project_51.png')}}" class="slct-dwn">
                                    </div>
                                    <span class="help-block text-danger"></span>
                                 </div>
                                 <div class="col-sm-4">
                                    <span><button class="add-edit-offer" onclick="saveProductDisc({{$list->id}})" style="margin-top: 7px;">Save</button></span>
                                 </div>
                                 @if($list->product_discount)
                                   <div class="col-sm-2">
                                      <span><button class="add-edit-offer" onclick="deleteRow('product_discounts',{{$list->product_discount->id}},'','Product Discount','1','{{route("admin/manage_promotions/products")}}/{{$type}}','products')" style="margin-top: 7px;background: #de1313;margin-left: -7px;">X</button></span>
                                   </div>
                                 @endif
                              </div>
                              {{-- <div class="per-but">
                                 <span>
                                    <div class="input-container">
                                       <select class="offer-code">
                                          <option>%</option>
                                       </select>
                                       <span class="text-grey">Discount</span>
                                       <img src="{{asset('public/admin/assets/images/12_manage_customers_57.png')}}" class="slct-crt">
                                    </div>
                                 </span>
                                 <span><button class="add-edit-offer">Add</button></span>
                              </div> --}}
                           </div>
                        </div>
                     @endforeach

                     <script type="text/javascript">
                        function saveProductDisc(product_id){
                           let v = $(`#pro-disc-${product_id}`).val(),
                               type = $(`#pro-disc-type-${product_id}`).val();
                           $.ajax({
                                url: "{{route('admin/discount/save_product')}}", 
                                type: "post",
                                headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
                                data: {"product_id": product_id, "product_discount":v, "type":type},
                                success: function(data){
                                    Swal.fire('', data.errorMsg, 'info');
                                    if(data.errorCode=='3'){
                                       setTimeout(function(){
                                          location.reload();
                                       },1000);
                                    }
                                }
                            });
                        }
                     </script>