      <!-- Sidebar  -->
         <div class="col-lg-3 store-sidebar admin-sidebar">
            <div class="shadow-part">
                  <a class="navbar-brand bg-none px-3 mx-lg-auto d-lg-block py-lg-4" href="#">
                     <img src="{{asset('public/admin/assets/images/logo.png')}}" class="img-fluid" alt="img">
                  </a>
               <button class="btn btn-greens float-right mr-3 d-lg-none" data-target='#sidebar' data-toggle="collapse"> <i class="fa fa-bars">	</i> Menus</button>    
               <nav class=" collapse d-lg-block" id="sidebar">
                  <ul class="list-unstyled mb-0">
                     <li>
                        <a href="{{route('admin/manage_products')}}" @if($page_name=='products') class="active" @endif>
                           <div><img src="{{asset('public/admin/assets/images/2_manage_order_54.png')}}" class="img-fluid sidebar-icon"></div>
                           <span> Manage Products </span>
                        </a>
                     </li>
                     <li>
                        <a href="{{route('admin/manage_customers')}}" @if($page_name=='customers') class="active" @endif>
                           <div><img src="{{asset('public/admin/assets/images/2_manage_order_63.png')}}" class="img-fluid sidebar-icon"></div>
                           <span>  Manage Customers</span>
                        </a>
                     </li>
                     <li>
                        <a href="{{route('admin/categories')}}" @if($page_name=='category') class="active" @endif>
                           <div><img @if($page_name=='category') src="{{asset('public/admin/assets/images/2_manage_order_77.png')}}" @else src="{{asset('public/admin/assets/images/2_manage_order_76.png')}}" @endif class="img-fluid sidebar-icon"></div>
                           <span> Manage Categories </span>
                        </a>
                     </li>
                     <li>
                        <a href="{{route('admin/device_types')}}" @if($page_name=='device_type') class="active" @endif>
                           <div><img @if($page_name=='device_type') src="{{asset('public/admin/assets/images/device_type_active.png')}}" @else src="{{asset('public/admin/assets/images/device_type_white.png')}}" @endif class="img-fluid sidebar-icon"></div>
                           <span> Manage Device Types </span>
                        </a>
                     </li>
                     <li>
                        <a href="{{route('admin/strain_types')}}" @if($page_name=='strain_types') class="active" @endif>
                           <div><img @if($page_name=='strain_types') src="{{asset('public/admin/assets/images/strain_active.png')}}" @else src="{{asset('public/admin/assets/images/strain_white.png')}}" @endif class="img-fluid sidebar-icon"></div>
                           <span> Manage Strain Types </span>
                        </a>
                     </li>
                     <li>
                        <a href="{{route('admin/manage_brands')}}" @if($page_name=='brands') class="active" @endif>
                           <div><img @if($page_name=='brands') src="{{asset('public/admin/assets/images/brands_active.png')}}" @else src="{{asset('public/admin/assets/images/brands_white.png')}}" @endif class="img-fluid sidebar-icon"></div>
                           <span> Manage Brands </span>
                        </a>
                     </li>
                  </ul>
               </nav>
            </div>
         </div>