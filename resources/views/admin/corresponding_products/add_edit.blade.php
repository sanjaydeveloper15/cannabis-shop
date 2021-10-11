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
                        <a href="{{route('admin/manage_corresponding_products')}}"><img src="{{asset('public/admin/assets/images/7_manage_project_06.png')}}" class="img-fluid"></a>
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
  		                        <div class="upload-btn-wrapper">
  		                           <img src="@if($edit_mode){{imageBaseURL().$data->image}}@else{{asset('public/admin/assets/images/12_manage_customers_63.png')}}@endif" class="img-fluid cat-pic">
  		                           <input type="file" class="upload-file" name="image" accept="image/*" />
  		                        </div><br>
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

                            <div class="form-group col-sm-6 product_id_show-block mt-1">
                              <label>Product ID</label>
                                <div class="input-container">
                                  <input type="text" name="product_id_show" value="@if($edit_mode){{$data->product_id_show}}@endif" class="form-control pl-5 mb-1" placeholder="Product ID">
                                  <img src="{{asset('public/admin/assets/images/7_manage_project_33.png')}}" class="input-img-log">
                                </div>
                                <span class="help-block text-danger"></span>
                            </div>

                            <div class="form-group col-sm-6 cost-block">
                              <label>Cost</label>
                                <div class="input-container">
                                   <input type="number" step="any" class="form-control pl-5 mb-3" placeholder="Cost" min="0" name="cost" value="@if($edit_mode){{$data->cost}}@endif">
                                   <select class="number-code">
                                      <option>$</option>
                                   </select>
                                   <img src="{{asset('public/admin/assets/images/7_manage_project_51.png')}}" class="slct-dwn">
                                </div>
                                <span class="help-block text-danger"></span>
                            </div>

                            {{-- <div class="form-group col-sm-4 potency-block mt-1">
                              <label>Potency</label>
                                <div class="input-container">
                                  <input type="text" name="potency" value="@if($edit_mode){{$data->potency}}@endif" class="form-control pl-5 mb-1" placeholder="Potency">
                                  <img src="{{asset('public/admin/assets/images/7_manage_project_33.png')}}" class="input-img-log">
                                </div>
                                <span class="help-block text-danger"></span>
                            </div> --}}

                           {{--  <div class="form-group col-sm-4 sku_code-block mt-1">
                              <label>SKU Code</label>
                                <div class="input-container">
                                  <input type="text" name="sku_code" value="@if($edit_mode){{$data->sku_code}}@endif" class="form-control pl-5 mb-1" placeholder="SKU Code">
                                  <img src="{{asset('public/admin/assets/images/7_manage_project_33.png')}}" class="input-img-log">
                                </div>
                                <span class="help-block text-danger"></span>
                            </div> --}}

                            <div class="form-group col-sm-12 description-block mt-1">
                           		<label>Description</label>
                              	<div class="input-container">
                                 	<textarea class="form-control mb-2" name="description" rows="5" placeholder="Product description">@if($edit_mode){{urldecode($data->description)}}@endif</textarea>
                              	</div>
                              	<span class="help-block text-danger"></span>
                            </div>


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
              url: "{{route('admin.corresponding_product_request')}}", 
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
                    	window.location.href = "{{route('admin/manage_corresponding_products')}}";
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

</script>