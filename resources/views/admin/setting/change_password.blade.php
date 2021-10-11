@include('admin.inc.header')
<div class="admin-panel">
   <div class="container-fluid px-0">
      <div class="row no-gutters">
         <!-- Sidebar  -->
         @include('admin.inc.sidebar')
         <article class="col-lg-9">
            <header class="p-3">
               <div class="row rowMarginHalf colpad-half align-items-center justify-content-between">
                  <div class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-end">
                     <img src="{{asset('public/admin/assets/images/2_manage_order_05.png')}}" class="img-fluid filter" id="navToggle-noti" style="cursor: pointer;">
                     <a href="{{route('admin/logout')}}"><img src="{{asset('public/admin/assets/images/2_manage_order_07.png')}}" class="img-fluid filter" style="cursor: pointer;"></a>
                  </div>
               </div>
            </header>
            <div class="article-body store-bd-gy">
               <div class="row rowMarginHalf colpad-half align-items-center justify-content-between">
                  <div class="col-sm-12 col-md-12 col-lg-12">
                     <div class="setting-page">
                        <form class="row" id="change-password">
                        	<div class="alert" id="alert-msg" style="display: none;width: 100%;"></div>
                           <div class="form-group col-sm-12 text-center">
                              <h3>Change Password</h3>
                           </div>
                           <div class="form-group col-sm-12 current_password-block">
                              <div class="input-container">
                                 <input type="password" class="form-control pl-5" name="current_password" placeholder="Current Password">
                                 <img src="{{asset('public/admin/assets/images/password.png')}}" class="input-img-log">
                              </div>
                              <span class="help-block text-danger"></span>
                           </div>
                           <div class="form-group col-sm-12 password-block">
                              <div class="input-container">
                                 <input type="password" name="password" class="form-control pl-5" placeholder="New Password">
                                 <img src="{{asset('public/admin/assets/images/password.png')}}" class="input-img-log">
                              </div>
                              <span class="help-block text-danger"></span>
                           </div>
                           <div class="form-group col-sm-12 password_confirmation-block">
                              <div class="input-container">
                                 <input type="password" name="password_confirmation" class="form-control pl-5" placeholder="Confirm New Password">
                                 <img src="{{asset('public/admin/assets/images/password.png')}}" class="input-img-log">
                              </div>
                              <span class="help-block text-danger"></span>
                           </div>
                           <div class="form-group col-sm-12">
                           		<button type="submit" class="submit-btn" id="submit-btn">Change Password</button>
                              {{-- <div class="">Change Password</div> --}}
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
	$("#change-password").submit(function(e){
          $("#submit-btn").html('<center><img src="'+loader+'" style="max-height:28px;"></center>');
          $("#submit-btn").css('color','#fff');
          $(".form-group").removeClass('has-error');
          $(".help-block").html('');
          $("#alert-msg").hide();
          $.ajax({
              url: "{{route('admin/change_password_request')}}", 
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
                    $("#alert-msg").hide(100);
                    Swal.fire('', data.errorMsg, 'success');             
                    setTimeout(function(){
                    	location.reload();
                    }, 1900);
                  }else{
                    $("#alert-msg").slideToggle(100);
                    $("#alert-msg").addClass('alert-danger');
                    $("#alert-msg").html('Sorry, something went wrong, please try again later.');
                  }
                  $("#submit-btn").html('Change Password'); 
              }
          });
          
          e.preventDefault();
          //return false;
    });
</script>