@include('admin.inc.header')
<div class="admin-panel">
   <div class="container-fluid px-0">
      <div class="row no-gutters">
         @include('admin.inc.sidebar')
         <article class="col-lg-9">
            <header class="p-3">
               <div class="row rowMarginHalf colpad-half align-items-center justify-content-between">
                  <div class="col-sm-12 col-md-9 col-lg-10">
                  </div>
                  <div class="col-lg-2 d-flex align-items-center col-sm-12 col-md-3  justify-content-end">	
                     <img src="{{asset('public/admin/assets/images/2_manage_order_05.png')}}" class="img-fluid filter" id="navToggle-noti" style="cursor: pointer;">
                     <a href="{{route('admin/logout')}}"><img src="{{asset('public/admin/assets/images/2_manage_order_07.png')}}" class="img-fluid filter" style="cursor: pointer;"></a>
                  </div>
               </div>
            </header>
            <div class="article-body store-bd-gy">
            	<div class="row rowMarginHalf colpad-half align-items-center justify-content-between">
	                <div class="col-sm-6 col-md-5 col-lg-5">
	                   <ul class="nav nav-tabs mb-4 d-inline-flex text-center group-tabs ">
		                  <li class="nav-item ">
		                     <a class="nav-link active" onClick="loadCustomerList(1)" data-toggle="tab" href="#active-costomer">Active</a>
		                  </li>
		                  <li class="nav-item ">
		                     <a class="nav-link" onClick="loadCustomerList(0)" data-toggle="tab" href="#inactive-costomer">Inactive</a>
		                  </li>
		               </ul>
	                </div>
	                <div class="col-sm-6 col-md-7 col-lg-7" style="margin-top: -24px;">
	                   <div class="form-group flex-grow-1 mb-0">
                          <div class="custom-group-input pill left-icon">
                             <input type="text" id="keyword" name="" class="form-control " placeholder="Search Customers Via Name, Email">
                             <span class="group-icon-left"><img src="{{asset('public/admin/assets/images/2_manage_order_16.png')}}" class="img-fluid srch"></span>
                          </div>
                       </div>
	                </div>
	            </div>
               
               <div class="tab-content">
                  <div id="active-costomer" class="tab-pane active">
                     <div class="table-responsive text-center zebra" id="customer-list">
					 </div>
                  </div>
               </div>
            </div>
         </article>
      </div>
   </div>
</div>
@include('admin.inc.footer')
<input type="hidden" name="" id="type" value="">
<script type="text/javascript">
	$('#keyword').keydown(function(){
	    clearTimeout(timer); 
	    timer = setTimeout(function(){
	    	let keyword = $("#keyword").val(), type = $("#type").val();
        	(keyword.length > 1) ? loadCustomerList(type,keyword) : loadCustomerList(type);   		
	    }, 1000);
	});

	function loadCustomerList(type,keyword=''){
    	$("#type").val(type);
      	keyword = (keyword!='') ? btoa(keyword) : keyword;
    	$("#customer-list").html('<div class="col-sm-12"><center><img src="'+loader+'"></center></div>');
    	$("#customer-list").load("{{route('admin/customers/list')}}/"+type+"/"+keyword);
    }
    setTimeout(function(){
    	loadCustomerList(1);
    },500);
</script>