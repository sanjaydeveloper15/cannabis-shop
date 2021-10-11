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
                     <div class="form-group flex-grow-1 mb-0">
                        <div class="custom-group-input pill left-icon">
                           <input type="text" name="" id="keyword" class="form-control " placeholder="Search Products Via Name">
                           <span class="group-icon-left"><img src="{{asset('public/admin/assets/images/2_manage_order_16.png')}}" class="img-fluid srch"></span>
                        </div>
                     </div>
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
                  <div class="col-sm-6 col-md-6 col-lg-6">
                     <ul class="nav nav-tabs mt-3 mb-4 d-inline-flex text-center group-tabs ">
                        <li class="nav-item ">
                           <a class="nav-link active" onClick="loadProductsList(1)"  data-toggle="tab" href="#active-product">Active Product</a>
                        </li>
                        <li class="nav-item ">
                           <a class="nav-link" onClick="loadProductsList(0)" data-toggle="tab" href="#inactive-product">Inactive Product</a>
                        </li>
                     </ul>
                  </div>
                  {{-- <div class="col-sm-3 col-md-3 col-lg-3">
                     <select id="category" class="form-control">
                       <option value="">Filter By Category</option>
                     </select>
                  </div> --}}
                  <div class="col-lg-3 d-flex  justify-content-end align-items-center col-sm-3 col-md-3">
                     <a href="{{route('admin/products',['type' => 'add'])}}" class="add-new-prdt">+ Add New</a>
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
<div class="offcanvas-collapse">
	{{-- <img src="{{asset('public/admin/assets/images/2_manage_order_52.png')}}" class="refresh-icon"> --}}
    <h5 class="text-center mt-2">Filter</h5>
	<button type="button" class="close canvas-clse" id="navToggle">
        <span><img src="{{asset('public/admin/assets/images/close.png')}}"></span>
    </button>
	<form class="row">
		<div class="form-group col-sm-12 col-md-12 mb-5">
			<div class="wrapper mt-4">
				<div class="range-slider">
					<h5>By Price</h5>
					<input type="text" class="js-amount-ad-slider" value="" />
				</div>
			</div>
		</div>
		<div class="col-sm-12 mb-1 mt-3">
			<div class="cate-filtr">
			<label>By Category</label>
				{{-- <span><a href="#" class="text-green">View All</a></span> --}}
			</div>
		</div>
		<div class="form-group col-sm-12">
			<div class="navx">
				<ul class="nav nav-tabs group-tabs">
					<!-- Main menu -->
					@foreach($categories as $list)
						<li onClick="filterCatSelect({{$list->id}})" class="filter_cat filter_cat_{{$list->id}}"><a href="#"><img src="{{imageBaseURL().$list->icon}}" class="img-fluid" style="max-height: 30px;"> {{ucwords($list->name)}}</a></li>
					@endforeach
				</ul>
			</div>
		</div>
		 
		<div class="col-sm-12 text-center">
			<a style="cursor: pointer;" class="submit-save" onClick="applyFilter()">Apply</a>
			{{-- <button type="submit" >Apply</button> --}}
		</div>
	</form>
</div>
@include('admin.inc.footer')
<script src="{{asset('public/admin/assets/js/amount-ad-slider.js')}}"></script>
<input type="hidden" name="" id="type" value="">
<input type="hidden" name="" id="from" value="0">
<input type="hidden" name="" id="to" value="1000">
<input type="hidden" name="" id="filter_cat_id" value="">
<script type="text/javascript">
	function filterCatSelect(id){
		$(".filter_cat").removeClass('active'); $(".filter_cat_"+id).addClass('active');
		$("#filter_cat_id").val(id);
	}

	function applyFilter(){
		let from_amount = $("#from").val(), to_amount = $("#to").val(), cat_id = $("#filter_cat_id").val(), type = $("#type").val();
		loadProductsList(type,'0',from_amount,to_amount,cat_id)
	}
	function loadProductsList(type,keyword='',from_amount='',to_amount='', cat_id=''){
    	$("#type").val(type);
     	keyword = (keyword!='') ? btoa(keyword) : keyword;
    	$("#active-product .row").html('<div class="col-sm-12"><center><img src="'+loader+'"></center></div>');
    	$("#active-product .row").load("{{route('admin/product/listing')}}/"+type+"/"+keyword+"/"+from_amount+"/"+to_amount+"/"+cat_id);
    }
    setTimeout(function(){
    	loadProductsList(1);
    },500);

    $('#keyword').keydown(function(){
	    clearTimeout(timer); 
	    timer = setTimeout(function(){
	    	let keyword = $("#keyword").val(), type = $("#type").val();
        	(keyword.length > 1) ? loadProductsList(type,keyword) : loadProductsList(type);   		
	    }, 1000);
	});

	$(document).ready(function() {
  		$('[data-toggle="offcanvas"], #navToggle').on('click', function () {
    		$('.offcanvas-collapse').toggleClass('open')
  		})
  	});
</script>