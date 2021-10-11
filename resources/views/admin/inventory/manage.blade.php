@include('admin.inc.header')
<style type="text/css">
	.group-tabs .active{background: #b8d042!important;}
	.group-tabs .active a{color: #fff!important;}
</style>
<div class="admin-panel">
   <div class="container-fluid px-0">
      <div class="row no-gutters">
         <!-- Sidebar  -->
         @include('admin.inc.sidebar') 
         <article class="col-lg-9">
            <header class="p-3">
               <div class="row rowMarginHalf colpad-half align-items-center justify-content-between">
                  <div class="col-sm-6 col-md-8 col-lg-8">
                     
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
                  <div class="col-sm-12 col-md-12 col-lg-12">
                     <ul class="nav nav-tabs mt-3 mb-4 d-inline-flex text-center group-tabs ">
                        <li class="nav-item ">
                           <a class="nav-link active" onClick="loadProductsList(1)"  data-toggle="tab" href="#active-product">In Stock</a>
                        </li>
                        <li class="nav-item ">
                           <a class="nav-link" onClick="loadProductsList(2)" data-toggle="tab" href="#inactive-product">Few Stock</a>
                        </li>
                        <li class="nav-item ">
                           <a class="nav-link" onClick="loadProductsList(3)" data-toggle="tab" href="#inactive-product">Out of Stock</a>
                        </li>
                     </ul>
                  </div>
               </div>
               <div class="tab-content mt-3">
                  	<div id="active-product" class="tab-pane active">
                     	<div class="row">
                     	</div>
                 	</div>
               </div>
            </div>
         </article>
      </div>
   </div>
</div>

@include('admin.inc.footer')
<script src="{{asset('public/admin/assets/js/amount-ad-slider.js')}}"></script>
<input type="hidden" name="" id="type" value="">
<script type="text/javascript">
	
	  function loadProductsList(type,){
    	$("#type").val(type);
    	$("#active-product .row").html('<div class="col-sm-12"><center><img src="'+loader+'"></center></div>');
    	$("#active-product .row").load("{{route('admin/inventory/list')}}/"+type);
    }
    setTimeout(function(){
    	loadProductsList(1);
    },500);

</script>