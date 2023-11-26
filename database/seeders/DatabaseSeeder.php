<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Assistance_request;
use App\Models\Client;
use App\Models\Rol;
use App\Models\Status;
use App\Models\Technician;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Workshop;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $rol_taller = Rol::create(['name'=>'taller']);
        $rol_tecnico = Rol::create(['name'=> 'tecnico']);
        $rol_cliente = Rol::create(['name'=>'cliente']);
        $stado_disponible = Status::create(['name'=>'disponible']);
        $stado_trabajando = Status::create(['name'=> 'trabajando']);
        $stado_terminado = Status::create(['name'=>'terminado']);

        $taller = User::create([
            'name' => 'Tito Carlos',
            'email' => 'titocarlos080@gmail.com',
            'password' => bcrypt('123'),
            'rol_id' => $rol_taller->id
        ]);

        $tallerTecn = Workshop::create([
            'description' => 'Somos un taller de Primer nivel',
            'location' => 'Los lotes entre 8vo y 9no anillo',
            'contact_info' => '30236526',
            'user_id' => $taller->id
        ]);

        $tecnico1_user =  User::create([
            'name' => 'Don juan',
            'email' => 'juan@gmail.com',
            'password' => bcrypt('123'),
            'rol_id' => $rol_tecnico->id
        ]);

        $tecnico2_user =  User::create([
            'name' => 'Don Verto',
            'email' => 'verto@gmail.com',
            'password' => bcrypt('123'),
            'rol_id' => $rol_tecnico->id
        ]);

        $tecnico1 = Technician::create([
            'phone' => '10235894',
            'workshop_id' => $tallerTecn->id,
            'user_id' => $tecnico1_user->id
        ]);
        $tecnico2 = Technician::create([
            'phone' => '10235894',
            'workshop_id' => $tallerTecn->id,
            'user_id' =>  $tecnico2_user->id
        ]);

        $cliente = User::create([
            'name' => 'Juan Roca',
            'email' => 'cliente1@gmail.com',
            'password' => bcrypt('123'),
            'rol_id' => $rol_cliente->id
        ]);

        $cliVehicle = Client::create([
            'phone' => '78415875',
            'user_id' => $cliente->id
        ]);

        $vehiculo1 = Vehicle::create([
            'brand' => 'Toyota',
            'model' => 'Corolla',
            'year' => 2011,
            'licence_plate' => '123ABC',
            'client_id' => $cliVehicle->id
        ]);

        $vehiculo2 = Vehicle::create([
            'brand' => 'Mazda',
            'model' => 'CX5',
            'year' => 2022,
            'licence_plate' => '456SDF',
            'client_id' => $cliVehicle->id
        ]);


        Assistance_request::create([
            'client_id' => $cliVehicle->id,
            'vehicle_id' => $vehiculo1->id,
            'problem_description' => 'Se frego el carrito',
            'latitud' => -17.851482,
            'longitud' => -63.166290,
            'photos' => '/storage/imagenes/assistance/1700976352_download.jpg',
            'voice_note' => '/storage/audios/assistance/1700984668_audio2973876614514860828.m4a',
            'status_id' =>$stado_disponible->id
        ]);

        Assistance_request::create([
            'client_id' => $cliVehicle->id,
            'vehicle_id' => $vehiculo2->id,
            'problem_description' => 'No da el radiador',
            'latitud' => -17.851482,
            'longitud' => -63.166290,
            'photos' => '/storage/imagenes/assistance/1700976352_download.jpg',
            'voice_note' => '/storage/audios/assistance/1700984668_audio2973876614514860828.m4a',
            'status_id' => $stado_disponible->id
        ]);
        
    }
}
