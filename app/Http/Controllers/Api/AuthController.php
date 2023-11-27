<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Technician;
use App\Models\User;
use App\Models\Workshop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function getUser(Request $request)
    {
        return $request->user();
    }
    public function users()
    {
        return User::all();
    }

    public function generateToken(Request $request)
    {
        try {
            //code...

            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
                'device_name' => 'required',
            ]);
 
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Credenciales incorrectas.',
                    'errors' => [
                        'email' => ['Datos Incorrectos.'],
                    ]
                ]);
            }
            return   $user->createToken($request->device_name)->plainTextToken;
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['token' => 'Hola']);

        }
    }

    public function revokeToken(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();

        return 'Tokens Eliminados';
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'rol_id' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'rol_id' => $request->input('rol_id'),
        ]);

        if ($request->input('rol_id') == "1") {
            Workshop::create([
                'user_id' => $user->id
            ]);
        }

        if ($request->input('rol_id') == "2") {
            Client::create([
                'user_id' => $user->id
            ]);
        }
        if ($request->input('rol_id') == "3") {
            Technician::create([
                'user_id' => $user->id,
                'workshop_id' => $request->workshop_id
            ]);
        }

        return  $user->createToken('AuthToken')->plainTextToken;
    }
}
