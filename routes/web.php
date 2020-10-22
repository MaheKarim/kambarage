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

Route::post('/check-environment','HomeController@checkEnvironment')->name('check.environment');
Auth::routes(['verify' => true]);

Route::get('logout',function(){Auth::logout();})->name('web-client.logout'); 

Route::group(['middleware' => ['auth', 'verified','xss']], function()
{
    Route::get('/', 'HomeController@index');
    Route::get('admin/', 'HomeController@index');
    Route::get('subadmin/', 'HomeController@index');
    Route::get('/dashboard', 'HomeController@index')->name('home');

    Route::get('/test',function (){
        return view('auth.verify');
    });
});
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth','xss']], function () {

    //Category Route
    Route::resource('category', 'CategoryController');
    Route::get('category/edit/{id}', 'CategoryController@create')->name('category.edit');
    Route::get('category-list', 'CategoryController@list')->name('category.list');
    Route::get('category/destroy/{id}', 'CategoryController@destroy')->name('category.destroy');

    //Subcategory routes
    Route::get('subcategory/dropdown', 'SubCategoryController@getsubCategoryList')->name('subcategory.dropdown');
    Route::resource('subcategory','SubCategoryController');
    Route::get('subcategory-list', 'SubCategoryController@list')->name('subcategory.list');
    Route::get('subcategory/edit/{id}', 'SubCategoryController@create')->name('subcategory.edit');
    Route::get('subcategory/destroy/{id}', 'SubCategoryController@destroy')->name('subcategory.destroy');

    //Author Routes
    Route::resource('author','AuthorController');
    Route::get('author-list/{type?}','AuthorController@dataList')->name('dataList');
    Route::get('author-list/edit/{id}','AuthorController@create')->name('author.edit');
    Route::get('author-view/{id}','AuthorController@show')->name('author.show');
    Route::get('author/destroy/{id}','AuthorController@destroy')->name('author.destroy');
    
    //StaticData Routes
    Route::resource('staticdata','StaticDataController');
    Route::get('staticdata/add/{type}','StaticDataController@create')->name('staticdata.add');
    Route::get('staticdata/view/{type}','StaticDataController@view')->name('staticdata.view');
    Route::get('staticdata/edit/{type}/{id}','StaticDataController@edit')->name('staticdata.edit');
    Route::post('staticdata/update/','StaticDataController@update')->name('staticdata.update');
    Route::get('staticdata/destroy/{type}/{id}','StaticDataController@destroy')->name('staticdata.destroy');
    Route::get('language-list','StaticDataController@languageList')->name('language.list');
    Route::get('publisher-list','StaticDataController@publisherList')->name('publisher.list');


    //AdminAssistant Routes
    Route::resource('assistant','AdminAssistantController');
    Route::get('assistant/edit/{id}', 'AdminAssistantController@edit')->name('assistant.edit');
    Route::get('assistant-list', 'AdminAssistantController@list')->name('assistant.list');
    Route::post('assistant/update/{id}', 'AdminAssistantController@update')->name('assistant.update');

    //Mobile slider
    Route::resource('mobileslider', 'MobileSliderController');
    Route::get('mobileslider-list', 'MobileSliderController@list')->name('mobileslider.list');
    Route::get('mobileslider/edit/{id}', 'MobileSliderController@create')->name('mobileslider.edit');
    Route::get('mobileslider/destroy/{id}', 'MobileSliderController@destroy')->name('mobileslider.destroy');

    //Book routes
    Route::resource('book', 'BookController');
    Route::get('book-edit/{id?}','BookController@create')->name('book.update');
    Route::get('book-list/{type?}','BookController@bookList')->name('book.list');
    Route::get('book-view/{id}','BookController@view')->name('book.view');
    Route::get('book-destroy/{id}','BookController@destroy')->name('book.delete');
    Route::post('book-action','BookController@bookActions')->name('book.actions');

    // Setting Controller
    Route::get('privacy-policy','SettingController@privacyPolicy')->name('privacy-policy');
    Route::post('privacy-policy-save','SettingController@savePrivacyPolicy')->name('privacy-policy-save');
    Route::get('term-condition','SettingController@termAndCondition')->name('term-condition');
    Route::post('term-condition-save','SettingController@saveTermAndCondition')->name('term-condition-save');

    // Feedback Routes
    Route::get('users/feedback','UsersController@userFeedback')->name('users_feedback');
    Route::get('users/feedback/datalist','UsersController@userFeedbackDataList')->name('users_feedback.list');
    Route::get('users/feedback/{id}','UsersController@userFeedbackDetails')->name('users_feedback.details');
    Route::get('users/feedback/mark/{id}','UsersController@markAsRead')->name('users_feedback.mark');

    // // Subscriber Routes
    // Route::resource('subscriber','SubscriberController');
    // Route::get('subscriber-list', 'SubscriberController@list')->name('subscriber.list');
    // Route::get('subscriber-destroy/{id}','SubscriberController@destroy')->name('subscriber.delete');

    // Sales Routes
    Route::get('/transactions/list/{id?}/{record?}','TransactionController@list')->name('transactions.list');
    Route::resource('transactions','TransactionController');
    Route::get('update-payment-status/{id}/{status}','TransactionController@updatePaymentStatus')->name('transactions_update.payment_status');

    // User Details
    Route::resource('users','UsersController');
    Route::get('user-list','UsersController@list')->name('user.list');
    Route::get('user-detail/{id}','UsersController@userDetail')->name('user.detail');
    Route::get('user-delete/{id}','UsersController@destroy')->name('user.delete');
    Route::get('/user-mac-device-id-remove','UsersController@userDeviceMacIdRemove')->name('device_mac_id.destroy');
    Route::post('/password/upadte', 'UsersController@passwordUpadte')->name('user.password.update');
    Route::post('/profile/save', 'UsersController@updateUpdate')->name('user.update');
    
    // Settings Route
    Route::get('settings', 'SettingController@settings')->name('admin.settings');
    Route::post('/layout-page', 'SettingController@layoutPage')->name('layout_page');
    Route::post('settings/save', 'SettingController@settingsUpdates')->name('settingsUpdates');
    Route::post('contact-us', 'SettingController@contactus_settings')->name('contactus_settings');
    Route::post('env-setting', 'SettingController@envSetting')->name('envSetting');
    Route::get('mobile-app','SettingController@getMobileSetting')->name('mobile_app.config');
    Route::post('mobile-app/save','SettingController@saveMobileSetting')->name('mobile_app.config.save');
    
    //College Route
    Route::resource('college','CollegesController');
    Route::get('college-list', 'CollegesController@list')->name('college.list');
    Route::get('college/edit/{id}', 'CollegesController@create')->name('college.edit');
    Route::get('college/view/{id}', 'CollegesController@show')->name('college.show');
    Route::get('college/student/{id}', 'CollegesController@student')->name('college.student');
    Route::get('college/tutor/{id}', 'CollegesController@tutor')->name('college.tutor');
    Route::get('college/destroy/{id}', 'CollegesController@destroy')->name('college.destroy');
    
});

Route::group(['namespace' => 'Admin', 'prefix' => 'subadmin', 'middleware' => ['auth','xss']], function () {
    Route::get('settings', 'SettingController@settings')->name('subadmin.settings');
});

Route::group(['namespace' => 'Subadmin', 'prefix' => 'subadmin', 'middleware' => ['auth','xss']], function () {
    // Settings Route
    
    //College Route
    Route::resource('school','SchoolsController');
    Route::get('college/addsubadmin/{id}', 'SchoolsController@addsubadmin')->name('college.addsubadmin');
    Route::post('college/newsubadmin/{id}', 'SchoolsController@newsubadmin')->name('college.newsubadmin');
    Route::get('college/view/{id}', 'SchoolsController@show')->name('school.show');
    Route::get('college/edit/{id}', 'SchoolsController@edit')->name('school.edit');
    Route::get('college/tutor/{id}', 'SchoolsController@tutor')->name('school.tutor');
    Route::get('tutor-list/{id}', 'SchoolsController@tutorlist')->name('tutor.list');
    Route::get('edit/{usertype}/email/{id}', 'SchoolsController@editemail')->name('school.editemail');
    Route::post('update/{usertype}/email/{id}', 'SchoolsController@updateemail')->name('school.updateemail');
    Route::get('create/tutor/{id}', 'SchoolsController@addtutor')->name('tutor.create');
    Route::get('import/tutor/{id}/', 'SchoolsController@importtutorform')->name('tutor.import.form');
    Route::post('import-tutor/{id}', 'SchoolsController@importtutor')->name('tutor.import');
    Route::post('create/newtutor/{id}', 'SchoolsController@newtutor')->name('school.newtutor');
    Route::get('edit/tutor/{id}', 'SchoolsController@edittutor')->name('school.edittutor');
    Route::post('update/tutor/{id}', 'SchoolsController@updatetutor')->name('school.updatetutor');
    Route::get('destroy/tutor/{id}', 'SchoolsController@destroytutor')->name('school.destroytutor');
    Route::get('college/student/{id}', 'SchoolsController@student')->name('school.student');
    Route::get('student-list/{id}', 'SchoolsController@studentlist')->name('student.list');
    Route::get('create/student/{id}', 'SchoolsController@addstudent')->name('student.create');
    Route::get('import/student/{id}/', 'SchoolsController@importstudentform')->name('student.import.form');
    Route::post('import-student/{id}', 'SchoolsController@importstudent')->name('student.import');
    Route::post('create/newstudent/{id}', 'SchoolsController@newstudent')->name('school.newstudent');
    Route::get('edit/student/{id}', 'SchoolsController@editstudent')->name('school.editstudent');
    Route::post('update/student/{id}', 'SchoolsController@updatestudent')->name('school.updatestudent');
    Route::get('destroy/student/{id}', 'SchoolsController@destroystudent')->name('school.destroystudent');
});
Route::get('php',function(){
   phpinfo();
});
