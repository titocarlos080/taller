<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Assistance_request;
use App\Models\Assistance_requests_workshop;
use App\Models\User;
use App\Models\Workshop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkShopController extends Controller
{
    public function getWorkShops()
    {
        try {
            //code...
            $workshops = Workshop::leftJoin('users', 'users.id', 'workshops.user_id')
                ->select(
                    'users.id as workshop_user_id',
                    'users.name as workshop_user_name',
                    'users.email as workshop_user_email',
                    'workshops.description as workshop_description',
                    'workshops.location as workshop_location',
                    'workshops.contact_info as workshop_contact_info',
                )
                ->get();

            return response()->json($workshops, 201);
        } catch (\Throwable $th) {
            //throw $th;
            return $th;
        }
    }
    public function designAssistance(Request $request)
    {
        try {

            $request->validate([
                'technician_id' => 'required',
                'assistance_request_id' => 'required',
                'price' => 'required',
                'user_id' => 'required|string',
            ]);
            $workshop = Workshop::where('user_id', $request->user_id)->first();
            Assistance_requests_workshop::create([
                'price' => $request->price,
                'workshop_id' => $workshop->id,
                'technician_id' => $request->technician_id,
                'assistance_request_id' => $request->assistance_request_id
            ]);
            $assistance = Assistance_request::where('id', $request->assistance_request_id)->first();
            $assistance->update(['status_id' => 2]);

            return response()->json(['message' => 'La asistenicca se designo corectamente'], 201);
        } catch (\Throwable $th) {

            return response()->json(['message' => 'Error al procesar la designacion', 'error' => $th->getMessage()], 500);
        }
    }
    public function terminarAssistance(Request $request)
    {
        try {
            $request->validate([
                'assistance_request_id' => 'required',
            ]);
            $assistance = Assistance_request::where('id', $request->assistance_request_id)->first();
            $assistance->update(['status_id' => 3]);

            return response()->json(['message' => 'La asistenicca se termino corectamente'], 201);
        } catch (\Throwable $th) {

            return response()->json(['message' => 'Error al procesar la designacion', 'error' => $th->getMessage()], 500);
        }
    }


    public function getGanancia($client_id)
    {

        $workshop = Workshop::where('user_id', $client_id)->first();

        $ganancia = Assistance_requests_workshop::where('workshop_id', $workshop->id)
            ->sum('price') ?? 0;
        return $ganancia;
    }
}
