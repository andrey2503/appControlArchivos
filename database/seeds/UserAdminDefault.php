<?php

use Illuminate\Database\Seeder;
use App\User;
class UserAdminDefault extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
         //Model::unguard();
        //Creamos usuario
        $user = new User();
        $user->name="Andrey Torres Vega";
        $user->email = "admin@admin.com";
        $user->user="admin";
        $user->idrol = 1;
        $user->password = Hash::make('admin');
        $user->state=1;
        $user->save();

        $user = new User();
        $user->name="Andrey Torres Vega";
        $user->email = "andy@admin.com";
        $user->user="andy";
        $user->idrol = 2;
        $user->password = Hash::make('andy');
        $user->state=1;
        $user->save();
    }
}
