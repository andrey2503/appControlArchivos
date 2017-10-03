<?php

use Illuminate\Database\Seeder;
use App\SubExpediente;
use App\tipo_documento;
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
        $carpetas=array('Control construcción',
    				'Clausuras y notificaciones',
    				'Orden inspecciones'
    				);
    	foreach ($carpetas as  $c) {
    		# code...
    		$sub_carpetas = new SubExpediente();
    		$sub_carpetas->carpeta =  $c;
    		$sub_carpetas->save();
    	}// fin de foreach 

        $tipo_documento=array('Notificaciones',
                    'Clausura'
                         );
        foreach ($tipo_documento as  $t) {
            # code...
            $tipo = new tipo_documento();
            $tipo->tipo =  $t;
            $tipo->save();
        }// fin de foreach 
        

    }
}
