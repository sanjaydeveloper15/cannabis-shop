@include('admin.inc.header')
<style type="text/css">
	.input-text{color: #999!important;}
	.new-product, .setting-page{max-width: 720px!important;}
	.cat-pic{height: 112px;width: 112px;border-radius: 50%;}
	.plus-btn{background: #b8d042;color: #fff!important;padding: 10px 10px;border-radius: 50%;margin-top: 29px;}
	.cross-btn{background: red;color: #fff!important;padding: 10px 10px;border-radius: 50%;margin-top: 29px;}
	.text-danger{margin-bottom: 5px;}
</style>
<div class="admin-panel">
   <div class="container-fluid px-0">
      <div class="row no-gutters">
         <!-- Sidebar  -->
         @include('admin.inc.sidebar')
         <article class="col-lg-9">
            <header class="p-3">
               <div class="row rowMarginHalf colpad-half align-items-center justify-content-between">
                  <div class="col-sm-12 col-md-12 col-lg-12">
                  </div>
               </div>
            </header>
            <div class="article-body store-bd-gy">
               <div class="row rowMarginHalf colpad-half align-items-center justify-content-between">
                  <div class="col-sm-12 col-md-12 col-lg-12">
                     <div class="add-new-product">
                        <a href="{{route('admin/manage_products')}}"><img src="{{asset('public/admin/assets/images/7_manage_project_06.png')}}" class="img-fluid"></a>
                        <span>
                           <h5>{{$title}}</h5>
                        </span>
                        <a href="{{route('admin/logout')}}"><img src="{{asset('public/admin/assets/images/2_manage_order_07.png')}}" class="img-fluid filter" style="cursor: pointer;"></a>
                     </div>
                  </div>
                  <div class="col-sm-12 col-md-12 col-lg-12">
                     <div class="new-product">
                        <form class="row" id="product-form">
                        	<p class="alert" id="alert-msg" style="display: none;width: 100%;"></p>
                        	
                        	<div class="col-sm-12 text-center new-product image-block">
		                        <div class="upload-btn-wrapper">
		                           <img src="{{imageBaseURL().$product->images->path}}" class="img-fluid cat-pic">
		                           <input type="file" class="upload-file" name="image" accept="image/*" />
		                        </div><br>
		                        <span class="help-block text-danger"></span>
		                    </div>
                           	
                           	<div class="form-group col-sm-6 category-block">
                              	<div class="input-container new-product-input mb-2">
                									<span class="input-text">Category</span><br>
                									<select class="cate-type" name="category">
                										<option value="">{{$product->category->name}}</option>
                									</select>
                									<img src="{{asset('public/admin/assets/images/7_manage_project_56.png')}}" class="input-img-log"> 
                 									<img src="{{asset('public/admin/assets/images/7_manage_project_58.png')}}" class="input-img-down"> 
                              	</div>
                              	<span class="help-block text-danger"></span>
                           	</div>

                           <div class="form-group col-sm-6 strain_type-block">
                              <div class="input-container new-product-input mb-2">
                                 <span class="input-text">Stain Type</span><br>
                                 <select class="cate-type" name="strain_type">
                                    <option value="">{{$product->strain_type->name}}</option>
                                 </select>
                                 <img src="{{asset('public/admin/assets/images/7_manage_project_56.png')}}" class="input-img-log"> 
                                 <img src="{{asset('public/admin/assets/images/7_manage_project_58.png')}}" class="input-img-down"> 
                              </div>
                              <span class="help-block text-danger"></span>
                           </div>

                           <div class="form-group col-sm-6 device_type-block">
                              <div class="input-container new-product-input mb-2">
                                 <span class="input-text">Device Type</span><br>
                                 <select class="cate-type" name="device_type">
                                    <option value="">{{$product->device_type->name}}</option>
                                 	
                                 </select>
                                 <img src="{{asset('public/admin/assets/images/7_manage_project_56.png')}}" class="input-img-log"> 
                                 <img src="{{asset('public/admin/assets/images/7_manage_project_58.png')}}" class="input-img-down"> 
                              </div>
                              <span class="help-block text-danger"></span>
                           </div>

                           <div class="form-group col-sm-6 brand-block">
                              <div class="input-container new-product-input mb-2">
                                 <span class="input-text">Brand</span><br>
                                 <select class="cate-type" name="brand">
                                    <option value="">{{$product->brand->name}}</option>
                                 </select>
                                 <img src="{{asset('public/admin/assets/images/7_manage_project_56.png')}}" class="input-img-log"> 
                                 <img src="{{asset('public/admin/assets/images/7_manage_project_58.png')}}" class="input-img-down"> 
                              </div>
                              <span class="help-block text-danger"></span>
                           </div>

                           <div class="form-group col-sm-12 name-block">
                           		<label>Product Name</label>
                              	<div class="input-container">
								 	                <input type="text" name="name" value="{{$product->name}}" class="form-control pl-5 mb-1" placeholder="Product Name">
                                 	<img src="{{asset('public/admin/assets/images/7_manage_project_33.png')}}" class="input-img-log">
                                </div>
                              	<span class="help-block text-danger"></span>
                           </div>

                           <div class="form-group col-sm-4 product_id_show-block mt-1">
                              <label>Product ID</label>
                                <div class="input-container">
                                  <input type="text" name="product_id_show" value="{{$product->product_id}}" class="form-control pl-5 mb-1" placeholder="Product ID">
                                  <img src="{{asset('public/admin/assets/images/7_manage_project_33.png')}}" class="input-img-log">
                                </div>
                                <span class="help-block text-danger"></span>
                           </div>

                           <div class="form-group col-sm-4 potency-block mt-1">
                              <label>Potency</label>
                                <div class="input-container">
                                  <input type="text" name="potency" value="{{$product->potency}}" class="form-control pl-5 mb-1" placeholder="Potency">
                                  <img src="{{asset('public/admin/assets/images/7_manage_project_33.png')}}" class="input-img-log">
                                </div>
                                <span class="help-block text-danger"></span>
                           </div>

                           <div class="form-group col-sm-4 sku_code-block mt-1">
                              <label>SKU Code</label>
                                <div class="input-container">
                                  <input type="text" name="sku_code" value="{{$product->sku_code}}" class="form-control pl-5 mb-1" placeholder="SKU Code">
                                  <img src="{{asset('public/admin/assets/images/7_manage_project_33.png')}}" class="input-img-log">
                                </div>
                                <span class="help-block text-danger"></span>
                           </div>

                           <div class="form-group col-sm-12 description-block mt-1">
                           		<label>Description</label>
                              	<div class="input-container">
                                 	<textarea class="form-control mb-2" name="description" rows="5" placeholder="Product description">{{urldecode($product->description)}}</textarea>
                              	</div>
                              	<span class="help-block text-danger"></span>
                           </div>

                           <div class="form-group col-sm-12 corresponding_product_id-block mt-3">
                              <div class="input-container new-product-input mb-2">
                                 <span class="input-text">Select Corresponding Product</span><br>
                                 <select class="cate-type" name="corresponding_product_id">
                                  @if($product->corresponding_product)
                                    <option value="">{{$product->corresponding_product->name}}</option>
                                  @endif
                                  
                                 </select>
                                 <img src="{{asset('public/admin/assets/images/7_manage_project_56.png')}}" class="input-img-log"> 
                                 <img src="{{asset('public/admin/assets/images/7_manage_project_58.png')}}" class="input-img-down"> 
                              </div>
                              <span class="help-block text-danger"></span>
                           </div>

                           <section id="cost-section" class="mt-3" style="margin-left: 15px;margin-right: 15px;">
                            {{-- <hr> --}}
                             @php $j = 0; @endphp
                              @foreach($product->costs as $cost)
                                <div class="row">
                                 <input type="hidden" name="product_cost_id[]" value="{{$cost->id}}">
                                 <div class="form-group col-sm-4 quantity_0-block">
                                  <label>Product Quantity</label>
                                    <div class="input-container">
                                       <input type="text" value="{{$cost->quantity}}" name="quantity[]" class="form-control pont-lft mb-3" placeholder="Quantity">
                                       <select class="number-code" name="option_id[]">
                                            <option value="" selected>{{$cost->quantity_option->name}}</option>
                                       </select>
                                       <img src="{{asset('public/admin/assets/images/7_manage_project_51.png')}}" class="pont-lft-img">
                                    </div>
                                    <span class="help-block text-danger"></span>
                                 </div>
                                 <div class="form-group col-sm-3 cost_0-block">
                                  <label>Cost</label>
                                    <div class="input-container">
                                       <input type="number" step="any" class="form-control pl-5 mb-3" placeholder="Cost" min="0" name="cost[]" value="{{$cost->cost}}">
                                       <select class="number-code">
                                          <option>$</option>
                                       </select>
                                       <img src="{{asset('public/admin/assets/images/7_manage_project_51.png')}}" class="slct-dwn">
                                    </div>
                                    <span class="help-block text-danger"></span>
                                 </div>
                                 
                                  <div class="form-group col-sm-4 available_stock_0-block">
                                    <label>Available Stock Quantity</label>
                                      <div class="input-container">
                                        <input type="number" value="{{$cost->available_stock}}" name="available_stock[]" class="form-control pl-5 mb-3" placeholder="Stock" min="1">
                                        <img src="{{asset('public/admin/assets/images/7_manage_project_66.png')}}" class="input-img-log">
                                      </div>
                                      <span class="help-block text-danger"></span>
                                  </div>

                                </div>
                                @php $j++; @endphp
                              @endforeach
                            
                          </section>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </article>
      </div>
   </div>
</div>
@include('admin.inc.footer')
