<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    //
  public function getStatus($status_id){
  try {
    //code...
 $estado =   Status::where('id',$status_id)->first();
    return $estado->nombre;
    
  } catch (\Throwable $th) {
    //throw $th;
return response()->json(['error'=>'error al obtenr estado'],500);
}
  }

}
