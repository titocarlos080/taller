<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

    
        // Configurar la clave secreta de Stripe
        Stripe::setApiKey(config('services.stripe.secret'));
       
        // Crear el PaymentIntent
        $paymentIntent = PaymentIntent::create([
            'amount' => $request->input('amount'),
            'currency' => 'usd', // Cambia esto según tu moneda
        ]);

        // Retornar la respuesta al cliente
        return response()->json(['client_secret' => $paymentIntent->client_secret]);
    }

}
