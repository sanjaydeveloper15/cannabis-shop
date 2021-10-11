@include('admin.inc.header')
<div class="admin-panel">
   <div class="container-fluid px-0">
      <div class="row no-gutters">
         <!-- Sidebar  -->
         @include('admin.inc.sidebar')
         <article class="col-lg-9">
            <header class="p-3">
               <div class="row rowMarginHalf colpad-half align-items-center justify-content-between">
                  <div class="col-sm-12 col-md-8 col-lg-8">
                  </div>
                  <div class="col-lg-4 d-flex justify-content-end align-items-center col-sm-12 col-md-4">	
                     <img src="{{asset('public/admin/assets/images/2_manage_order_05.png')}}" class="img-fluid filter" id="navToggle-noti" style="cursor: pointer;">
                     <a href="{{route('admin/logout')}}"><img src="{{asset('public/admin/assets/images/2_manage_order_07.png')}}" class="img-fluid filter" style="cursor: pointer;"></a>
                  </div>
               </div>
            </header>
            <div class="article-body store-bd-gy">
               <div class="row rowMarginHalf colpad-half align-items-center justify-content-between mb-4">
                  <div class="col-sm-6 col-md-7 col-lg-7">
                     <div class="form-group flex-grow-1 mb-0">
                        <div class="custom-group-input pill left-icon">
                           <input type="text" id="keyword" name="" class="form-control " placeholder="Search Here...">
                           <span class="group-icon-left"><img src="{{asset('public/admin/assets/images/2_manage_order_16.png')}}" class="img-fluid srch"></span>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-3 d-flex  justify-content-end align-items-center col-sm-6 col-md-3">
                     <a onClick="openAreaModal()" class="add-new-prdt" style="cursor: pointer;">+ Add New Area Code</a>
                  </div>
               </div>
               <div class="manageArea" id="manageArea">
                  <div class="row">
                     
                  </div>
               </div>
            </div>
         </article>
      </div>
   </div>
</div>
<!-- Modal -->
<div class="modal fade" id="AreaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered " role="document">
      <div class="modal-content">
         <button type="button" class="close" data-dismiss="modal"><i class="icon-xs-o-md"></i></button>
         <div class="modal-body px-5">
            <button type="button" class="close clse" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><img src="{{asset('public/admin/assets/images/close.png')}}"></span>
            </button>
            <div class="row">
               <div class="col-sm-12 col-md-12">
                  <form class="row" id="area-form">
                     <div class="col-sm-12">
                        <h4 class="heading text-center">Add New Area Code</h4>
                        <hr>
                     </div>
                     <p class="alert" id="alert-msg" style="display: none;width: 100%;"></p>
                     <input type="hidden" name="edit_id" id="edit_id" value="">
                     <div class="form-group col-sm-12 area_code-block">
                        <div class="input-container">
                           <input type="text" name="area_code" class="form-control pl-5" placeholder="Area Code">
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
<script>
   	function loadAreaList(keyword=''){
      	keyword = (keyword!='') ? btoa(keyword) : keyword;
      	$(".manageArea .row").html('<div class="col-sm-12"><center><img src="'+loader+'"></center></div>');
      	$(".manageArea .row").load("{{route('admin/area_codes/list')}}/"+keyword);
    }
    
    setTimeout(function(){
      	loadAreaList();
    },500);
   	
   	function openAreaModal(id=''){
   		$("#edit_id").val(id);
     	if(id!=''){
       		$("#area-form .heading").html('Update Area Code');
     	}else{
       		$("#area-form .heading").html('Add New Area Code');
     	}
   		$("#AreaModal").modal('show');
   	}

   	$('#AreaModal').on('hidden.bs.modal', function () {
       	$('#AreaModal form')[0].reset();
       	$("#submit-btn").css('color','#fff');
     	$(".form-group").removeClass('has-error');
     	$(".help-block").html('');
     	$("#alert-msg").hide();
   	});
     
    $("#area-form").submit(function(e){
        $("#submit-btn").html('<center><img src="'+loader+'" style="max-height:28px;"></center>');
        $("#submit-btn").css('color','#fff');
        $(".form-group").removeClass('has-error');
        $(".help-block").html('');
        $("#alert-msg").hide();
        $.ajax({
            url: "{{route('admin.area_code_request')}}", 
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
                  	$("#AreaModal").modal('hide');
                  	loadAreaList();
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
          	(keyword.length > 1) ? loadAreaList(keyword) : loadAreaList();   		
       }, 1000);
   	});
   
   
</script>