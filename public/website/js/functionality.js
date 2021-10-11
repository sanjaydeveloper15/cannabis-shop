
/*
| JS/ES6/AJAX  
| Laravel
| @sanjaykumarwebs
| @dev
*/
var base_url = $(`#base_url`).val();

function makeDiscountPrice(original,disc_type,disc){
	let price = 0;
    if(disc_type==2){
      price = original - disc;
    }else if(disc_type==1){
      price = original - (original * disc/100);
    }
    price = (price < 0) ? 0 : price;
    return Number(price.toFixed(2));
}

function changeQuantity(e,product_id){
	let product_cost_id = e.value, amount = '', quantity=1;
	$(`.quantity_${product_id} , .price_${product_id}`).html('...');
	$(`.add_to_cart_${product_id}`).hide();
	$.ajax({
		type: "get",
		url: `${base_url}product/get_cost`,
		data: {"product_cost_id": product_cost_id},
		success:function(obj){
			if(obj.product.product_discount){
				//console.log('is discount');
				$(`.price_${product_id}`).html(`$ ${makeDiscountPrice(obj.cost,obj.product.product_discount.type,obj.product.product_discount.discount)} <strike><small>$ ${obj.cost}</small></strike>`);
			}else{
				//console.log('not discount');
				$(`.price_${product_id}`).html(`$ ${obj.cost}`);
			}
			if(obj.available_stock > 5){
				$("#stock-status").html('<span style="color: #b8d042;font-weight: 600;">In Stock</span>');
			}else{
				$("#stock-status").html('<span style="color: red;font-weight: 600;">Few Stocks Left Only</span>');	
			}
			amount = obj.cost;
			$(`.quantity_${product_id}`).html(` ${obj.quantity} ${obj.quantity_option.name}`);
		}
	});
	$.ajax({
		type: "get",
		url: `${base_url}user/check_cart`,
		data: {"product_cost_id": product_cost_id},
		success:function(res){
			if(res){
				$(`.currentQuantity_${product_id}`).val(res.quantity);
				$(`.quantityBtn_${product_id}`).show();
			}else{
				$(`.addToCartBtn_${product_id} .add-cart`).html('+ Add to Cart');
				$(`.addToCartBtn_${product_id}`).show();
			}
		}
	});
	$(`#currentCostId_${product_id}`).val(product_cost_id);//category
	$(`#currentCostId2_${product_id}`).val(product_cost_id);//latest
	$(`#product_cost_id`).val(product_cost_id);
	$(`#quantity`).val(quantity);
}

function addToCart(e){//type empty new add, 1 plus, 2 minus
	//console.log($(e).data('product_cost_id'));
	let type = $(e).data('type'),
		product_id = $(e).data('product_id'),
		fromWhere = $(e).data('fromWhere'),//1 from category, 2 from latest
		product_cost_id = $(`#currentCostId_${product_id}`).val(),
		quantity = $(e).data('quantity');
	product_cost_id = (fromWhere==2) ? $(`#currentCostId2_${product_id}`).val() : product_cost_id;
	if(type==''){$(e).html('Adding...');}
	//console.log(`type ${type}`);
	//console.log(product_cost_id);
	$.ajax({
		type: "post",
		url: `${base_url}user/add_to_cart`,
		data: {"product_cost_id": product_cost_id, "quantity": quantity, "type": type},
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success:function(res){
			if(res==0){//means out of stock
				alert('This item is out of stock now.');
				if(type==''){$(e).html('Add to Cart');}
				return false;
			}
			if(type==''){
				$(`.addToCartBtn_${product_id}`).hide();
				$(`.quantityBtn_${product_id}`).show();	
			}
			if(!res){//deleted from 1 to 0 quantity
				$(`.addToCartBtn_${product_id} .add-cart`).html('+ Add to Cart');
				$(`.quantityBtn_${product_id}`).hide();
				$(`.addToCartBtn_${product_id}`).show();
			}else{
				//alert(res.quantity);
				$(`.currentQuantity_${product_id}`).val(res.quantity);
			}
			set_cart_count();
		}
	});

}

function buyNow(e){
	let type = $(e).data('type'),
		product_id = $(e).data('product_id'),
		fromWhere = $(e).data('fromWhere'),//1 from category, 2 from latest
		product_cost_id = $(`#currentCostId_${product_id}`).val(),
		quantity = $(e).data('quantity');
	product_cost_id = (fromWhere==2) ? $(`#currentCostId2_${product_id}`).val() : product_cost_id;
	
	//console.log(`type ${type}`);
	//console.log(product_cost_id);
	$.ajax({
		type: "post",
		url: `${base_url}user/add_to_cart`,
		data: {"product_cost_id": product_cost_id, "quantity": quantity, "type": type},
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success:function(res){
			window.location.href = `${base_url}user/checkout`;
		}
	});
}

$('#open-cart-popup').mouseover(function() {
  $(`.b-dropdown-block`).hide();
});

function openCartPopup(){
	$(`#cart-popup-data`).html('<h5 style="margin-left:10px;">Loading...</h5>');
  	$(`#cart-popup-data`).load(`${base_url}user/cart_popup_data`);	
}

function openNotifPopup(){
	$(`#popup-notif`).html('<h5 style="margin-left:10px;">Loading...</h5>');
  	$(`#popup-notif`).load(`${base_url}user/popup_notif`);	
  	$(`#open-notif-popup .badge`).html(0);
}

function removeCartItem(rowId){
	var isCustomerLogin = $("#isCustomerLogin").val(),
		tableName = (isCustomerLogin==1) ? 'carts' : 'guest_carts';
	$.ajax({
		type: "post",
		url: `${base_url}user/deleteRow`,
		data: {"tableName": tableName, "rowId": rowId},
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success:function(res){
			set_cart_count();
			$(`#cart-popup-data`).load(`${base_url}user/cart_popup_data`);	
			loadHomeProducts();
			if (typeof loadProductList == 'function') { 
			  loadProductList(); 
			}
			if (typeof loadCartItems == 'function') { 
			  loadCartItems(); 
			}
		}
	});
}

function set_cart_count(){
	$.ajax({
		type: "get",
		url: `${base_url}user/cart_count`,
		success:function(res){
			$(`#open-cart-popup .badge`).html(res);
		}
	});
}

function set_notif_count(){
	$.ajax({
		type: "get",
		url: `${base_url}user/notif_count`,
		success:function(res){
			$(`#open-notif-popup .badge`).html(res);
		}
	});
}

function increaseItemQuantity(product_cost_id){
	$.ajax({
		type: "get",
		url: `${base_url}user/cart/inc_decr_item`,
		data: {'product_cost_id': product_cost_id, 'type': 1},
		success:function(res){
			$(`#cart-popup-data`).load(`${base_url}user/cart_popup_data`);	
			set_cart_count();
			loadHomeProducts();
			if (typeof loadProductList == 'function') { 
			  loadProductList(); 
			}
			if (typeof loadCartItems == 'function') { 
			  loadCartItems(); 
			}
		}
	});
}

function decreaseItemQuantity(product_cost_id){
	$.ajax({
		type: "get",
		url: `${base_url}user/cart/inc_decr_item`,
		data: {'product_cost_id': product_cost_id, 'type': 2},
		success:function(res){
			$(`#cart-popup-data`).load(`${base_url}user/cart_popup_data`);	
			set_cart_count();
			loadHomeProducts();
			if (typeof loadProductList == 'function') { 
			  loadProductList(); 
			}
			if (typeof loadCartItems == 'function') { 
			  loadCartItems(); 
			}
		}
	});
}



function loadHomeProducts(){
    $(`#home-latest-products`).load(`${base_url}home/latest_products`,function(){
        $(`#home-catwise-products`).load(`${base_url}home/catwise_products`);
    });
}

$(window).scroll(function(event){
   let st = $(this).scrollTop(),
   	   is_load = $(`#is_home_products`).val();
   if (st > 70 && is_load==0){
       $(`#is_home_products`).val(1);
       loadHomeProducts();
   }
});

var path = `${base_url}search-product`;
$('#search_product').typeahead({
    source:  function (query, process) {
        return $.get(path, { query: query }, function (data) {
            return process(data);
        });
    },
    highlighter: function (item, data) {
        var parts = item.split('#'),
            html = '<div class="row">';
            //html += '<div class="col-md-4">';
            //html += `<img src='${base_url}storage/app/${data.images.path}' class='search-product-img'>`;
            //html += '</div>';
            html += '<div class="col-md-12 pl-0" style="width:100%;color:#000!important;">';
            html += '<span style="font-size:21px;">'+data.name+'</span>';
            //html += '<p class="m-0">'+data.category.name+'</p>';
            html += '</div>';
            html += '</div>';

        return html;
    },
    updater: function(data) {
        // code that redirects the user if they click the selection
        console.log(data.name);
        window.location.href = `${base_url}product-details/${data.id}`;
        
    },
});


function addValueToStringWithComma(list,value){
	return (list=='') ? value : `${list},${value}`;
}
function doLogin(){
	$(`#cannabis-modal-right`).load(`${base_url}user/login`);delayModal();
}
function doVerifyOTP(){
	$(`#cannabis-modal-right`).load(`${base_url}guest/verify_otp`);delayModal();
}
function doForgotPassword(){
	$(`#cannabis-modal-right`).load(`${base_url}user/forgot_password`);delayModal();
}
function doSetPassword(){
	$(`#cannabis-modal-right`).load(`${base_url}user/set_new_password`);delayModal();	
}
function delayModal(){
	setTimeout(function(){
		$("#cannabis-modal").modal('show');	
	},900);
}
function doSignup(){
	$(`#cannabis-modal-right`).load(`${base_url}user/signup`);delayModal(); 
}
// $('#search_product').on('keydown', function(e) {
//   if (e.keyCode == 13) {
//     var ta = $(this).data('typeahead');
//     var val = ta.$menu.find('.active').data('value');
//     if (!val){
//     	alert(val);
//       //$('#your-form').submit();
//     }
//   }
// });


function placeOrder(){
	let address_id = $(`#checkout-user-address input[type='radio'][name='address']:checked`).val(),
		payment_mode = $(`#checkout-payment-mode input[type='radio'][name='payment_mode']:checked`).val();
	if(!address_id){return alert('Please select address to proceed.');}
	if(!payment_mode){return alert('Please select payment mode to proceed.');}
	$('#processingModal').modal({
        backdrop: 'static',
        keyboard: false
   	});
	$.ajax({
		type: "post",
		url: `${base_url}user/place_order`,
		data: {"address_id": address_id, "payment_mode": payment_mode},
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success:function(res){
			console.log(res);alert(res.errorMsg);
			if(res.errorCode==3){
				window.location.href = `${base_url}user/account/2`;
			}else{
				location.reload();
			}
		}
	});
}

function orderDetails(order_id){
	$(`#order-detail-content`).html(`<center><img src='${loader}'></center>`);
	$(`#order-detail`).modal();
	$(`#order-detail-content`).load(`${base_url}order/details/${order_id}`);
}

function singleOrder(order_id,notif_id){
	$.ajax({
		type: "get",
		url: `${base_url}user/read_notif/${notif_id}`,
		success:function(res){
			window.location.href = `${base_url}user/account/2/${order_id}`;
		}
	});
}

setTimeout(function(){
	set_cart_count();	
},500);

setTimeout(function(){
	set_notif_count();	
},1500);

