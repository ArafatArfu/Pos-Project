<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
use App\Models\product;

//Pages Route //Before authentication

Route::get('/userLogin',[UserController::class,'LoginPage']);
Route::get('/userRegistration',[UserController::class,'RegistrationPage']);
Route::get('/sendOtp',[UserController::class,'SendOtpPage']);
Route::get('/verifyOtp',[UserController::class,'VerifyOTPPage']);
Route::get('/resetPassword',[UserController::class,'ResetPasswordPage'])
->middleware([TokenVerificationMiddleware::class]);

    //After authentication    //page route    //dashboard controller

Route::get('/dashboard',[DashboardController::class,'DashboardPage'])
->middleware([TokenVerificationMiddleware::class]);
Route::get('/summary',[DashboardController::class,'Summary'])->middleware([TokenVerificationMiddleware::class]);
Route::get('userProfile',[UserController::class,'ProfilePage'])->middleware([TokenVerificationMiddleware::class]);

    //After authentication    //page route    //category,customer,product controller.

Route::get('/customerPage',[CustomerController::class,'CustomerPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/categoryPage',[CategoryController::class,'CategoryPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/productPage',[ProductController::class,'ProductPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/salePage',[InvoiceController::class,'SalePage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/invoicePage',[InvoiceController::class,'InvoicePage'])->middleware([TokenVerificationMiddleware::class]);

//web api route
Route::post('/user-registration',[UserController::class,'UserRegistration']);
Route::post('/user-login',[UserController::class,'userLogin']);
Route::post('/send-otp',[UserController::class,'SendOTPCode']);
Route::post('/verify-otp',[UserController::class,'VerifyOTP']);

Route::post('/reset-password',[UserController::class,'ResetPassword'])
->middleware(TokenVerificationMiddleware::class);

                //After authentication web api route

Route::get('/logout',[UserController::class,'UserLogout']);

Route::get('/user-profile-details',[UserController::class,'UserProfile'])->middleware([TokenVerificationMiddleware::class]);

Route::post('/user-update',[UserController::class,'UserUpdate'])->middleware([TokenVerificationMiddleware::class]);



//Customer Api

Route::post('/create-customer',[CustomerController::class,'CustomerCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/list-customer',[CustomerController::class,'CustomerList'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/delete-customer',[CustomerController::class,'CustomerDelete'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/update-customer',[CustomerController::class,'CustomerUpdate'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/customer-by-id',[CustomerController::class,'CustomerByID'])->middleware([TokenVerificationMiddleware::class]);

//Categroy Api

Route::post('/create-category',[CategoryController::class,'CategoryCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/list-category',[CategoryController::class,'CategoryList'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/delete-category',[CategoryController::class,'CategoryDelete'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/update-category',[CategoryController::class,'CategoryUpdate'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/category-by-id',[CategoryController::class,'CategoryByID'])->middleware([TokenVerificationMiddleware::class]);



//Product Api

Route::post('/create-product',[ProductController::class,'CreateProduct'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/delete-product',[ProductController::class,'DeleteProduct'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/list-product',[ProductController::class,'ListProduct'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/update-product',[ProductController::class,'UpdateProduct'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/product-by-id',[ProductController::class,'ProductById'])->middleware([TokenVerificationMiddleware::class]);


//Dashboard Api

Route::get('/total-customer',[DashboardController::class,'TotalCustomer'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/total-category',[DashboardController::class,'TotalCategory'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/total-product',[DashboardController::class,'TotalProduct'])->middleware([TokenVerificationMiddleware::class]);


//Invoice Api


Route::post('/invoice-create',[InvoiceController::class,'InvoiceCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/invoice-select',[InvoiceController::class,'InvoiceSelect'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/invoice-details',[InvoiceController::class,'InvoiceDetails'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/invoice-delete',[InvoiceController::class,'InvoiceDelete'])->middleware([TokenVerificationMiddleware::class]);


