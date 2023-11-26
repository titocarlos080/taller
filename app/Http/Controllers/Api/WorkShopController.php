<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Workshop;
use Illuminate\Http\Request;

class WorkShopController extends Controller
{
    //$respuesta = Assistance_request::leftJoin('clients', 'clients.id', 'assistance_requests.client_id')
    // id |           description           |             location             | contact_info | user_id |     created_at      |     updated_at
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
}
