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
                     
                  </div>
                  @include('admin.inc.top_right_header')
               </div>
            </header>
            <div class="article-body store-bd-gy">
               <div class="row rowMarginHalf colpad-half align-items-center justify-content-between">
                  <div class="col-sm-6 col-md-6 col-lg-6">
                     <ul class="nav nav-tabs mt-3 mb-4 d-inline-flex text-center group-tabs ">
                        <li class="nav-item ">
                           <a class="nav-link active" onClick="loadBannerList(1)" data-toggle="tab" href="#active-banner">Active</a>
                        </li>
                        <li class="nav-item ">
                           <a class="nav-link" onClick="loadBannerList(0)" data-toggle="tab" href="#inactive-banner">Inactive</a>
                        </li>
                     </ul>
                  </div>
                  <div class="col-lg-6 d-flex  justify-content-end align-items-center col-sm-6 col-md-6">
                     <a onClick="openBannerModal()" class="add-new-prdt" style="cursor: pointer;">+ Add New Banner</a>
                  </div>
               </div>
               <div class="tab-content">
                  <div id="active-banner" class="tab-pane active">
                     <div class="row mt-4">
                     </div>
                  </div>
                  <!-- <div id="inactive-banner" class="tab-pane fade">
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
<div class="modal fade" id="AddNewBanner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered " role="document">
      <div class="modal-content">
         <button type="button" class="close" data-dismiss="modal"><i class="icon-xs-o-md"></i></button>
         <div class="modal-body px-5">
            <button type="button" class="close clse" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><img src="{{asset('public/admin/assets/images/close.png')}}"></span>
            </button>
            <div class="row">
               <div class="col-sm-12 col-md-12">
                  <form class="row" id="banner-form">
                    <div class="row">
                      <div class="col-sm-12 mb-4">
                        <h4 class="banner-title">Add New Banner</h4>
                      </div>
                    </div>
                  	<p class="alert" id="alert-msg" style="display: none;width: 100%;"></p>
                  	<input type="hidden" name="edit_id" id="edit_id" value="">
                     <div class="col-sm-12 banner-block mb-3">
                        <label>Upload Banner</label>
                        <input type="file" class="form-control" name="banner" accept="image/*" />
                        <span class="help-block text-danger"></span>
                        <img src="" class="pre-banner" style="display: none;width: 92px;margin-top:4px;height: auto;">
                     </div>
                     <div class="col-sm-12 text-block mb-3">
                        <label>Add Text (Max 200 Charactors)</label>
                        <input type="text" class="form-control" name="text" placeholder="Add Banner Text" />
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
<script>
    function loadBannerList(type,keyword=''){
    	$("#type").val(type);
    	$("#active-banner .row").html('<div class="col-sm-12"><center><img src="'+loader+'"></center></div>');
    	$("#active-banner .row").load("{{route('admin/manage_banners/list')}}/"+type);
    }

    setTimeout(function(){
    	loadBannerList(1);
    },500);
    
    function openBannerModal(id=''){
      if(id==''){
        $(`.banner-title`).html('Add New Banner');$(`.pre-banner`).hide();
      }
    	$("#edit_id").val(id);
    	$("#AddNewBanner").modal('show');
    }
    
    $('#AddNewBanner').on('hidden.bs.modal', function () {
        $('#AddNewBanner form')[0].reset();
        $("#submit-btn").css('color','#fff');
        $(".help-block").html('');
        $("#alert-msg").hide();
    });
   	
    $("#banner-form").submit(function(e){
          $("#submit-btn").html('<center><img src="'+loader+'" style="max-height:28px;"></center>');
          $("#submit-btn").css('color','#fff');
          $(".form-group").removeClass('has-error');
          $(".help-block").html('');
          $("#alert-msg").hide();
          $.ajax({
              url: "{{route('admin/banners/add_edit_request')}}", 
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
                    $("#alert-msg").slideToggle(100);
                    $("#alert-msg").removeClass('alert-danger');
                    $("#alert-msg").addClass('alert-success');
                    $("#alert-msg").html(data.errorMsg);              
                    setTimeout(function(){
                    	$("#AddNewBanner").modal('hide');
                    	loadBannerList($("#type").val());
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
    

	function editCategory(id){
    $(`.banner-title`).html('Edit Data');
    $(`.pre-banner`).show();
		$.ajax({
			url: "{{route('getRow')}}",
			type: "get",
			data: {'tableName': 'banners', 'rowId': id},
      headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
      success:function(res){
      	let obj = JSON.parse(res);
      	//console.log(obj.name);
      	$("input[name='text']").val(obj.text);
      	$(".pre-banner").attr('src',"{{imageBaseURL()}}"+ obj.large_banner);
      	openBannerModal(obj.id);
      }
		})
	}

</script>