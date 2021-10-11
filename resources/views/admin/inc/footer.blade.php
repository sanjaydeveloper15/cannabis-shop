		<footer>
		<div class="offcanvas-collapse-noti">
		   <h5 class="text-center mt-2">Notification</h5>
		   <button type="button" class="close canvas-clse" id="navToggle-noti">
		   <span><img src="{{asset('public/admin/assets/images/close.png')}}"></span>
		   </button>
		   <div class="notification-canvas">
		      <ul>
		      </ul>
		   </div>
		   <br>
		   <center><a class="add-new-prdt" href="{{route('admin.notifications')}}">View All</a></center>
		</div>
			<!-- JavaScript  files ========================================= -->
			<script src="{{asset('public/admin/assets/js/jquery.min.js')}}"></script><!-- JQUERY.MIN JS --> 
			<script src="{{asset('public/admin/assets/plugins/bootstrap/js/bootstrap.bundle.js')}}"></script><!-- BOOTSTRAP.MIN JS -->    
			<!-- <script src="assets/plugins/scroll/js/scrollbar.min.js"></script>scrollbar.MIN JS    -->
			<script src="https://cdnjs.cloudflare.com/ajax/libs/picturefill/3.0.3/picturefill.min.js"></script>
			<script src="{{asset('public/admin/assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script><!-- jqueryUi.MIN JS -->   
			<script src="{{asset('public/admin/assets/plugins/slick/slick.min.js')}}"></script><!-- slick SLIDER -->  
			<script src="{{asset('public/admin/assets/js/custom.min.js')}}"></script><!-- CUSTOM FUCTIONS  -->  
			<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
			<script type="text/javascript">
				var offset = new Date().getTimezoneOffset();
				console.log(offset);
				var loader = '{{lightLoader()}}', timer = null;
				$(document).ready(function() {
			     	$('[data-toggle="offcanvas"], #navToggle-noti').on('click', function () {
			       		$('.offcanvas-collapse-noti').toggleClass('open')
			     	})
			    });

			    //change status like active to deactive
		        function changeStatus(tableName, rowId, current, column='',msg='', isLoad='0', url='', isLoadId='',set=''){
		        	//alert('working');return false;
		          if(current=='1'){
		            var txt = 'Deactivate';
		            $("#customSwitch"+rowId).prop("checked", true);
		          }else{
		            var txt = 'Activate';
		            $("#customSwitch"+rowId).prop("checked", false);
		          }
		          if(msg==''){
		            msg = "You really want to "+ txt + " it!";
		          }
		            Swal.fire({
		                title: 'Are you sure?',
		                text: msg,
		                type: 'warning',
		                showCancelButton: true,
		                confirmButtonColor: "#018A01",
		                cancelButtonColor: '#b8d042',
		                confirmButtonText: 'Yes, Please do it!'
		              }).then((result) => {
		                if (result.value) {
		                  $.ajax({
		                      url: "{{route('changeStatus')}}",
		                      type: "post",
		                      headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
		                      data: { "tableName" : tableName, "rowId" : rowId, "current" : current, "column" : column, 'set' : set },
		                      success: function(data){
		                          Swal.fire(
		                            'Done!',
		                            'Status has been changed successfully!',
		                            'success'
		                          )
		                          setTimeout(function(){
		                            if(isLoad=='1'){
		                                $("#"+ isLoadId).html('<center><img src="'+loader+'" class="theme-loader"></center>');
		                                $("#"+ isLoadId).load(url);
		                            }else{
		                                if(url!=''){
		                                  $("#"+ isLoadId).html('<center><img src="'+loader+'" class="theme-loader"></center>');
		                                  window.location.href = url;
		                                }else{
		                                  window.location.reload(1);
		                                }
		                            }
		                        }, 1900);
		                      }
		                  });

		                //el.remove();
		              }
		            });
		        }

		        //delete specific row
			    function deleteRow(tableName, rowId, hash_token='', this_val, isLoad='0', url='', isLoadId=''){
			      Swal.fire({
			          title: 'Are you sure?',
			          text: "You really want to Delete this " + this_val + ", after Deleting this related data will also Delete!",
			          type: 'warning',
			          showCancelButton: true,
			          confirmButtonColor: 'red',
			          cancelButtonColor: '#b8d042',
			          confirmButtonText: 'Yes, Delete it!'
			        }).then((result) => {
			          if (result.value) {
			            $.ajax({
			                url: "{{route('deleteRow')}}",
			                type: "post",
			                headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
			                data: { "tableName" : tableName, "rowId" : rowId, "hash_token" : hash_token },
			                success: function(data){
			                    Swal.fire(
			                      'Deleted!',
			                      'You have successfully deleted it!',
			                      'success'
			                    )
			                    setTimeout(function(){
			                        if(isLoad=='1'){
			                            $("#"+ isLoadId).html('<center><img src="'+loader+'" class="theme-loader"></center>');
			                            $("#"+ isLoadId).load(url);
			                        }else if(isLoad=='2'){
			                            checkoutStep(url);
			                        }else{
			                            window.location.reload(1);
			                        }
			                    }, 1900);
			                }
			            });

			          //el.remove();
			        }
			      });
			    }

			    function redirectFromSidebar(url){
			    	$("article header").hide();
			    	$(".article-body").html('<center><img src="'+loader+'" class="theme-loader"></center>');
			    	window.location.href = url;
			    }

			    $(`#navToggle-noti`).click(function(){
			    	$(`.notification-canvas ul`).html('<li>Loading...</li>');
				  	$(`.notification-canvas ul`).load("{{route('admin.popup_notif')}}");	
				  	//$(`#open-notif-popup .badge`).html(0);
				});
			</script>

			<!-- The core Firebase JS SDK is always required and must be listed first https://www.gstatic.com/firebasejs/8.4.3/firebase-app.js -->
			<script src="https://www.gstatic.com/firebasejs/8.4.3/firebase.js"></script>

			<!-- TODO: Add SDKs for Firebase products that you want to use
			     https://firebase.google.com/docs/web/setup#available-libraries -->
			{{-- <script src="https://www.gstatic.com/firebasejs/8.4.3/firebase-analytics.js"></script> --}}

			<script>
			  // Your web app's Firebase configuration
			  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
			  var firebaseConfig = {
			    apiKey: "AIzaSyAxm85gbsB_j0BR7NSniLAULpOHsw4njYk",
			    authDomain: "cannadev-5e652.firebaseapp.com",
			    projectId: "cannadev-5e652",
			    storageBucket: "cannadev-5e652.appspot.com",
			    messagingSenderId: "565656022843",
			    appId: "1:565656022843:web:5354fad9f832cfb803111e",
			    measurementId: "G-GC7X4P1ERJ"
			  };
			  // Initialize Firebase
			  firebase.initializeApp(firebaseConfig);
			  //firebase.analytics();

			  // Retrieve Firebase Messaging object.
			   const messaging = firebase.messaging();
			   messaging.requestPermission()
			   .then(function() {
			     console.log('Notification permission granted.');
			     // TODO(developer): Retrieve an Instance ID token for use with FCM.
			     if(isTokenSentToServer()) {
			       console.log('Token already saved.');
			     } else {
			       getRegToken();
			     }
			   })
			   .catch(function(err) {
			     console.log('Unable to get permission to notify.', err);
			   });

			   function getRegToken(argument) {
			      messaging.getToken()
			       .then(function(currentToken) {
			         if (currentToken) {
			           //saveToken(currentToken);
			           var token = currentToken;
			             var device_id = '<?php echo md5($_SERVER['HTTP_USER_AGENT']); ?>';
			           console.log('token: '+token);
			           console.log('device_id: '+device_id);
			           saveToken(token, device_id);
			         } else {
			           console.log('No Instance ID token available. Request permission to generate one.');
			           //setTokenSentToServer(false);
			         }
			       })
			       .catch(function(err) {
			         console.log('An error occurred while retrieving token. ', err);
			       //  setTokenSentToServer(false);
			       });
			   }
			    
			      function setTokenSentToServer(token, device_id) {
			          window.localStorage.setItem('sentToServer', sent ? 1 : 0);
			      }
			    
			      function isTokenSentToServer() {
			          return window.localStorage.getItem('sentToServer') == 1;
			      }
			    
			      function saveToken(currentToken, deviceid) {
			        console.log('save token called');
			        $.ajax({
			          url: "{{route('user.save_token')}}",
			          method: 'put',
			          headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
			          data: {'device_id':deviceid, 'token':currentToken}
			        }).done(function(result){
			          console.log(result);
			        })
			      }

			      messaging.onMessage(function(payload) {
			        console.log("Message received. ", payload);
			        var notificationTitle = payload.notification.title;
			        const notificationOptions = {
			          body: payload.notification.body,
			          icon: payload.notification.icon,
			          image:  payload.notification.image,
			          click_action: payload.notification.click_action, // To handle notification click when notification is moved to notification tray
			              data: {
			                  click_action: payload.notification.click_action
			              }
			        };
			        
			        var notification = new Notification(notificationTitle,notificationOptions);
			        // var a = new Audio()
			        //  a.src =   "https://business.getzz.co.uk/public/got-it-done.mp3"
			        //  a.play()
			        // var audio = new Audio('public/got-it-done.mp3');
			        // audio.play();
			      });
			</script>
		</footer>
	</body>
</html>