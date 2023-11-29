<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Assistance_request;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
class PagoController extends Controller
{
    //
    public function mostrarFormularioPago()
    {
        return view('formulario_pago');
    }

    public function procesarPago(Request $request)
    {  
        try {
            //code...
            $request->validate([
                'assistance_request_id'=>'required',
                'workshop_id'=>'required',
                'technician_id'=>'required',
                'client_id'=>'required',
                'price'=>'required',
                ]);
                
                $asistence= Assistance_request::where('id',$request->assistance_request_id)->first();
               $asistence->upadate([
                'status_id'=>3
               ]);
            return response()->json(['message:'=>'El pago se realizo correctamente'],201);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['message' => 'error al realizar ppago', 'error' => $th,], 500);        }
       
     
    }

}
