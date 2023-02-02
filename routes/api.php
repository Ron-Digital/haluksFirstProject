<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\UserController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ServiceController;


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
Route::get('user/arrays',[UserController::class, 'arrays']);


Route::post('user/login',[UserController::class, 'login']);

Route::post('user/',[UserController::class, 'insert']);

Route::get('/login',function() {
    return response()->json([
            'message'=>'login is not allowed'
        ]);
})->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('user')->controller(UserController::class)->group(function () {
        Route::get('/{id}', 'read');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'delete');
        Route::get('/', 'index');
    });

    Route::prefix('meeting')->controller(MeetingController::class)->group(function () {
        Route::post('/', 'insert');
        Route::get('/{id}', 'read');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'delete');
        Route::get('/', 'index');
    });

    Route::prefix('customer')->controller(CustomerController::class)->group(function () {
        Route::post('/', 'insert');
        Route::get('/{id}', 'read');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'delete');
        Route::get('/', 'index');
    });

    Route::prefix('staff')->controller(StaffController::class)->group(function () {
        Route::post('/', 'insert');
        Route::get('/{id}', 'read');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'delete');
        Route::get('/', 'index');
    });

    Route::prefix('service')->controller(ServiceController::class)->group(function () {
        Route::post('/', 'insert');
        Route::get('/{id}', 'read');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'delete');
        Route::get('/', 'index');
    });
});

// Route::post("login",[UserrController::class,'index']);

/////////////////////////////////////////////////////////////////

// Route::post('calisan', [CalisanController::class,'insert']);

// Route::get('calisan/{id}', [CalisanController::class,'read']);

// Route::put('calisan/{id}', [CalisanController::class,'update']);

// Route::delete('calisan/{id}', [CalisanController::class,'delete']);

// Route::get('calisan', [CalisanController::class,'index']);


// Route::post('servis', [ServisController::class,'insert']);

// Route::get('servis/{id}', [ServisController::class,'read']);

// Route::put('servis/{id}', [ServisController::class,'update']);

// Route::delete('servis/{id}', [ServisController::class,'delete']);

// Route::get('servis', [ServisController::class,'index2']);


// Route::prefix('servis')->controller(ServisController::class)->group(function () {
//     Route::post('/', 'insert');
//     Route::get('/{id}', 'read');
//     Route::put('/{id}', 'update');
//     Route::delete('/{id}', 'delete');
//     Route::get('/', 'index');
// });

// Route::prefix('musteri')->controller(MusteriController::class)->group(function () {
//     Route::post('/', 'insert');
//     Route::get('/{id}', 'read');
//     Route::put('/{id}', 'update');
//     Route::delete('/{id}', 'delete');
//     Route::get('/', 'index');
// });

// Route::get('calisan/{id}/servis', [CalisanController::class, 'calisan_servis']);

// Route::get('calisan/{id}/musteri', [CalisanController::class, 'calisan_musteri']);

//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////

// Route::get('user/{id}/meeting', [UserController::class, 'user_meeting']);

Route::get('meeting/{id}/customer', [MeetingController::class, 'meeting_customer']);

Route::get('meeting/{id}/staff', [MeetingController::class, 'meeting_staff']);

Route::get('meeting/{id}/service', [MeetingController::class, 'meeting_service']);

//Route::get('staff/{id}/service', [StaffController::class, 'staff_service']);

////////////////////////////////////////////////////////////////////////////

// Route::post('/sait', function(Request $request){
//     $validator = Validator::make($request->all(),[
//         'fullname' => '',
//         'age' => 'required|numeric',
//         'email' => '',
//         'password' => ''
//     ]);

//     if($validator->fails()){
//         return response()->json([
//             'validationMessages' => $validator->errors()
//         ], 400);
//     }

//     return response()->json(
//         $validator->validated()
//     );
// });

////////////////////////////////////////////

////////////////////////////////////////////
