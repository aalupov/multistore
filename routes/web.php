<?php

/*
 * |--------------------------------------------------------------------------
 * | Web Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register web routes for your application. These
 * | routes are loaded by the RouteServiceProvider within a group which
 * | contains the "web" middleware group. Now create something great!
 * |
 */

// Route::get('/', function () {
// return view('index');
// dd(geoip()->getLocation());

// });
// Route::get('/', 'Stores\StoresController@index')->name('indexStore');
$groupDataStore = [
    'namespace' => 'Stores',
    'prefix' => ''
];

$groupDataUser = [
    'namespace' => 'Users',
    'prefix' => ''
];

$groupDataMainAdmin = [
    'namespace' => 'Admin\Main',
    'prefix' => 'admin/panel'
];

$groupDataStoreAdmin = [
    'namespace' => 'Admin\Store',
    'prefix' => 'admin/panel'
];

// route to main page of the admin panel
Route::group($groupDataMainAdmin, function () {
    $methods = [
        'index'
    ];
    Route::resource('', 'AdminPanelController')->only($methods)->names('adminMainPanel');
});

// route to home admin store page
Route::group($groupDataStoreAdmin, function () {
    $methods = [
        'show'
    ];
    Route::resource('/home', 'HomePanelController')->only($methods)->names('homeStorePanel');
});

// route to store page of the admin panel
Route::group($groupDataStoreAdmin, function () {
    $methods = [
        'show',
        'edit',
        'update'
    ];
    Route::resource('/store', 'StorePanelController')->only($methods)->names('adminStorePanel');
});

// route to product categories page of the store admin panel
Route::group($groupDataStoreAdmin, function () {
    $methods = [
        'show',
        'update',
        'edit'
    ];
    Route::resource('/categories', 'StorePanelProductCategoriesController')->only($methods)->names('adminStorePanelCategory');
});

// route to products page of the store admin panel
Route::group($groupDataStoreAdmin, function () {
    $methods = [
        'show',
        'update',
        'edit',
        'destroy',
        'store',
        'create'
    ];
    Route::resource('/products', 'StorePanelProductsController')->only($methods)->names('adminStorePanelProduct');
});

// route to attributes page of the store admin panel
Route::group($groupDataStoreAdmin, function () {
    $methods = [
        'show',
        'update',
        'edit'
    ];
    Route::resource('/attributes', 'StorePanelAttributesProductController')->only($methods)->names('adminStorePanelAttributes');
});

// route to orders page of the store admin panel
Route::group($groupDataStoreAdmin, function () {
    $methods = [
        'show',
        'update',
        'edit'
    ];
    Route::resource('/store/orders', 'StorePanelOrdersController')->only($methods)->names('adminStorePanelOrders');
});

// route to reviews page of the store admin panel
Route::group($groupDataStoreAdmin, function () {
    $methods = [
        'show',
        'edit',
        'destroy'
    ];
    Route::resource('/store/reviews', 'StorePanelReviewsController')->only($methods)->names('adminStorePanelReviews');
});

// seach the products on store panel
Route::get('admin/panel/store/products/seach', 'Admin\Store\StorePanelProductsController@seachProduct')->name('findProductsStorePanel');

// seach the user on admin panel
Route::get('admin/panel/users/seach', 'Admin\Main\AdminPanelUsersController@seachUser')->name('findUserAdminPanel');

// seach the store on admin panel
Route::get('admin/panel/stores/seach', 'Admin\Main\AdminPanelStoresController@seachStore')->name('findStoreAdminPanel');

// seach the order on admin panel
Route::get('admin/panel/orders/seach', 'Admin\Main\AdminPanelOrdersController@seachOrder')->name('findOrderAdminPanel');

// seach the order on store admin panel
Route::get('admin/panel/store/order/seach', 'Admin\Store\StorePanelOrdersController@seachOrderForStore')->name('findOrderStorePanel');

// route to settings page of the admin panel
Route::group($groupDataMainAdmin, function () {
    $methods = [
        'index',
        'store'
    ];
    Route::resource('/settings', 'AdminPanelSettingsController')->only($methods)->names('adminSettings');
});

// route to stores page of the admin panel
Route::group($groupDataMainAdmin, function () {
    $methods = [
        'index',
        'create',
        'edit',
        'update',
        'destroy',
        'show',
        'store'
    ];
    Route::resource('/stores', 'AdminPanelStoresController')->only($methods)->names('adminStores');
});

// route to users page of the admin panel
Route::group($groupDataMainAdmin, function () {
    $methods = [
        'index',
        'create',
        'edit',
        'update',
        'destroy',
        'store'
    ];
    Route::resource('/users', 'AdminPanelUsersController')->only($methods)->names('adminUsers');
});

// route to orders page of the admin panel
Route::group($groupDataMainAdmin, function () {
    $methods = [
        'index',
        'update',
        'show'
    ];
    Route::resource('/orders', 'AdminPanelOrdersController')->only($methods)->names('adminOrders');
});

// route to home page
Route::group($groupDataStore, function () {
    $methods = [
        'index',
        'store'
    ];
    Route::resource('/', 'StoresController')->only($methods)->names('indexStore');
});

// route to profile
Route::group($groupDataUser, function () {
    $methods = [
        'edit',
        'update'
    ];
    Route::resource('/my-profile', 'UserProfileController')->only($methods)->names('profileUser');
});

// route to the orders page in profile
Route::group($groupDataUser, function () {
    $methods = [
        'show'
    ];
    Route::resource('/my-orders', 'OrdersController')->only($methods)->names('ordersUser');
});

// route to the addresses page in profile
Route::group($groupDataUser, function () {
    $methods = [
        'show'
    ];
    Route::resource('/my-addresses', 'AddressesController')->only($methods)->names('addressesUser');
});

// route to the address page in profile
Route::group($groupDataUser, function () {
    $methods = [
        'edit',
        'update',
        'destroy',
        'create',
        'store'
    ];
    Route::resource('/address', 'AddressController')->only($methods)->names('addressUser');
});

// route to the one order page in profile
Route::group($groupDataUser, function () {
    $methods = [
        'show'
    ];
    Route::resource('/order', 'OrderController')->only($methods)->names('orderUser');
});

// route to google map page
Route::group($groupDataStore, function ($id) {
    $methods = [
        'index',
        'show'
    ];
    Route::resource('/google', 'GoogleMapController')->only($methods)->names('googleMapStore');
});
// route to store short info page
Route::group($groupDataStore, function () {
    $methods = [
        'show'
    ];
    Route::resource('/store/info', 'StoresShortInfoController')->only($methods)->names('shortInfoStore');
});
// route to store page
Route::group($groupDataStore, function () {
    $methods = [
        'show'
    ];
    Route::resource('/store', 'StoresController')->only($methods)->names('storePage');
});

// route to category page
Route::group($groupDataStore, function () {
    $methods = [
        'show'
    ];
    Route::resource('/category', 'CategoryProductsController')->only($methods)->names('categoryPage');
});

// route to product page
Route::group($groupDataStore, function () {
    $methods = [
        'show',
        'store'
    ];
    Route::resource('/product', 'ProductsController')->only($methods)->names('productPage');
});

// send email from store page
Route::group($groupDataStore, function () {
    $methods = [
        'show'
    ];
    Route::resource('/store/contact', 'StoresMailSendController')->only($methods)->names('storeMailSendPage');
});
Route::post('/store/sendmail', 'Stores\StoresMailSendController@send')->name('storeMailSend');

// add to cart
Route::post('/product/addtocart', 'Stores\ProductsController@addToCart')->name('addToCartAction');

// route to cart page
Route::get('/cart', 'CartController@index')->name('cartStores');

// Update quantity of the product in the cart.
Route::post('update-cart', 'CartController@update')->name('updateCart');

// Clear the cart.
Route::post('clear-cart', 'CartController@clear')->name('clearCart');

// route to checkout page
Route::get('/checkout', 'CheckoutController@index')->name('checkoutStores');

// Place the order.
Route::post('place-order', 'CheckoutController@placeOrder')->name('placeOrder');

// Route to success page.
Route::get('/success', function () {
    return view('success');
});

// route to add a buisness page
Route::get('/add-buisness', 'AddBuisnessPageController@index')->name('addBuisness');

// sending of "add a buisness" form
Route::post('add-buisness-send', 'AddBuisnessPageController@store')->name('addBuisnessSend');

// Sort the products.
Route::get('sortProducts', 'Stores\StoresController@sort')->name('sortProducts');

// seach the products
Route::get('seach', 'Stores\StoresController@findProducts')->name('findProducts');

Auth::routes([
    'verify' => true
]);

Route::get('/home', 'HomeController@index')->name('home');
