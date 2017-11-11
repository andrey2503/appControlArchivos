<?php

use Illuminate\Database\Seeder;
use App\Expediente;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$valor="00000";
    	$resultado = substr("pruebacadenas", 2);
    	for ($i=6; $i < 999; $i++) { 
    		if($i==10){
    		$valor = substr($valor, 1);
    		}
    		if($i==100){
    		$valor = substr($valor, 1);
    		}
    		$expediente= new Expediente();
    		$expediente->finca = $valor.$i;
	        $expediente->estado=1;
	        $expediente->distrito_id=2;
	        $idUsuario=2;
	        $expediente->user_id=$idUsuario;
	        $expediente->save();
    	}
        // $this->call(UsersTableSeeder::class);
    }
}
