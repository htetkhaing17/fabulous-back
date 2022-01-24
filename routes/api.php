<?php

use App\Models\Product;
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

use Illuminate\Support\Facades\Route;
use App\Http\Resources\ProductResource;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\UploadFileController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\ResetPasswordController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->group(function(){
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('/inventory/{user_id}/')->group(function(){
        Route::prefix('products/')->group(function(){
            Route::get('/', [InventoryController::class, 'my_products']);
            Route::post('create', [InventoryController::class, 'createProduct']);
            Route::get('{id}/edit/', [InventoryController::class, 'edit']);
            Route::put('{id}/update', [InventoryController::class, 'update']);
            Route::delete('delete', [InventoryController::class, 'delete']);

        });
    }); 

    Route::prefix('/users/')->group(function(){
        Route::get('profile', [AuthController::class, 'editProfile']);
    });


    // FILE UPLOAD HANDLER
    Route::post('/tmp_upload', [UploadFileController::class, 'tmpUpload']);





});



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');

Route::post('/request/code', [ResetPasswordController::class, 'request_code']);
Route::post('/verify/code', [ResetPasswordController::class, 'verify_code']);
Route::patch('/reset-password', [ResetPasswordController::class, 'reset_password']);

Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('/email/resend', [VerificationController::class, 'resend']);

Route::get('/products',function(){
    return ProductResource::collection(App\Models\Product::paginate(10));
});

Route::get('/products/recently',[App\Http\Controllers\ProductController::class,'recentlyAddedProducts']);

Route::get('/categories', [CategoryController::class, 'all']);

Route::get('/test', function(){
    return auth('sanctum')->user()->id;
});
