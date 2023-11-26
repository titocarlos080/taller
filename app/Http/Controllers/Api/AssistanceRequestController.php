<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Assistance_request;
use App\Models\Client;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Workshop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssistanceRequestController extends Controller
{

    public function registerVehicle(Request $request)
    {
        try {
            //code...
            $request->validate([
                'brand' => 'required|string',
                'model' => 'required|string',
                'year' => 'required|string',
                'licence_plate' => 'required|string',
                'client_id' => 'required',
            ]);

            $cliente = Client::where('user_id', $request->client_id)->first();
            Vehicle::create([
                'brand' => $request->brand,
                'model' => $request->model,
                'year' => $request->year,
                'licence_plate' => $request->licence_plate,
                'client_id' => $cliente->id,
            ]);


            return  response()->json(['message' => 'Vehiculo registrado correctamente'], 201);
        } catch (\Throwable $th) {
            //throw $th;
            return  response()->json(['message' => 'Error al crear vehiculo', 'error' => $th], 500);
        }
    }


    public function getVehicles($client_id)
    {
        try {
            $cliente = Client::where('user_id', $client_id)->first();

            $vehicles = Vehicle::where('client_id', $cliente->id)->get();

            return response()->json($vehicles, 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al procesar la solicitud de asistencia', 'error' => $th->getMessage()], 500);
        }
    }
    public function getAssistanceWorkshop($workshop_id)
    {
        try {
            $workshop = Workshop::where('user_id', $workshop_id)->first();
            $assistance = Vehicle::where('id', $workshop->id)->get();

            return response()->json($assistance, 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al procesar la solicitud de asistencia', 'error' => $th->getMessage()], 500);
        }
    }
   public function getAssistanceRequestsAviable(){
    try {
        //code...
      
        $respuesta = Assistance_request::leftJoin('clients', 'clients.id', 'assistance_requests.client_id')
            ->leftJoin('users as CLI', 'CLI.id', 'clients.user_id')
            ->leftJoin('vehicles', 'vehicles.id', 'assistance_requests.vehicle_id')
            ->select(
                'assistance_requests.id as assistance_request_id',
                'assistance_requests.problem_description as problem_description',
                'assistance_requests.latitud as latitud',
                'assistance_requests.longitud as longitud',
                'assistance_requests.photos as photos',
                'assistance_requests.voice_note as voice_note',
                'assistance_requests.status_id as status',
                'assistance_requests.created_at as assistance_request_date',

                // CLIENTE
                'assistance_requests.client_id as client_id',
                'clients.phone as client_phone',
                'clients.user_id as client_user_id',
                'CLI.name as client_user_name',
                'CLI.email as client_user_email',

                // VEHICULO
                'assistance_requests.vehicle_id as vehicle_id',
                'vehicles.brand as vehicle_brand',
                'vehicles.model as vehicle_model',
                'vehicles.year as vehicle_year',
                'vehicles.licence_plate as vehicle_licence_plate',

            

            )
            ->where('assistance_requests.status_id', 1)
            ->get();
        return response()->json($respuesta, 201);
    } catch (\Throwable $th) {
        //throw $th;
        return response()->json(['message' => 'Error al procesar la solicitud de asistencia', 'error' => $th->getMessage()], 500);
    }

   }


    public function getAssistanceRequests($client_id)
    {
        try {
            //code...
            $cliente = Client::where('user_id', $client_id)->first();
            $respuesta = Assistance_request::leftJoin('clients', 'clients.id', 'assistance_requests.client_id')
                ->leftJoin('users as CLI', 'CLI.id', 'clients.user_id')
                ->leftJoin('vehicles', 'vehicles.id', 'assistance_requests.vehicle_id')
                ->select(
                    'assistance_requests.id as assistance_request_id',
                    'assistance_requests.problem_description as problem_description',
                    'assistance_requests.latitud as latitud',
                    'assistance_requests.longitud as longitud',
                    'assistance_requests.photos as photos',
                    'assistance_requests.voice_note as voice_note',
                    'assistance_requests.status_id as status',
                    'assistance_requests.created_at as assistance_request_date',

                    // CLIENTE
                    'assistance_requests.client_id as client_id',
                    'clients.phone as client_phone',
                    'clients.user_id as client_user_id',
                    'CLI.name as client_user_name',
                    'CLI.email as client_user_email',

                    // VEHICULO
                    'assistance_requests.vehicle_id as vehicle_id',
                    'vehicles.brand as vehicle_brand',
                    'vehicles.model as vehicle_model',
                    'vehicles.year as vehicle_year',
                    'vehicles.licence_plate as vehicle_licence_plate',

                

                )
                ->where('assistance_requests.client_id', $cliente->id)
                ->get();
            return response()->json($respuesta, 201);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['message' => 'Error al procesar la solicitud de asistencia', 'error' => $th->getMessage()], 500);
        }
    }
    public function getAssistanceRequestsWorkShops($client_id)
    {
        try {
            $cliente = Client::where('user_id', $client_id)->first();

            $respuesta = Assistance_request::leftJoin('clients', 'clients.id', 'assistance_requests.client_id')
                ->leftJoin('users as CLI', 'CLI.id', 'clients.user_id')
                ->leftJoin('workshops', 'workshops.id', 'assistance_requests.workshop_id')
                ->leftJoin('users as TA', 'TA.id', 'workshops.user_id')
                ->leftJoin('technicians', 'technicians.id', 'assistance_requests.technician_id')
                ->leftJoin('vehicles', 'vehicles.id', 'assistance_requests.vehicle_id')

                ->select(
                    'assistance_requests.id as assistance_request_id',
                    'assistance_requests.problem_description as problem_description',
                    'assistance_requests.latitud as latitud',
                    'assistance_requests.longitud as longitud',
                    'assistance_requests.photos as photos',
                    'assistance_requests.voice_note as voice_note',
                    'assistance_requests.status as status',
                    'assistance_requests.created_at as assistance_request_date',

                    // CLIENTE
                    'assistance_requests.client_id as client_id',
                    'clients.phone as client_phone',
                    'clients.user_id as client_user_id',
                    'CLI.name as client_user_name',
                    'CLI.email as client_user_email',

                    // TALLER
                    'assistance_requests.workshop_id as workshop_id',
                    'workshops.description as workshop_description',
                    'workshops.location as workshop_location',
                    'workshops.contact_info as workshop_contact_info',
                    'TA.id as workshop_user_id',
                    'TA.name as workshop_user_name',
                    'TA.email as workshop_user_email',

                    // TECNICO
                    'assistance_requests.technician_id as technician_id',
                    'technicians.name as technicians',
                    'technicians.phone as technician_phone',

                    // VEHICULO
                    'assistance_requests.vehicle_id as vehicle_id',
                    'vehicles.brand as vehicle_brand',
                    'vehicles.model as vehicle_model',
                    'vehicles.year as vehicle_year',
                    'vehicles.licence_plate as vehicle_licence_plate',
                )
                ->where('assistance_requests.client_id', $cliente->id)
                ->get();

            return response()->json($respuesta, 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al procesar la solicitud de asistencia', 'error' => $th->getMessage()], 500);
        }
    }

    public function clientRequestAssistance(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'vehicle_id' => 'required|exists:vehicles,id',
                'latitud' => 'required',
                'longitud' => 'required',
                'photos' => 'required|image',
                'voice_note' => 'required',
             ]);

            $cliente = Client::where('user_id', $request->user_id)->first();
            $timestamp = time();
            $nombreImagen = $timestamp . '_' . $validatedData['photos']->getClientOriginalName();
            $nombreAudio = $timestamp . '_' . $validatedData['voice_note']->getClientOriginalName();
            $rutaImagen = $validatedData['photos']->storeAs('public/imagenes/assistance', $nombreImagen);
            $rutaAudio = $validatedData['voice_note']->storeAs('public/audios/assistance', $nombreAudio);
            $urlImagen = Storage::url($rutaImagen);
            $urlAudio = Storage::url($rutaAudio);
            $assistanceData = [
                'client_id' => $cliente->id,
                'vehicle_id' => $request->vehicle_id,
                'problem_description' => $request->problem_description,
                'latitud' => $request->latitud,
                'longitud' => $request->longitud,
                'photos' => $urlImagen,
                'voice_note' => $urlAudio,
                'status_id' => 1,
            ];
            $assistance = Assistance_request::create($assistanceData);
            return response()->json(['message' => 'Asistencia creada correctamente'], 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al procesar la solicitud de asistencia', 'error' => $th->getMessage()], 500);
        }
    }
}
