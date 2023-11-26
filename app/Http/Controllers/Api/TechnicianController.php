<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Technician;
use App\Models\User;
use App\Models\Workshop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TechnicianController extends Controller
{
    //
    public function createTechnician(Request $request)
    {
        try {

            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'password' => 'required',
                'rol_id' => 'required',
                'workshop_id' => 'required'
            ]);

            $workshop = Workshop::where('user_id', $request->workshop_id)->first();

            $user_tecnico =  User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->input('password')),
                'rol_id' => $request->rol_id
            ]);
            $user_tecnico->save();
             Technician::create([
                'phone' =>  $request->phone ? $request->phone : '',
                'workshop_id' => $workshop->id,
                'user_id' => $user_tecnico->id
            ]);
            return response()->json(['message' => 'tecnico creado satisfactoriamente',], 201);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['message' => 'error al crear tecnico', 'error' => $th,], 500);
        }
    }

    public function getTechnician($user_id)
    {


        try {
            //code...
            $workshops = Workshop::where('user_id', $user_id)->first();

            $workshops = Technician::leftJoin('users', 'users.id', 'technicians.user_id')
                ->leftJoin('workshops', 'workshops.id', 'technicians.workshop_id')
                ->select(
                    'users.id as technician_user_id',
                    'users.name as technician_user_name',
                    'users.email as technician_user_email',
                    'technicians.id as technician_id',
                    'technicians.phone as technician_phone',

                )
                ->where('workshops.id', $workshops->id)
                ->get();

            return response()->json($workshops, 201);
        } catch (\Throwable $th) {
            //throw $th;
            return $th;
        }
    }
}
