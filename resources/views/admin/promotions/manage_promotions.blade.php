@include('admin.inc.header')
<div class="admin-panel">
   <div class="container-fluid px-0">
      <div class="row no-gutters">
         <!-- Sidebar  -->
         @include('admin.inc.sidebar')
         <article class="col-lg-9">
            <header class="p-3">
               <div class="row rowMarginHalf colpad-half align-items-center justify-content-between">
                  <div class="col-sm-6 col-md-9 col-lg-10">
                     {{-- <ul class="nav nav-tabs mt-3 mb-4 d-inline-flex text-center group-tabs ">
                        <li class="nav-item ">
                           <a class="nav-link active"  data-toggle="tab" href="#active-promotions">Active</a>
                        </li>
                        <li class="nav-item ">
                           <a class="nav-link" data-toggle="tab" href="#inactive-promotions">Inactive</a>
                        </li>
                     </ul> --}}
                  </div>
                  <div class="col-lg-2 d-flex align-items-center col-sm-6 col-md-3  justify-content-end">	
                     <img src="{{asset('public/admin/assets/images/2_manage_order_05.png')}}" class="img-fluid filter" id="navToggle-noti" style="cursor: pointer;">
                     <a href="{{route('admin/logout')}}"><img src="{{asset('public/admin/assets/images/2_manage_order_07.png')}}" class="img-fluid filter" style="cursor: pointer;"></a>
                  </div>
               </div>
            </header>
            <div class="article-body store-bd-gy">
               <div class="tab-content">
                  <div id="active-promotions" class="tab-pane active">
                     <div class="row rowMarginHalf colpad-half align-items-center justify-content-between">
                        <div class="col-sm-12 col-md-7 col-lg-7 mb-4d-flex align-items-center mb-4 pt-1">
                           <p class="modal-title">Offers on Category</p>
                        </div>
                        <div class="col-lg-4 d-flex justify-content-end align-items-center col-sm-12 col-md-4 mb-4">
                           <div class="form-group flex-grow-1 mb-0 pt-1">
                              <div class="custom-group-input pill left-icon">
                                 <input type="text" name="" id="search-category" class="form-control " placeholder="Search Categories">
                                 <span class="group-icon-left"><img src="{{asset('public/admin/assets/images/2_manage_order_16.png')}}" class="img-fluid srch"></span>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="row" id="categories">
                     </div>
                     <div class="row rowMarginHalf colpad-half align-items-center justify-content-between mt-5">
                        <div class="col-sm-12 col-md-7 col-lg-7 mb-4d-flex align-items-center mb-4 pt-1">
                           <p class="modal-title">Offers on Products</p>
                        </div>
                        <div class="col-lg-4 d-flex justify-content-end align-items-center col-sm-12 col-md-4 mb-4">
                           <div class="form-group flex-grow-1 mb-0 pt-1">
                              <div class="custom-group-input pill left-icon">
                                 <input type="text" name="" id="product-search" class="form-control " placeholder="Search Products">
                                 <span class="group-icon-left"><img src="{{asset('public/admin/assets/images/2_manage_order_16.png')}}" class="img-fluid srch"></span>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="row" id="products">
                     </div>
                  </div>
               </div>
            </div>
         </article>
      </div>
   </div>
</div>
@include('admin.inc.footer')	
<input type="hidden" id="type" name="" value="1">
<script type="text/javascript">
	function loadProductsList(type,keyword=''){
    	$("#type").val(type);
     	keyword = (keyword!='') ? btoa(keyword) : keyword;
    	$("#products").html('<div class="col-sm-12"><center><img src="'+loader+'" style=max-width:92px;></center></div>');
    	$("#products").load("{{route('admin/manage_promotions/products')}}/"+type+"/"+keyword);
    }

    function loadCategoryList(type,keyword=''){
    	$("#type").val(type);
    	keyword = (keyword!='') ? btoa(keyword) : keyword;
    	$("#categories").html('<div class="col-sm-12"><center><img src="'+loader+'" style=max-width:92px;></center></div>');
    	$("#categories").load("{{route('admin/manage_promotions/categories')}}/"+type+"/"+keyword);
    }

    setTimeout(function(){
    	loadCategoryList(1);
    	setTimeout(function(){
    		loadProductsList(1);	
    	},500);
    },500);

    $('#product-search').keydown(function(){
	    clearTimeout(timer); 
	    timer = setTimeout(function(){
	    	let keyword = $("#product-search").val(), type = $("#type").val();
        	(keyword.length > 1) ? loadProductsList(type,keyword) : loadProductsList(type);   		
	    }, 1000);
	});

	$('#search-category').keydown(function(){
	    clearTimeout(timer); 
	    timer = setTimeout(function(){
	    	let keyword = $("#search-category").val(), type = $("#type").val();
        	(keyword.length > 1) ? loadCategoryList(type,keyword) : loadCategoryList(type);   		
	    }, 1000);
	});
</script>	
