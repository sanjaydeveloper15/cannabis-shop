@include('admin.inc.header')
<style type="text/css">
   .offcanvas-collapse, .offcanvas-collapse-noti{height: auto!important;padding-bottom: 20px;}
</style>
      <div class="admin-panel">
         <div class="container-fluid px-0">
            <div class="row no-gutters">
               <!-- Sidebar  -->
               @include('admin.inc.sidebar')
               <article class="col-lg-9">
                  <header class="p-3">
                     <div class="row rowMarginHalf colpad-half align-items-center justify-content-between">
                        <div class="col-sm-12 col-md-9 col-lg-10">
                        </div>
                        <div class="col-lg-2 d-flex align-items-center justify-content-end col-sm-12 col-md-3"> 
                           <img src="{{asset('public/admin/assets/images/2_manage_order_10.png')}}" class="img-fluid filter" id="navToggle" style="cursor: pointer;">
                           <img src="{{asset('public/admin/assets/images/2_manage_order_05.png')}}" class="img-fluid filter" id="navToggle-noti" style="cursor: pointer;">
                           <a href="{{route('admin/logout')}}"><img src="{{asset('public/admin/assets/images/2_manage_order_07.png')}}" class="img-fluid filter" style="cursor: pointer;"></a>
                        </div>
                     </div>
                  </header>
                  <div class="article-body store-bd-gy">
                     <div class="row rowMarginHalf colpad-half align-items-center justify-content-between">
                        <div class="col-sm-12 col-md-9 col-lg-9">
                           <ul class="nav nav-tabs mt-3 mb-4 d-inline-flex text-center group-tabs order-tab">
                              <li class="nav-item ">
                                 <a class="nav-link active" data-toggle="tab" onclick="loadOrderList(0)">New Orders</a>
                              </li>
                              <li class="nav-item ">
                                 <a class="nav-link" data-toggle="tab" onclick="loadOrderList(1)">In Process</a>
                              </li>
                              <li class="nav-item ">
                                 <a class="nav-link" data-toggle="tab" onclick="loadOrderList(2)">Shipped</a>
                              </li>
                              <li class="nav-item ">
                                 <a class="nav-link" data-toggle="tab" onclick="loadOrderList(3)">Completed</a>
                              </li>
                           </ul>
                        </div>
                        <div class="col-lg-3 d-flex align-items-center col-sm-12 col-md-3">
                           <div class="form-group flex-grow-1 mb-0">
                              <div class="custom-group-input pill left-icon">
                                 <input type="text" name="" id="keyword" class="form-control " placeholder="Search By Order ID">
                                 <span class="group-icon-left"><img src="{{asset('public/admin/assets/images/2_manage_order_16.png')}}" class="img-fluid srch"></span>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="tab-content mt-3" id="admin-orders-list">
                     </div>
                  </div>
               </article>
            </div>
         </div>
      </div>
      <div class="offcanvas-collapse">
         <img onClick="reload()" src="{{asset('public/admin/assets/images/2_manage_order_52.png')}}" class="refresh-icon">
         <h5 class="text-center mt-2">Filter</h5>
         <button type="button" class="close canvas-clse" id="navToggle">
         <span><img src="{{asset('public/admin/assets/images/close.png')}}"></span>
         </button>
         <form class="row">
            <div class="col-sm-12 mb-1 mt-3">
               <label>By Date</label>
            </div>
            {{-- <div class="form-group col-sm-6 mt-2">
               <span class="ordrd-flt">Today</span>
            </div>
            <div class="form-group col-sm-6 mt-2">
               <span class="ordrd-flt-unfill">Yesterday</span>
            </div> --}}
            <div class="form-group col-sm-6 mt-2">
               <div class="input-container">
                  <label>From</label>
                  <input type="date" id="start_date" class="form-control" placeholder="Start Date" style="font-size: 11px;">
                  {{-- <img src="{{asset('public/admin/assets/images/12_manage_customers_37.png')}}" class="input-img"> --}}
               </div>
            </div>
            <div class="form-group col-sm-6 mt-2">
               <div class="input-container">
                  <label>To</label>
                  <input type="date" id="end_date" class="form-control" placeholder="End Date" style="font-size: 11px;">
                  {{-- <img src="{{asset('public/admin/assets/images/12_manage_customers_37.png')}}" class="input-img"> --}}
               </div>
            </div>
            <div class="form-group col-sm-12 col-md-12 mb-5">
               <div class="wrapper">
                  <div class="range-slider">
                     <h5>By Price</h5>
                     <input type="text" class="js-amount-ad-slider" value="" />
                  </div>
               </div>
            </div>
            <div class="col-sm-12">
               <span type="submit" class="submit-btn pointer" onClick="applyFilter()">Apply</span>
            </div>
         </form>
      </div>
      <div class="modal fade" id="order-detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
             <div class="modal-body">
                <h4 class="text-center mt-2">Order Details</h4>
                <button type="button" class="close canvas-clse" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><img src="{{asset('public/website/img/close.png')}}"></span>
                </button>
                <section id="order-detail-content"></section>
             </div>
          </div>
       </div>
      </div>
@include('admin.inc.footer')
<script src="{{asset('public/admin/assets/js/amount-ad-slider.js')}}"></script>
<input type="hidden" name="" id="status" value="">
<input type="hidden" name="" id="from" value="0">
<input type="hidden" name="" id="to" value="1000">
<script>
   function loadOrderList(status,keyword='',from_amount='',to_amount='',start_date='',end_date='',is_filter=0){
      $("#status").val(status);
      keyword = (keyword!='') ? btoa(keyword) : keyword;
      $("#admin-orders-list").html('<div class="col-sm-12"><center><img src="'+loader+'"></center></div>');
      if(is_filter==1){
         $("#admin-orders-list").load(`{{route('admin/order/listing')}}/${status}/${keyword}?from_amount=${from_amount}&to_amount=${to_amount}&start_date=${btoa(start_date)}&end_date=${btoa(end_date)}`);
      }else{
         $("#admin-orders-list").load(`{{route('admin/order/listing')}}/${status}/${keyword}`);   
      }
   }

   setTimeout(function(){
      loadOrderList(0);
   },500);

   function orderDetails(order_id){
      $(`#order-detail`).modal('show');
      $(`#order-detail-content`).html(`<center><img src='${loader}' style='max-height:48px;'></center>`);
      $(`#order-detail-content`).load(`{{route('admin/order/details')}}/${order_id}`, function(response, status, xhr){
         if(status == 'error'){
            $(`#order-detail-content`).load(`{{route('admin/order/details')}}/${order_id}`);
         }
      });
   }

   function changeProductStatus(order_id,current_status){
      let msg = '';
      if(current_status==0){
         msg = "You want to move this order in process or dispatch products.";
      }else if(current_status==1){
         msg = "You want to move this order to shipped.";
      }else if(current_status==2){
         msg = "You want to move this order to completed.";
      }else{}
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
                   url: `{{route('admin/order/change_status')}}`,
                   type: "get",
                   headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
                   data: { "order_id" : order_id, "current_status" : current_status },
                   success: function(data){
                       Swal.fire(
                         'Done!',
                         'Status has been changed successfully!',
                         'success'
                       )
                       setTimeout(function(){
                         loadOrderList(current_status);
                     }, 1900);
                   }
               });

             //el.remove();
           }
         });
   }
    
   $('#keyword').keydown(function(){
       clearTimeout(timer); 
       timer = setTimeout(function(){
         let keyword = $("#keyword").val(), status = $("#status").val();
         (keyword.length > 1) ? loadOrderList(status,keyword) : loadOrderList(status);       
       }, 1000);
   });

   $(document).ready(function() {
      $('[data-toggle="offcanvas"], #navToggle').on('click', function () {
         $('.offcanvas-collapse').toggleClass('open')
      })
   });

   function applyFilter(){
      let from_amount = $("#from").val(), to_amount = $("#to").val(), start_date = $("#start_date").val(), status = $("#status").val(), end_date = $("#end_date").val();
      loadOrderList(status,'',from_amount,to_amount,start_date,end_date,1);
      $("#navToggle").click();
   }

   function reload(){
      location.reload();
   }

   let order_id = "{{$order_id}}";
   if(order_id!=''){
      orderDetails(order_id);
   }
</script>