<?php

use Illuminate\Database\Seeder;
use App\Distrito;
class Distritos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $distritos=array('Santo Domingo',
    				'San Vicente',
    				'San Miguel',
    				'Paracito',
    				'Santo Tomas',
    				'Santa Rosa',
    				'Tures',
    				'Para'
    				);
    	foreach ($distritos as  $d) {
    		# code...
    		$distrito = new Distrito();
    		$distrito->distrito =  $d;
    		$distrito->save();
    	}
        
    }
}
