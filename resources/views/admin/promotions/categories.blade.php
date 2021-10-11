                        <div class="col-sm-12">
                           <div class="navx">
                              <ul class="nav nav-tabs">
                                 @foreach($categories as $list)
                                    <li class="offer-cate">
                                       <div class="d-flex justify-content-end product-content">
                                          {{-- <span><input type="checkbox" class="toggle" checked></span> --}}
                                          {{-- <span><img src="{{asset('public/admin/assets/images/7_manage_project_17.png')}}" class="img-fluid pl-3"></span> --}}
                                       </div>
                                       <div><img src="{{makeImageURL($list->icon)}}" class="img-fluid category-img"> {{ucwords($list->name)}}</div>
                                       <hr>
                                       <div class="per-but">
                                          <div class="col-sm-6 cost-block">
                                            <div class="input-container">
                                                <input type="text" step="any" class="form-control pl-5" placeholder="" id="cat-disc-{{$list->id}}" name="cost" value="@if($list->category_discount){{$list->category_discount->discount}}@endif" style="border: none;">
                                                <select class="number-code" id="cat-disc-type-{{$list->id}}">
                                                  @if($list->category_discount)
                                                    <option value="1" @if($list->category_discount->type==1) selected @endif>%</option>
                                                    <option value="2" @if($list->category_discount->type==2) selected @endif>$</option>
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
                                             <span><button class="add-edit-offer" onclick="saveCatDisc({{$list->id}})" style="margin-top: 7px;">Save</button></span>
                                          </div>
                                          @if($list->category_discount)
                                            <div class="col-sm-2">
                                               <span><button onclick="deleteRow('category_discounts',{{$list->category_discount->id}},'','Category Discount','0','{{route("admin/manage_promotions/categories")}}/{{$type}}','categories')" class="add-edit-offer" style="margin-top: 7px;background: #de1313;margin-left: -7px;">X</button></span>
                                            </div>
                                          @endif
                                          {{-- <span>
                                             <div class="input-container">
                                                <select class="offer-code">
                                                   <option>%</option>
                                                </select>
                                                <span class="text-grey">Discount</span>
                                                <img src="{{asset('public/admin/assets/images/12_manage_customers_57.png')}}" class="slct-crt">
                                             </div>
                                          </span> --}}
                                          
                                       </div>
                                    </li>
                                 @endforeach
                              </ul>
                           </div>
                        </div>

                        <script type="text/javascript">
                           function saveCatDisc(cat_id){
                              let v = $(`#cat-disc-${cat_id}`).val(),
                                  type = $(`#cat-disc-type-${cat_id}`).val();
                              $.ajax({
                                   url: "{{route('admin/discount/save_cat')}}", 
                                   type: "post",
                                   headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
                                   data: {"cat_id": cat_id, "category_discount":v, "type":type},
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