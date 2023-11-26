<?php

use App\Http\Controllers\Api\AssistanceRequestController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PagoController;
use App\Http\Controllers\Api\TechnicianController;
use App\Http\Controllers\Api\WorkShopController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', [AuthController::class, 'getUser']);
    Route::get('/user/revoke', [AuthController::class, 'revokeToken']);
});

Route::post('/sanctum/token', [AuthController::class, 'generateToken']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/users', [AuthController::class, 'users']);

Route::get('/assistance_request/getVehicles/client_id={id}', [AssistanceRequestController::class, 'getVehicles']);
Route::post('/vehicles/register', [AssistanceRequestController::class, 'registerVehicle']);
 Route::post('/asisstance_request/register', [AssistanceRequestController::class, 'clientRequestAssistance']);
// solicidtud de todas las 
Route::get('/assistance_request/getAll/client_id={id}', [AssistanceRequestController::class, 'getAssistanceRequests']);
Route::get('/assistance_request/getAll', [AssistanceRequestController::class, 'getAssistanceRequestsAviable']);
//pagos
Route::post('/procesar_pago', [PagoController::class, 'procesarPago']);
//Technicians
Route::get('/workshop/technician/getAll/client_id={id}', [TechnicianController::class, 'getTechnician']);
Route::post('/workshop/technicians/register', [TechnicianController::class, 'createTechnician']);
//workshops
Route::get('/workshop/all', [WorkShopController::class, 'getWorkShops']);
Route::get('/workshop/technicians/all/client_id={id}', [TechnicianController::class, 'getTechnician']);
