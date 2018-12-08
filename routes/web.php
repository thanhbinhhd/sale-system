<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('private-policy', function() {
    return view('user.private-policy');
});
Route::get('/shop/', function (){
    return redirect(route('shop', ['category' => 'All']));
});

Route::get('/shop/{category}',['as' => 'shop', 'uses' => 'User\ShopController@show']);
Route::get('/shop/{category}/filter', ['as' => 'filter', 'uses' => 'User\ShopController@filte']);
Route::group(['namespace' => 'Admin', 'as' => 'admin.', 'prefix' => 'admin'], function () {
    Route::group(['namespace' => 'Auth', 'middleware' => 'guest'], function () {
        Route::get('login', ['as' => 'login', 'uses' => 'LoginController@showLoginForm']);
        Route::post('login', ['as' => 'login', 'uses' => 'LoginController@authenticate']);
        Route::get('forgot-password', ['as' => 'forgot_password', 'uses' => 'ForgotPasswordController@showLinkRequestForm']);
        Route::post('email', ['as' => 'email', 'uses' => 'ForgotPasswordController@sendResetLinkEmail']);
        Route::get('get-reset/{token}', ['as' => 'get-reset', 'uses' => 'ResetPasswordController@showResetForm']);
        Route::post('reset', ['as' => 'reset', 'uses' => 'ResetPasswordController@reset']);

        Route::get('changePassword', ['as' => 'changePassword', 'uses' => 'ChangePasswordController@showChangePasswordForm']);
        Route::post('changePassword', ['as' => 'changePassword', 'uses' => 'ChangePasswordController@changePassword'])->name('changePassword');
    });

    Route::group(['middleware' => 'admin'], function () {
        Route::resource('admin-manager', 'AdminManageController')->middleware('admin.level');
        Route::group(['middleware' => 'admin.level', 'prefix' => 'admin-manager'], function(){
            Route::post('store', 'AdminManageController@store');
            Route::put('{$id}', 'AdminManageController@update');
            Route::delete('{$id}', 'AdminManageController@destroy');
        });
        Route::put('update-admin-status',['as' => 'update-admin-status', 'uses' => "AdminManageController@updateStatus"]);

        Route::put('update-product-status', 'ProductController@updateStatus');
        Route::resource('product-manager', 'ProductController');
        Route::group(['prefix' => 'product-manager'], function (){
            Route::delete('{id}', 'ProductController@destroy');
        });

        Route::get('dashboard',['as' => 'home', 'uses' => 'DashBoardController@index']);
        Route::get('dashboard/get-chart', 'DashBoardController@getChart');

        Route::put('update-blog-status', 'BlogController@updateStatus');
        Route::resource('blog-manager', 'BlogController');
        Route::group(['prefix' => 'blog-manager'], function (){
            Route::delete('{id}', 'BlogController@destroy');
        });

        Route::resource('category-manager', 'CategoryController');
        Route::group(['prefix' => 'category-manager'], function (){
            Route::delete('{id}', 'CategoryController@destroy');
        });

        Route::put('update-slide-status', 'SlideController@updateStatus');
        Route::resource('slide-manager', 'SlideController');
        Route::group(['prefix' => 'slide-manager'], function (){
            Route::delete('{id}', 'SlideController@destroy');
        });

        Route::get('dashboard',['as' => 'home', 'uses' => 'UserController@index']);
        Route::get('user-manager',['as' => 'user-manager', 'uses' => 'UserController@index']);
        Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
        Route::put('update-status',"UserController@updateStatus");
        Route::get('order-list/{id}', "UserController@orderList");

        Route::resource('order-manager', 'OrderController');

    });
});


Route::group(['namespace' => 'User'], function() {
    Auth::routes(['verify' => true]);
});

Route::group(['namespace' => 'User', 'as' => 'user.'], function () {

    Route::group(['prefix' => 'user'], function () {
        Route::group(['namespace' => 'Auth', 'middleware' => 'guest'], function () {
            Route::get('login', ['as' => 'login', 'uses' => 'LoginController@showLoginForm']);
            Route::get('register', ['as' => 'register', 'uses' => 'RegisterController@showRegisterForm']);
            Route::post('register', ['as' => 'register', 'uses' => 'RegisterController@register']);
            Route::post('login', ['as' => 'login', 'uses' => 'LoginController@authenticate']);
            Route::get('forgot-password', ['as' => 'forgot_password', 'uses' => 'ForgotPasswordController@showLinkRequestForm']);
            Route::post('email', ['as' => 'email', 'uses' => 'ForgotPasswordController@sendResetLinkEmail']);
            Route::get('get-reset/{token}', ['as' => 'get-reset', 'uses' => 'ResetPasswordController@showResetForm']);
            Route::post('reset', ['as' => 'reset', 'uses' => 'ResetPasswordController@reset']);
            //Route::get('oauth/twitter/login', ['as' => 'oauth-twitter-login', 'uses' => 'OAuthController@redirectToProviderTwitter']);
            //Route::get('oauth/twitter/callback', ['as' => 'oauth-twitter-callback', 'uses' => 'OAuthController@handleProviderCallbackTwitter']);
            Route::get('oauth/google/login', ['as' => 'oauth-google-login', 'uses' => 'OAuthController@redirectToProviderGoogle']);
            Route::get('oauth/google/callback', ['as' => 'oauth-google-callback', 'uses' => 'OAuthController@handleProviderCallbackGoogle']);
        });
    });

    Route::group(['middleware' => 'user'], function () {
        Route::group(['middleware' => 'user_verified'], function () {

        });
	    Route::get('/cart',['as' => 'cart', 'uses' => 'CartController@index']);
	    Route::get('/cart/details',['as' => 'cart', 'uses' => 'CartController@details']);
	    Route::put('/cart/update',['as' => 'cart', 'uses' => 'CartController@update']);
	    Route::delete('/cart/{id}',['as' => 'cart', 'uses' => 'CartController@remove']);

        Route::get('/',['as' => 'home', 'uses' => 'HomeController@index']);
        Route::get('/contact',['as' => 'contact', function(){
            return view('user.contact');
        }]); Route::get('/about',['as' => 'about', function(){
            return view('user.about');
        }]);

        Route::get('/blog',['as' => 'blog', 'uses' => 'BlogController@index']);
        Route::get('/blog/{blogSlug}',['as' => 'blog', 'uses' => 'BlogController@details']);

        Route::get('/profile',"UserController@profile");
        Route::put('/change-pass',"UserController@changePass");
        Route::post('/upload-avatar',"UserController@uploadAvatar");
        Route::put('/change-profile',"UserController@changeProfile");
        Route::post('/add-cart',"CartController@addCart");
        Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
    });
});
