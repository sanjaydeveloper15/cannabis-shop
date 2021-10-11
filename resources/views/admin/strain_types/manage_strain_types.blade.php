@include('admin.inc.header')
<style type="text/css">
	.cat-pic{
		height: 112px;width: 112px;border-radius: 50%;
	}
</style>
<div class="admin-panel">
   <div class="container-fluid px-0">
      <div class="row no-gutters">
         @include('admin.inc.sidebar')
         <article class="col-lg-9">
            <header class="p-3">
               <div class="row rowMarginHalf colpad-half align-items-center justify-content-between">
                  <div class="col-sm-6 col-md-8 col-lg-8">
                     <div class="form-group flex-grow-1 mb-0">
                        <div class="custom-group-input pill left-icon">
                           <input type="text" name="" id="keyword" class="form-control " placeholder="Search Strain Type Via Name">
                           <span class="group-icon-left"><img src="{{asset('public/admin/assets/images/2_manage_order_16.png')}}" class="img-fluid srch"></span>
                        </div>
                     </div>
                  </div>
                  @include('admin.inc.top_right_header')
               </div>
            </header>
            <div class="article-body store-bd-gy">
               <div class="row rowMarginHalf colpad-half align-items-center justify-content-between">
                  <div class="col-sm-6 col-md-6 col-lg-6">
                     <ul class="nav nav-tabs mt-3 mb-4 d-inline-flex text-center group-tabs ">
                        <li class="nav-item ">
                           <a class="nav-link nav-1 active" onClick="loadStrainTypeList(1)" data-toggle="tab" href="#active-straintype">Active</a>
                        </li>
                        <li class="nav-item ">
                           <a class="nav-link nav-0" onClick="loadStrainTypeList(0)" data-toggle="tab" href="#inactive-straintype">Inactive</a>
                        </li>
                     </ul>
                  </div>
                  <div class="col-lg-6 d-flex  justify-content-end align-items-center col-sm-6 col-md-6">
                     <a onClick="openStrainTypeModal()" class="add-new-prdt" style="cursor: pointer;">+ Add New Strain Type</a>
                  </div>
               </div>
               <div class="tab-content">
                  <div id="active-straintype" class="tab-pane active">
                     <div class="row mt-4">
                     </div>
                  </div>
                  <!-- <div id="inactive-straintype" class="tab-pane fade">
                     <div class="row mt-4">
                     </div>
                  </div> -->
               </div>
            </div>
         </article>
      </div>
   </div>
</div>

<!-- Modal -->
<div class="modal fade" id="AddNewStrainType" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered " role="document">
      <div class="modal-content">
         <button type="button" class="close" data-dismiss="modal"><i class="icon-xs-o-md"></i></button>
         <div class="modal-body px-5">
            <button type="button" class="close clse" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><img src="{{asset('public/admin/assets/images/close.png')}}"></span>
            </button>
            <div class="row">
               <div class="col-sm-12 col-md-12">
                  <form class="row" id="straintype-form">
                    <div class="col-sm-12">
                      <h4 class="heading text-center">Add New Strain Type</h4><hr>
                    </div>
                  	<p class="alert" id="alert-msg" style="display: none;width: 100%;"></p>
                  	<input type="hidden" name="edit_id" id="edit_id" value="">
                    {{--  <div class="col-sm-12 text-center new-product category_icon-block">
                        <div class="upload-btn-wrapper">
                           <img src="{{asset('public/admin/assets/images/12_manage_customers_63.png')}}" class="img-fluid cat-pic">
                           <input type="file" class="upload-file" name="category_icon" accept="image/*" />
                        </div><br>
                        <span class="help-block text-danger"></span>
                     </div> --}}
                     <div class="form-group col-sm-12 strain_type_name-block">
                        <div class="input-container">
                           <input type="text" name="strain_type_name" class="form-control pl-5" placeholder="Strain Type Name">
                           <img src="{{asset('public/admin/assets/images/12_manage_customers_66.png')}}" class="input-img-log">
                        </div>
                        <span class="help-block text-danger"></span>
                     </div>
                     <div class="form-group col-sm-12">
                        <button type="submit" class="submit-btn" id="submit-btn">Save</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@include('admin.inc.footer')
<input type="hidden" name="" id="type" value="">
<script src="{{asset('public/admin/assets/js/amount-ad-slider.js')}}"></script>
<script>
function loadStrainTypeList(type,keyword=''){
    	$("#type").val(type);
      keyword = (keyword!='') ? btoa(keyword) : keyword;
    	$("#active-straintype .row").html('<div class="col-sm-12"><center><img src="'+loader+'"></center></div>');
    	$("#active-straintype .row").load("{{route('admin/strain_types/list')}}/"+type+"/"+keyword);
    }
    setTimeout(function(){
    	loadStrainTypeList(1);
    },500);
function openStrainTypeModal(id=''){
	$("#edit_id").val(id);
  if(id!=''){
    $("#straintype-form .heading").html('Update Strain Type');
  }else{
    $("#straintype-form .heading").html('Add New Strain Type');
  }
	$("#AddNewStrainType").modal('show');
}
$('#AddNewStrainType').on('hidden.bs.modal', function () {
    $('#AddNewStrainType form')[0].reset();
    $("#submit-btn").css('color','#fff');
  	$(".form-group").removeClass('has-error');
  	$(".help-block").html('');
  	$("#alert-msg").hide();
});
   
    $("#straintype-form").submit(function(e){
          $("#submit-btn").html('<center><img src="'+loader+'" style="max-height:28px;"></center>');
          $("#submit-btn").css('color','#fff');
          $(".form-group").removeClass('has-error');
          $(".help-block").html('');
          $("#alert-msg").hide();
          $.ajax({
              url: "{{route('admin.strain_type_request')}}", 
              type: "post",
              headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
              data: new FormData(this),
              processData: false,
              contentType: false,
              success: function(data){
                  //console.log(data.errors['name']['0']);
                  var edit_mode = 0;
                  if(data.errorCode=='1'){
                    $.each(data.errors , function(i){console.log('.'+i+'-block');
                      $('.'+i+'-block').addClass('has-error');
                      $('.'+i+'-block > .help-block').html(data.errors[i]['0']);
                      //console.log(data.errors[i]['0']);
                    });
                     
                  }else if(data.errorCode=='2'){
                    $("#alert-msg").slideToggle(100);
                    $("#alert-msg").addClass('alert-danger');
                    $("#alert-msg").html(data.errorMsg);
                  }else if(data.errorCode=='3'){
                    console.log('done');
                    $(".input").val('');
                    $("#alert-msg").slideToggle(100);
                    $("#alert-msg").removeClass('alert-danger');
                    $("#alert-msg").addClass('alert-success');
                    $("#alert-msg").html(data.errorMsg);              
                    setTimeout(function(){
                    	$("#AddNewStrainType").modal('hide');
                    	loadStrainTypeList($("#type").val());
                        // window.location.href = "{{config('app.url')}}admin/categories";
                    }, 1000);
                  }else{
                    $("#alert-msg").slideToggle(100);
                    $("#alert-msg").addClass('alert-danger');
                    $("#alert-msg").html('Sorry, something went wrong, please try again later.');
                  }
                  $("#submit-btn").html('Save');
              }
          });
          
          e.preventDefault();
          //return false;
    });
    
	$('#keyword').keydown(function(){
	    clearTimeout(timer); 
	    timer = setTimeout(function(){
	    	let keyword = $("#keyword").val(), type = $("#type").val();
        	(keyword.length > 1) ? loadStrainTypeList(type,keyword) : loadStrainTypeList(type);   		
	    }, 1000);
	});


	function editStrainType(id){
		$.ajax({
			url: "{{route('getRow')}}",
			type: "get",
			data: {'tableName': 'strain_types', 'rowId': id},
            headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
            success:function(res){
            	let obj = JSON.parse(res);
            	//console.log(obj.name);
            	$("input[name='strain_type_name']").val(obj.name);
            	openStrainTypeModal(obj.id);
            }
		})
	}

</script>