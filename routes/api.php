<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\OccupantController;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;

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

// Route::post('/register', [AuthController::class, 'register']);

// Route::post('/login', [AuthController::class, 'login']);

Route::post('/loginMobile', [AuthController::class, 'loginMobile']);

/*
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/me', function(Request $request) {
        $user = User::where('email', auth()->user()['email'])->firstOrFail();
        return response()->json([new UserResource($user)]);
    });

    Route::apiResource("/occupant", OccupantController::class);

    Route::post('/job', [JobController::class, 'job']);

    Route::name('user.')->group(function () {
        Route::get('profile', function () {
            return auth()->user();
        })->name('profile');
        Route::post('logout', [AuthController::class, 'logout']);
    });
});
 */
