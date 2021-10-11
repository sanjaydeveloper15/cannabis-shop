@include('admin.inc.header')
      <section class="account-form customer-account">
         <div class="">
            <div class="d-md-flex">
               <div class="col-md-6 col-lg-5 px-0  bg-grad-red">
                  <div class="mx-auto logoicon">
                     <a href="index.html"><img src="{{asset('public/admin/assets/images/cannabis.png')}}" class="img-fluid " alt="img"></a>
                  </div>
               </div>
               <div class="col-sm-12 col-md-6 col-lg-7">
                  <div class="mt-5 mb-1 text-center">
                     <img src="{{asset('public/admin/assets/images/modal-logo.png')}}" class="img-fluid login-logo" alt="img">
                  </div>
                  <form class="row mt-1 login-form" id="login_form_db">
                     <div class="form-group col-sm-12">
                        <p class="modal-title">Login</p>
                     </div>
                     <p class="alert" id="alert-msg" style="display: none;width: 100%;">
                     <div class="form-group col-sm-12 email-block">
                        <div class="input-container">
                           <input type="email" name="email" class="form-control pl-5" placeholder="Email Address">
                           <img src="{{asset('public/admin/assets/images/email.png')}}" class="input-img-log">
                        </div>
                        <span class="help-block text-danger"></span>
                     </div>
                     <div class="form-group col-sm-12 password-block">
                        <div class="input-container">
                           <input type="password" name="password" class="form-control pl-5" placeholder="Password"  id="password-field">
                           <img src="{{asset('public/admin/assets/images/password.png')}}" class="input-img-log">
                           <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        </div>
                        <span class="help-block text-danger"></span>
                     </div>
                     <div class="form-group col-sm-12">
                     	<button type="submit" class="submit-btn" id="login-btn">{{__('Login')}}</button>
                     </div>
                     <div class="form-group col-sm-12 text-center">
                        <a href="#forgot-password" class="forgot-password" data-target="#forgot-password" data-toggle="modal" data-dismiss="modal">Forgot Password?</a>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </section>
      <!-- Modal -->
      <div class="modal fade" id="forgot-password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="icon-xs-o-md"></i></button>
               <div class="modal-body px-5">
                  <button type="button" class="close clse" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true"><img src="{{asset('public/admin/assets/images/close.png')}}"></span>
                  </button>
                  <div class="row">
                     <div class="col-sm-12 col-md-12">
                        <form class="row">
                           <div class="form-group col-sm-12 text-center">
                              <p class="modal-title">Forgot Password</p>
                              <p>Enter your registered email address to reset your password</p>
                           </div>
                           <div class="form-group col-sm-12">
                              <div class="input-container">
                                 <input type="email" class="form-control pl-5" placeholder="Email Address">
                                 <img src="{{asset('public/admin/assets/images/email.png')}}" class="input-img-log">
                              </div>
                           </div>
                           <div class="form-group col-sm-12">
                              <div class="submit-btn" data-target="#otp-verify" data-toggle="modal" data-dismiss="modal">Next</div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="change-password-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="icon-xs-o-md"></i></button>
               <div class="modal-body px-5">
                  <button type="button" class="close clse" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true"><img src="{{asset('public/admin/assets/images/close.png')}}"></span>
                  </button>
                  <div class="row">
                     <div class="col-sm-12 col-md-12">
                        <form class="row">
                           <div class="form-group col-sm-12 text-center">
                              <p class="modal-title">Change Password</p>
                              <p>You can change your password</p>
                           </div>
                           <div class="form-group col-sm-12">
                              <div class="input-container">
                                 <input type="password" class="form-control pl-5" placeholder="New Password">
                                 <img src="{{asset('public/admin/assets/images/password.png')}}" class="input-img-log">
                              </div>
                           </div>
                           <div class="form-group col-sm-12">
                              <div class="input-container">
                                 <input type="password" class="form-control pl-5" placeholder="Confirm New Password">
                                 <img src="{{asset('public/admin/assets/images/password.png')}}" class="input-img-log">
                              </div>
                           </div>
                           <div class="form-group col-sm-12">
                              <div class="submit-btn">Change Password</div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="otp-verify" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="icon-xs-o-md"></i></button>
               <div class="modal-body px-5">
                  <button type="button" class="close clse" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true"><img src="{{asset('public/admin/assets/images/close.png')}}"></span>
                  </button>
                  <div class="row">
                     <div class="col-sm-12 col-md-12">
                        <form class="row">
                           <div class="form-group col-sm-12 text-center">
                              <p class="modal-title">OTP Verification</p>
                              <p>We have send OTP on your email address</p>
                           </div>
                           <div class="form-group col-sm-12">
                              <div class="passcode-wrapper">
                                 <input id="codeBox1" type="number" maxlength="1">
                                 <input id="codeBox2" type="number" maxlength="1">
                                 <input id="codeBox3" type="number" maxlength="1" >
                                 <input id="codeBox4" type="number" maxlength="1">
                                 <input id="codeBox5" type="number" maxlength="1">
                                 <input id="codeBox6" type="number" maxlength="1">
                              </div>
                           </div>
                           <div class="form-group col-sm-12 mt-4">
                              <input type="submit" value="Next" class="submit-btn"  data-target="#change-password-modal" data-toggle="modal" data-dismiss="modal">
                           </div>
                           <div class="form-group col-sm-12 text-center">
                              <div>Didn't get OTP? <a href="#" class="forgot-password">Resend</a></div>
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
    $(".toggle-password").click(function() {
     	$(this).toggleClass("fa-eye fa-eye-slash");
     	var input = $($(this).attr("toggle"));
     	if (input.attr("type") == "password") {
     		input.attr("type", "text");
     	} else {
     		input.attr("type", "password");
     	}
    });

    $("#login_form_db").submit(function(e){
        var loader = '{{lightLoader()}}';
          $("#login-btn").html(`<center><img src="${loader}" style="max-height:28px;"></center>`);
          $("#login-btn").css('color','#fff');
          $(".form-group").removeClass('has-error');
          $(".help-block").html('');
          $("#alert-msg").hide();
          $.ajax({
              url: `{{route('admin.admin_login')}}`, 
              type: "post",
              headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
              data: new FormData(this),
              processData: false,
              contentType: false,
              success: function(data){
                  var edit_mode = 0;
                  if(data.errorCode=='1'){
                    $.each(data.errors , function(i){console.log('.'+i+'-block');
                      $('.'+i+'-block').addClass('has-error');
                      $('.'+i+'-block > .help-block').html(data.errors[i]['0']);
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
                         window.location.href = `{{route('admin/categories')}}`;
                    }, 500);
                  }else{
                    $("#alert-msg").slideToggle(100);
                    $("#alert-msg").addClass('alert-danger');
                    $("#alert-msg").html('Sorry, something went wrong, please try again later.');
                  }
                  $("#login-btn").html('Login');
              }
          });
          
          e.preventDefault();
    });
</script>
   