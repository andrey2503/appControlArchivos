<?php

use Illuminate\Database\Seeder;
use App\SubExpediente;
class sub_carpetas extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $carpetas=array('Control constructivo',
    				'Clausuras y notificaciones',
    				'Orden de inspecciones'
    				);
    	foreach ($carpetas as  $c) {
    		# code...
    		$sub_carpetas = new SubExpediente();
    		$sub_carpetas->carpeta =  $c;
    		$sub_carpetas->save();
    	}// fin de foreach 

    }
}
