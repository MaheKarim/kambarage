<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
 
Route::post('register','API\User\UserController@register');
Route::post('login','API\User\UserController@login');

Route::get('dashboard-detail','API\Dashboard\DashboardController@getDashboardDetail');

Route::get('book-list','API\Book\BookController@getBookList');
Route::post('book-detail','API\Book\BookController@getBookDetail');
Route::get('author-list','API\Author\AuthorController@getAuthorList');

Route::post('book-rating-list','API\Book\BookController@getBookRating');


Route::group(['middleware' => 'auth:api'], function(){
    //Book
    Route::post('update-book-rating','API\Book\BookController@updateBookRating');
    Route::post('add-book-rating','API\Book\BookController@addBookRating');

    Route::get('user-wishlist-book','API\Book\BookController@getUserWishlistBook');
    Route::post('add-remove-wishlist-book','API\Book\BookController@addRemoveWishlistBook');
    Route::post('delete-book-rating','API\Book\BookController@deleteBookRating');

    //Cart
    Route::post('add-to-cart','API\Cart\CartController@addToCart');
    Route::post('remove-from-cart','API\Cart\CartController@removeFromCart');
    Route::get('user-cart','API\Cart\CartController@getUserCart');

    // Category Subcategory and author
    Route::get('category-list','API\Category\CategoryController@getCategoryList');
    Route::post('sub-category-list','API\SubCategory\SubCategoryController@getSubCategoryList');

    // Transaction
    Route::post('generate-check-sum','API\Transaction\TransactionController@checkSumGenerator');
    Route::post('save-transaction','API\Transaction\TransactionController@saveTransaction');
    Route::get('get-transaction-history','API\Transaction\TransactionController@getTransactionDetail');
    Route::get('user-purchase-book','API\Transaction\TransactionController@getUserPurchaseBookList');

    //Change Password
    Route::post('change-password','API\Password\PasswordController@changePassword');
    Route::post('save-user-profile','API\User\UserController@updateUserProfile');

    //COLLEGE
    Route::get('college-list','API\College\CollegeController@getCollegeList');
    Route::post('college-details','API\College\CollegeController@collegeDetails');
    Route::post('student-list','API\College\CollegeController@studentlist');
    Route::post('tutor-list','API\College\CollegeController@tutorlist');

});



Route::post('add-feedback','API\User\UserController@saveFeedback');
Route::post('forgot-password','API\Password\PasswordController@forgotPassword');
Route::post('verify-token','API\Password\PasswordController@VerificationOTPCheck');
Route::post('resend-otp','API\Password\PasswordController@ResendOTP');
Route::post('update-password','API\Password\PasswordController@updatePassword');