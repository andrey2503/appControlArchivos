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
        $distrito=0;
    	$resultado = substr("pruebacadenas", 2);
    	for ($i=0; $i < 999; $i++) { 
            $distrito++;
            if($distrito==9){
                $distrito=1;
            }
    		if($i==10){
    		$valor = substr($valor, 1);
    		}
    		if($i==100){
    		$valor = substr($valor, 1);
    		}
    		$expediente= new Expediente();
    		$expediente->finca = $valor.$i;
	        $expediente->estado=1;
	        $expediente->distrito_id=$distrito;
	        $idUsuario=2;
	        $expediente->user_id=$idUsuario;
	        $expediente->save();
    	}
        // $this->call(UsersTableSeeder::class);
    }
}
