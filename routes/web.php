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

        Route::get('dashboard',['as' => 'home', 'uses' => 'UserController@index']);
        Route::get('user-manager',['as' => 'user-manager', 'uses' => 'UserController@index']);
        Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
        Route::put('update-status',"UserController@updateStatus");
        
        Route::get('slide-manager',['as' => 'slide-manager', 'uses' => 'SlideController@index']);
        Route::post('create-slide',"SlideController@createSlide");
        Route::put('update-slide',"SlideController@updateSlide");
        Route::put('update-slide-status',"SlideController@updateSlideStatus");
        Route::delete('delete-slide',"SlideController@deleteSlide");
        Route::post('upload-slide-image',"SlideController@uploadImage");
        Route::post('change-slide-image-name',"SlideController@changeImageName");

        Route::get('category-manager',['as' => 'category-manager', 'uses' => 'CategoryController@index']);
        Route::post('create-category',"CategoryController@createCategory");
        Route::put('update-category',"CategoryController@updateCategory");
        Route::delete('delete-category',"CategoryController@deleteCategory");
        Route::post('upload-category-image',"CategoryController@uploadImage");
        Route::post('change-category-image-name',"CategoryController@changeImageName");

        Route::get('users/{id}',"UserController@detail");
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
            Route::get('/cart',['as' => 'cart', function(){
                return view('user.cart');
            }]);
            Route::get('/blog',['as' => 'blog', function(){
                return view('user.blog');
            }]);
        });
        Route::get('/',['as' => 'home', 'uses' => 'HomeController@index']);
        Route::get('/contact',['as' => 'contact', function(){
            return view('user.contact');
        }]); Route::get('/about',['as' => 'about', function(){
            return view('user.about');
        }]);

        Route::get('/profile',"UserController@profile");
        Route::put('/changepass',"UserController@changepass");
        Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
    });
});
