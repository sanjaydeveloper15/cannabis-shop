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
                        	<input type="hidden" name="edit_id" value="@if($edit_mode){{$data->id}}@endif" id="edit_id">
                        	<div class="col-sm-12 text-center new-product image-block">
		                        <div class="upload-btn-wrapper" style="background: #c7c7c7;border-radius: 10px;">
		                           <img src="@if($edit_mode){{imageBaseURL().$data->images->path}}@else{{asset('public/admin/assets/images/12_manage_customers_63.png')}}@endif" class="img-fluid cat-pic">
		                           <input type="file" class="upload-file" name="image" accept="image/*" />
		                        </div><br>
		                        <span class="help-block text-danger"></span>
		                    </div>
                           	
                           	<div class="form-group col-sm-6 category-block">
                              	<div class="input-container new-product-input mb-2">
                									<span class="input-text">Category</span><br>
                									<select class="cate-type" name="category">
                										<option value="">Select Category</option>
                										@foreach($categories as $list)
                											<option value="{{$list->id}}" @if($edit_mode) @if($list->id==$data->category_id) selected @endif @endif>{{ucwords($list->name)}}</option>
                										@endforeach
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
                                    <option value="">Select Strain Type</option>
                                 	@foreach($strain_types as $list)
                                    	<option value="{{$list->id}}" @if($edit_mode) @if($list->id==$data->strain_type_id) selected @endif @endif>{{ucwords($list->name)}}</option>
                                    @endforeach
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
                                    <option value="">Select Device Type</option>
                                 	@foreach($device_types as $list)
                                    	<option value="{{$list->id}}" @if($edit_mode) @if($list->id==$data->device_type_id) selected @endif @endif>{{ucwords($list->name)}}</option>
                                    @endforeach
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
                                    <option value="">Select Brand</option>
                                 	@foreach($brands as $list)
                                    	<option value="{{$list->id}}" @if($edit_mode) @if($list->id==$data->brand_id) selected @endif @endif>{{ucwords($list->name)}}</option>
                                    @endforeach
                                 </select>
                                 <img src="{{asset('public/admin/assets/images/7_manage_project_56.png')}}" class="input-img-log"> 
                                 <img src="{{asset('public/admin/assets/images/7_manage_project_58.png')}}" class="input-img-down"> 
                              </div>
                              <span class="help-block text-danger"></span>
                           </div>

                           <div class="form-group col-sm-12 name-block">
                           		<label>Product Name</label>
                              	<div class="input-container">
								 	                <input type="text" name="name" value="@if($edit_mode){{$data->name}}@endif" class="form-control pl-5 mb-1" placeholder="Product Name">
                                 	<img src="{{asset('public/admin/assets/images/7_manage_project_33.png')}}" class="input-img-log">
                                </div>
                              	<span class="help-block text-danger"></span>
                           </div>

                           <div class="form-group col-sm-4 product_id_show-block mt-1">
                              <label>Product ID</label>
                                <div class="input-container">
                                  <input type="text" name="product_id_show" value="@if($edit_mode){{$data->product_id_show}}@endif" class="form-control pl-5 mb-1" placeholder="Product ID">
                                  <img src="{{asset('public/admin/assets/images/7_manage_project_33.png')}}" class="input-img-log">
                                </div>
                                <span class="help-block text-danger"></span>
                           </div>

                           <div class="form-group col-sm-4 potency-block mt-1">
                              <label>Potency</label>
                                <div class="input-container">
                                  <input type="text" name="potency" value="@if($edit_mode){{$data->potency}}@endif" class="form-control pl-5 mb-1" placeholder="Potency">
                                  <img src="{{asset('public/admin/assets/images/7_manage_project_33.png')}}" class="input-img-log">
                                </div>
                                <span class="help-block text-danger"></span>
                           </div>

                           <div class="form-group col-sm-4 sku_code-block mt-1">
                              <label>SKU Code</label>
                                <div class="input-container">
                                  <input type="text" name="sku_code" value="@if($edit_mode){{$data->sku_code}}@endif" class="form-control pl-5 mb-1" placeholder="SKU Code">
                                  <img src="{{asset('public/admin/assets/images/7_manage_project_33.png')}}" class="input-img-log">
                                </div>
                                <span class="help-block text-danger"></span>
                           </div>

                           <div class="form-group col-sm-12 description-block mt-1">
                           		<label>Description</label>
                              	<div class="input-container">
                                 	<textarea class="form-control mb-2" name="description" rows="5" placeholder="Product description">@if($edit_mode){{urldecode($data->description)}}@endif</textarea>
                              	</div>
                              	<span class="help-block text-danger"></span>
                           </div>

                           <div class="form-group col-sm-12 corresponding_product_id-block mt-3">
                              <div class="input-container new-product-input mb-2">
                                 <span class="input-text">Select Corresponding Product</span><br>
                                 <select class="cate-type" name="corresponding_product_id">
                                    <option value=""> Select Corresponding Product</option>
                                  @foreach($corresponding_products as $list)
                                      <option value="{{$list->id}}" @if($edit_mode) @if($list->id==$data->corresponding_product_id) selected @endif @endif> {{ucwords($list->name)}}</option>
                                    @endforeach
                                 </select>
                                 <img src="{{asset('public/admin/assets/images/7_manage_project_56.png')}}" class="input-img-log"> 
                                 <img src="{{asset('public/admin/assets/images/7_manage_project_58.png')}}" class="input-img-down"> 
                              </div>
                              <span class="help-block text-danger"></span>
                           </div>

                           {{-- <div class="form-group col-sm-6 fake_name-block">
                              <label>Fake Product Name</label>
                                <div class="input-container">
                                  <input type="text" name="fake_name" value="@if($edit_mode){{$data->fake_product->name}}@endif" class="form-control pl-5 mb-1" placeholder="Fake Product Name">
                                  <img src="{{asset('public/admin/assets/images/7_manage_project_33.png')}}" class="input-img-log">
                                </div>
                                <span class="help-block text-danger"></span>
                           </div>

                           <div class="form-group col-sm-6 fake_image-block">
                              <label>Fake Product Image</label>
                                <div class="input-container">
                                  <input type="file" class="form-control" name="fake_image">
                                </div>
                                @if($edit_mode)
                                  <img src="{{imageBaseURL().$data->fake_product->image}}" style="width: 48px;height: 48px;border:1px solid #999;border-radius: 5px;margin-top: 10px;">
                                @endif
                                <span class="help-block text-danger"></span>
                           </div> --}}

                           {{-- <div class="form-group col-sm-6">
                              <div class="input-container">
                                 <input type="text" class="form-control pl-5 mb-3" placeholder="Product Tag">
                                 <img src="{{asset('public/admin/assets/images/7_manage_project_30.png')}}" class="input-img-log">
                              </div>
                           </div> --}}
                           <section id="cost-section" class="mt-3" style="margin-left: 15px;margin-right: 15px;">
                            {{-- <hr> --}}
                            @if($edit_mode)
                              @php $j = 0; @endphp
                              @foreach($data->costs as $cost)
                                <div class="row">
                                 <input type="hidden" name="product_cost_id[]" value="{{$cost->id}}">
                                 <div class="form-group col-sm-4 quantity_0-block">
                                  <label>Product Quantity</label>
                                    <div class="input-container">
                                       <input type="text" value="{{$cost->quantity}}" name="quantity[]" class="form-control pont-lft mb-3" placeholder="Quantity">
                                       <select class="number-code" name="option_id[]">
                                          @foreach($quantity_options as $list)
                                            <option value="{{$list->id}}" @if($list->id==$cost->quantity_option_id) selected @endif>{{$list->name}}</option>
                                          @endforeach
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
                                       {{-- <img src="{{asset('public/admin/assets/images/7_manage_project_51.png')}}" class="slct-dwn"> --}}
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

                                  <div class="form-group col-sm-1">
                                    @if($j==0)
                                      <a class="badge plus-btn" onClick="addMoreCost()"><i class="fa fa-plus"></i></a>
                                    @endif
                                  </div>
                                </div>
                                @php $j++; @endphp
                              @endforeach
                            @else
                           	<div class="row">
	                           <input type="hidden" name="product_cost_id[]" value="">
	                           <div class="form-group col-sm-4 quantity_0-block">
	                           	<label>Product Quantity</label>
	                              <div class="input-container">
	                                 <input type="text" name="quantity[]" class="form-control pont-lft mb-3" placeholder="Quantity">
	                                 <select class="number-code" name="option_id[]">
	                                    @foreach($quantity_options as $list)
	                                    	<option value="{{$list->id}}">{{$list->name}}</option>
	                                    @endforeach
	                                 </select>
	                                 <img src="{{asset('public/admin/assets/images/7_manage_project_51.png')}}" class="pont-lft-img">
	                              </div>
	                              <span class="help-block text-danger"></span>
	                           </div>
	                           <div class="form-group col-sm-3 cost_0-block">
	                           	<label>Cost</label>
	                              <div class="input-container">
	                                 <input type="number" step="any" class="form-control pl-5 mb-3" placeholder="Cost" min="0" name="cost[]">
	                                 <select class="number-code">
	                                    <option>$</option>
	                                 </select>
	                                 {{-- <img src="{{asset('public/admin/assets/images/7_manage_project_51.png')}}" class="slct-dwn"> --}}
	                              </div>
	                              <span class="help-block text-danger"></span>
	                           </div>
	                           
	                           	<div class="form-group col-sm-4 available_stock_0-block">
	                           		<label>Available Stock Quantity</label>
	                              	<div class="input-container">
		                                <input type="number" name="available_stock[]" class="form-control pl-5 mb-3" placeholder="Stock" min="1">
		                                <img src="{{asset('public/admin/assets/images/7_manage_project_66.png')}}" class="input-img-log">
	                              	</div>
	                              	<span class="help-block text-danger"></span>
	                           	</div>

	                           	<div class="form-group col-sm-1">
	                           		<a class="badge plus-btn" onClick="addMoreCost()"><i class="fa fa-plus"></i></a>
	                           	</div>
	                          </div>
                            @endif
                          </section>
                           <div class="form-group col-sm-12 text-center">
                              <button type="submit" class="submit-save" id="submit-btn">Save</button>
                           </div>
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
<input type="hidden" name="click_count" id="click_count" value="@if($edit_mode){{count($data->costs)}}@else{{__('0')}}@endif">
<script type="text/javascript">
	$(document).ready(function() {
	  var readURL = function(input) {
          if (input.files && input.files[0]) {
              var reader = new FileReader();

              reader.onload = function (e) {
                  $('.cat-pic').attr('src', e.target.result);
              }

              reader.readAsDataURL(input.files[0]);
          }
      }
      $(".upload-file").on('change', function(){
          readURL(this);
      });

    });

    $("#product-form").submit(function(e){
          $("#submit-btn").html('<center><img src="'+loader+'" style="max-height:28px;"></center>');
          $("#submit-btn").css('color','#fff');
          $(".form-group").removeClass('has-error');
          $(".help-block").html('');
          $("#alert-msg").hide();
          $.ajax({
              url: "{{route('admin.product_request')}}", 
              type: "post",
              headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
              data: new FormData(this),
              processData: false,
              contentType: false,
              success: function(data){
                  //console.log(data.errors['name']['0']);
                  var edit_mode = 0;
                  if(data.errorCode=='1'){
                    $.each(data.errors , function(i){
                    	let cls = i.split('.')[0];
                    	if(i.split('.')[1]){
                    		cls = cls + '_' + i.split('.')[1];
                    	}
                    	console.log('.'+cls+'-block');
                    	$('.'+cls+'-block').addClass('has-error');
                    	let msg = data.errors[i]['0'].split('.').join('');
                    	msg = msg.split('0').join('');
                    	msg = msg.split('_').join(' ');
                      	$('.'+cls+'-block > .help-block').html(msg);
                    });
                     
                  }else if(data.errorCode=='2'){
                    $("#alert-msg").slideToggle(100);
                    $("#alert-msg").addClass('alert-danger');
                    $("#alert-msg").html(data.errorMsg);
                  }else if(data.errorCode=='3'){
                    console.log('done');
                    $(".input").val('');
                    $("#alert-msg").hide(100);
                    Swal.fire('', data.errorMsg, 'success');             
                    setTimeout(function(){
                    	window.location.href = "{{route('admin/manage_products')}}";
                    }, 1900);
                  }else{
                    $("#alert-msg").slideToggle(100);
                    $("#alert-msg").addClass('alert-danger');
                    $("#alert-msg").html('Sorry, something went wrong, please try again later.');
                  }
                  $("#submit-btn").html('Save');
                  $("html, body").animate({ scrollTop: 110 }, 500);  
              }
          });
          
          e.preventDefault();
          //return false;
    });

    function addMoreCost(){
        click = Number($("#click_count").val()),
        click += 1,
        content = '<div class="cost-'+click+' row"><input type="hidden" name="product_cost_id['+click+']" value=""><div class="form-group col-sm-4 quantity_0-block"> <label>Product Quantity</label><div class="input-container"> <input type="text" name="quantity['+click+']" class="form-control pont-lft mb-3" placeholder="Quantity"> <select class="number-code" name="option_id['+click+']"> @foreach($quantity_options as $list)<option value="{{$list->id}}">{{$list->name}}</option> @endforeach </select> <img src="{{asset('public/admin/assets/images/7_manage_project_51.png')}}" class="pont-lft-img"></div> <span class="help-block text-danger"></span></div><div class="form-group col-sm-3 cost_0-block"> <label>Cost</label><div class="input-container"> <input type="number" class="form-control pl-5 mb-3" placeholder="Cost" min="0" name="cost['+click+']"> <select class="number-code"><option>$</option> </select> <img src="{{asset('public/admin/assets/images/7_manage_project_51.png')}}" class="slct-dwn"></div> <span class="help-block text-danger"></span></div><div class="form-group col-sm-4 available_stock_0-block"> <label>Available Stock Quantity</label><div class="input-container"> <input type="number" name="available_stock['+click+']" class="form-control pl-5 mb-3" placeholder="Stock" min="1"> <img src="{{asset('public/admin/assets/images/7_manage_project_66.png')}}" class="input-img-log"></div> <span class="help-block text-danger"></span></div><div class="form-group col-sm-1"><a class="badge cross-btn" onclick="closeCost('+click+')"><i class="fa fa-times"></i></a></div></div>';

        $("#click_count").val(click);
       	$("#cost-section").append(content);
    }

    function closeCost(id){
      click = Number($("#click_count").val()),
      click -= 1;
      $(".cost-"+id).remove();
      $("#click_count").val(click);
    }
</script>