<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ChargeController;
use App\Http\Controllers\CatagoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerLoginController;
use App\Http\Controllers\CustomerRegisterController;
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\CustomerMessageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Frontendcontroller;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\SubcatagoryController;
use App\Http\Controllers\Usercontroller;
use App\Http\Controllers\WishController;
use App\Http\Controllers\RoleManagerController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|sss
*/

//  ================================= frontend =======================================
//  ================================= frontend =======================================

Route::get('/', [Frontendcontroller::class, 'home'])->name('front.home');
Route::get('/shop', [Frontendcontroller::class, 'shop'])->name('shop');
Route::get('/about_us', [Frontendcontroller::class, 'about_us'])->name('about_us');
Route::get('/contact', [Frontendcontroller::class, 'contact'])->name('contact');
Route::get('/catagory_product/{catagory_id}', [Frontendcontroller::class, 'catagory_product'])->name('catagory_product');
Route::get('/product/details/{slug}', [Frontendcontroller::class, 'product_details'])->name('product.details');
Route::post('/getSize', [Frontendcontroller::class, 'getSize']);

// customer login & register =======
Route::get('/customer/login/register', [Frontendcontroller::class, 'customer_login_register'])->name('customer.login.register');
Route::post('/customer/register', [CustomerRegisterController::class, 'customer_register'])->name('customer.register');
Route::post('/customer/login', [CustomerLoginController::class, 'customer_login'])->name('customer.login');
Route::get('/customer/logout', [CustomerLoginController::class, 'customer_logout'])->name('customer.logout');


//login with Github account =========
Route::get('/login/github', [CustomerLoginController::class, 'redirectToGithub'])->name('login.github');
Route::get('/login/github/callback', [CustomerLoginController::class, 'handleGithubCallback']);


//login with Google account =========
Route::get('/login/google', [CustomerLoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/login/google/callback', [CustomerLoginController::class, 'handleGoogleCallback']);


// customer profile ===========
Route::get('/customer/profile', [CustomerProfileController::class, 'customer_profile'])->name('customer.profile');
Route::post('/customer/profile/udpate', [CustomerProfileController::class, 'customer_profile_udpate'])->name('customer.profile_udpate');
Route::get('/customer/order_complete', [CustomerProfileController::class, 'customer_order_complete'])->name('customer.order_complete');
Route::get('/customer/order_failed', [CustomerProfileController::class, 'customer_order_failed'])->name('customer.order_failed');
Route::get('/customer/customer_order', [CustomerProfileController::class, 'customer_order'])->name('customer.customer_order');
Route::get('/customer/customer_wish', [CustomerProfileController::class, 'customer_wish'])->name('customer.customer_wish');
Route::get('/Download/invoice/{order_id}', [CustomerProfileController::class, 'Download_invoice'])->name('Download_invoice');


// cart ===============
Route::get('/cart', [CartController::class, 'cart'])->name('cart');
Route::post('/cart/store', [CartController::class, 'cart_store'])->name('cart.store');
Route::post('/cart/update', [CartController::class, 'cart_update'])->name('cart.update');
Route::get('/cart/remove/{cart_id}', [CartController::class, 'cart_remove'])->name('cart.remove');
Route::post('/cart/remove/all', [CartController::class, 'cart_remove_all_checked'])->name('cart.remove_all_checked');

// wishlist ===============
Route::post('/wish/store', [WishController::class, 'wish_store'])->name('wish.store');
Route::get('/wish/store_again/{product_id}', [WishController::class, 'wish_store_again'])->name('wish.store_again');
Route::get('/wish/remove/{wish_id}', [WishController::class, 'wish_remove'])->name('wish.remove');
Route::post('/wish/remove/all', [WishController::class, 'wish_remove_all_checked'])->name('wish.remove_all_checked');

// Checkout ===============
Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::post('/getCity', [CheckoutController::class, 'getCity']);
Route::post('/order/store', [CheckoutController::class, 'order_store'])->name('order.store');
Route::post('/review/update/{product_id}', [CheckoutController::class, 'review_update'])->name('review.update');

// SSLCOMMERZ Start ==============
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::get('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);

// Stripe ==============
Route::controller(StripePaymentController::class)->group(function(){
    Route::get('stripe', 'stripe');
    Route::post('stripe', 'stripePost')->name('stripe.post');
});

// customer password reset ===========
Route::get('/customer/password_reset', [CustomerLoginController::class, 'customer_password_reset'])->name('customer.password_reset');
Route::post('/customer/password_reset_request', [CustomerLoginController::class, 'customer_password_reset_request'])->name('customer.password_reset_request');
Route::get('/customer/password_reset_form/{token}', [CustomerLoginController::class, 'customer_password_reset_form'])->name('customer.password_reset_form');
Route::post('/customer/password_reset_confirm', [CustomerLoginController::class, 'customer_password_reset_confirm'])->name('customer.password_reset_confirm');


// customer email verify ==============
Route::get('/customer/email_verify/{token}', [CustomerRegisterController::class, 'customer_email_verify'])->name('customer.email_verify');

// 404 page ====================
Route::get('/404', [Frontendcontroller::class, 'error_404'])->name('404');

// contact page ================
Route::post('/contact/message', [Frontendcontroller::class, 'contact_message'])->name('contact_message');






//  ================================= backend =======================================
//  ================================= backend =======================================

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// users =======
Route::get('/user', [Usercontroller::class, 'user'])->name('user');
Route::get('/user/delete/{user_id}', [Usercontroller::class, 'user_delete'])->name('user.delete');
Route::post('/user/delete/all', [Usercontroller::class, 'user_delete_all'])->name('user.delete_all');

// profile =======
Route::get('/profile', [Usercontroller::class, 'profile'])->name('profile');
Route::post('/profile/info_update', [Usercontroller::class, 'profile_update'])->name('profile.update');
Route::post('/profile/password_update', [Usercontroller::class, 'password_update'])->name('password.update');
Route::post('/profile/image_update', [Usercontroller::class, 'image_update'])->name('image.update');

// catagoty =======
Route::get('/catagory', [CatagoryController::class, 'catagory'])->name('catagory');
Route::post('/catagory/store', [CatagoryController::class, 'catagory_store'])->name('catagory.store');
Route::get('/catagory/delete/{catagory_id}', [CatagoryController::class, 'catagory_delete'])->name('catagory.delete');
Route::get('/catagory/edit/{catagory_id}', [CatagoryController::class, 'catagory_edit'])->name('catagory.edit');
Route::post('/catagory/update', [CatagoryController::class, 'catagory_update'])->name('catagory.update');
Route::get('/catagory/restore/{catagory_id}', [CatagoryController::class, 'catagory_restore'])->name('catagory.restore');
Route::get('/catagory/force_delete/{catagory_id}', [CatagoryController::class, 'catagory_force_delete'])->name('catagory.force_delete');
Route::post('/catagory/delete/all', [CatagoryController::class, 'catagory_delete_all'])->name('catagory.delete_all');
Route::post('/catagory/restore_delete/all', [CatagoryController::class, 'catagory_restore_delete_all_trashed'])->name('catagory.restore_delete_all_trashed');


// subcatagory =======
Route::get('/subcatagory', [SubcatagoryController::class, 'subcatagory'])->name('subcatagory');
Route::post('/subcatagory/store', [SubcatagoryController::class, 'subcatagory_store'])->name('subcatagory.store');
Route::get('/subcatagory/delete/{subcatagory_id}', [SubcatagoryController::class, 'subcatagory_delete'])->name('subcatagory.delete');
Route::get('/subcatagory/force_delete/{subcatagory_id}', [SubcatagoryController::class, 'subcatagory_force_delete'])->name('subcatagory.force_delete');
Route::get('/subcatagory/restore/{subcatagory_id}', [SubcatagoryController::class, 'subcatagory_restore'])->name('subcatagory.restore');
Route::get('/subcatagory/edit/{subcatagory_id}', [SubcatagoryController::class, 'subcatagory_edit'])->name('subcatagory.edit');
Route::post('/subcatagory/update', [SubcatagoryController::class, 'subcatagory_update'])->name('subcatagory.update');
Route::post('/subcatagory/delete/all', [SubcatagoryController::class, 'subcatagory_delete_all'])->name('subcatagory.delete_all');
Route::post('/subcatagory/restore_delete/all', [SubcatagoryController::class, 'subcatagory_restore_delete_all_trashed'])->name('subcatagory.restore_delete_all_trashed');


// product ==========
Route::get('/product', [ProductController::class, 'product'])->name('product');
Route::get('/product/trashed', [ProductController::class, 'product_trashed'])->name('product.trashed');
Route::get('/product/add', [ProductController::class, 'product_add'])->name('product.add');
Route::get('/product/variation', [ProductController::class, 'product_variation'])->name('product.variation');
Route::post('/product/store', [ProductController::class, 'product_store'])->name('product.store');
Route::post('/color/store', [ProductController::class, 'color_store'])->name('color.store');
Route::post('/size/store', [ProductController::class, 'size_store'])->name('size.store');
Route::post('/inventory/store', [ProductController::class, 'inventory_store'])->name('inventory.store');
Route::post('/inventory/update', [ProductController::class, 'inventory_update'])->name('inventory.update');
Route::post('/inventory/all_update', [ProductController::class, 'inventory_all_update'])->name('inventory.all_update');
Route::get('/inventory/delete/{inventory_id}', [ProductController::class, 'inventory_delete'])->name('inventory.delete');
Route::post('/product/update', [ProductController::class, 'product_update'])->name('product.update');
Route::get('/product/edit/{product_id}', [ProductController::class, 'product_edit'])->name('product.edit');
Route::get('/product/delete/{product_id}', [ProductController::class, 'product_delete'])->name('product.delete');
Route::post('/product/delete/checked', [ProductController::class, 'check_delete_pro'])->name('product.check_delete');
Route::post('/product/restore_delete/checked', [ProductController::class, 'check_restore_delete'])->name('product.check_restore_delete');
Route::get('/product/restore/{product_id}', [ProductController::class, 'product_restore'])->name('product.restore');
Route::get('/product/force_delete/{product_id}', [ProductController::class, 'product_force_delete'])->name('product.force_delete');
Route::get('/product/inventory/{product_id}', [ProductController::class, 'product_inventory'])->name('product.inventory');
Route::post('/getSubcatagory', [ProductController::class, 'getSubcatagory']);


// coupon ==========
Route::get('/coupon', [CouponController::class, 'coupon'])->name('coupon');
Route::get('/coupon/trashed', [CouponController::class, 'coupon_trashed'])->name('coupon.trashed');
Route::get('/coupon/add', [CouponController::class, 'coupon_add'])->name('coupon.add');
Route::post('/coupon/store', [CouponController::class, 'coupon_store'])->name('coupon.store');
Route::get('/coupon/delete/{coupon_id}', [CouponController::class, 'coupon_delete'])->name('coupon.delete');
Route::get('/coupon/edit/{coupon_id}', [CouponController::class, 'coupon_edit'])->name('coupon.edit');
Route::post('/coupon/update', [CouponController::class, 'coupon_update'])->name('coupon.update');
Route::get('/coupon/restore/{coupon_id}', [CouponController::class, 'coupon_restore'])->name('coupon.restore');
Route::get('/coupon/force_delete/{coupon_id}', [CouponController::class, 'coupon_force_delete'])->name('coupon.force_delete');
Route::post('/coupon/delete/all', [CouponController::class, 'coupon_delete_all'])->name('coupon.delete_all');
Route::post('/coupon/restore_delete/all', [CouponController::class, 'coupon_restore_delete_all_trashed'])->name('coupon.restore_delete_all_trashed');


// delivery charge ==========
Route::get('/charge', [ChargeController::class, 'charge'])->name('charge');
Route::post('/charge/store', [ChargeController::class, 'charge_store'])->name('charge.store');
Route::post('/charge/update', [ChargeController::class, 'charge_update'])->name('charge.update');
Route::get('/charge/edit/{delivery_charge_id}', [ChargeController::class, 'charge_edit'])->name('charge.edit');
Route::get('/charge/delete/{delivery_charge_id}', [ChargeController::class, 'charge_delete'])->name('charge.delete');
Route::get('/charge/restore/{delivery_charge_id}', [ChargeController::class, 'charge_restore'])->name('charge.restore');
Route::get('/charge/force_delete/{delivery_charge_id}', [ChargeController::class, 'charge_force_delete'])->name('charge.force_delete');


// customer orders ============
Route::get('/order/list', [OrderController::class, 'order_list'])->name('order_list');
Route::get('/order/details/{view_order_sl_no}', [OrderController::class, 'order_details'])->name('order.details');
Route::post('/order/status/update', [OrderController::class, 'order_status_update'])->name('order_status_update');


// role manager ==============
Route::get('/role/create', [RoleManagerController::class, 'role_create'])->name('role.create');
Route::get('/role/assign', [RoleManagerController::class, 'role_assign'])->name('role.assign');
Route::get('/permission/assign', [RoleManagerController::class, 'permission_assign'])->name('permission.assign');
Route::post('/permission/store', [RoleManagerController::class, 'permission_store'])->name('permission.store');
Route::post('/role/store', [RoleManagerController::class, 'role_store'])->name('role.store');
Route::get('/role/delete/{role_id}', [RoleManagerController::class, 'role_delete'])->name('role_delete');
Route::get('/role/edit/{role_id}', [RoleManagerController::class, 'role_edit'])->name('role_edit');
Route::post('/role/update', [RoleManagerController::class, 'role_update'])->name('role_update');
Route::post('/user/role/assign', [RoleManagerController::class, 'user_role_assign'])->name('user_role_assign');
Route::post('/user/permission/assign', [RoleManagerController::class, 'user_permission_assign'])->name('user_permission_assign');
Route::get('/user/role/edit/{user_id}', [RoleManagerController::class, 'user_role_edit'])->name('user_role_edit');
Route::get('/user/permission/remove/{user_id}', [RoleManagerController::class, 'user_permission_remove'])->name('user_permission_remove');
Route::post('/user/role/change', [RoleManagerController::class, 'user_role_change'])->name('user_role_change');
Route::get('/user/role/delete/{role_id}', [RoleManagerController::class, 'user_role_delete'])->name('user_role_delete');
Route::post('/user/role/permission_remove', [RoleManagerController::class, 'role_user_permission_remove'])->name('role.user_permission_remove');
Route::post('/getPermission', [RoleManagerController::class, 'getPermission']);


// customer message =================
Route::get('/customer/message', [CustomerMessageController::class, 'customer_message'])->name('customer_message');
Route::post('/customer/message/reply', [CustomerMessageController::class, 'reply_customer_message'])->name('reply_customer_message');


// report =================
Route::get('/report', [ReportController::class, 'report'])->name('report');
Route::post('/report/download', [ReportController::class, 'report_download'])->name('report.download');