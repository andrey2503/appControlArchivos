<?php

namespace App\Http\Controllers\Auth;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Session;
use App\SubExpediente;
use App\Distrito;
use Hash;
class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    // use AuthenticatesAndRegistersUsers, ThrottlesLogins;


    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->middleware('guest', ['except' => 'getLogout']);

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */



//login

       protected function getLogin()
    {
        return view("auth.login");
    }

    public function iniciarUsuarioAdmin(){
            $user = new User();
            $user->name="Andrey Torres Vega";
            $user->email = "admin@admin.com";
            $user->user="admin";
            $user->idrol = 1;
            $user->password = Hash::make('admin');
            $user->state=1;
            $user->save();
    }//fin de iniciarUsuarioAdmin
    public function iniciarDistritos(){
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
    }// fin de iniciarDistritos
    public function iniciarSubCarpetas(){
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
    public function instalacion(){
        if(count(User::all())==0){
           $this->iniciarUsuarioAdmin();
           $this->iniciarDistritos();
           $this->iniciarSubCarpetas();
           return view('instalacion');
        }else{
            return redirect('/login');
        }
    }//


        public function postLogin(Request $request)
   {
    // dd($request);
    $this->validate($request, [
        'usuario' => 'required',
        'password' => 'required',
    ]);
    // $credentials = $request->only('user', 'password');
   if (\Auth::attempt(['user' => $request->usuario, 'password' => $request->password])) {
       $usuarioactual=\Auth::user();
       return redirect('/');
    }
    return redirect('/login');
    }
//     protected function getRegister()
// {
//     return view("registro");
// }
//         protected function postRegister(Request $request)
//    {
//     $this->validate($request, [
//         'name' => 'required',
//         'email' => 'required',
//         'password' => 'required',
//     ]);
//     $data = $request;
//     $user=new User;
//     $user->name=$data['name'];
//     $user->email=$data['email'];
//     $user->password=bcrypt($data['password']);
//     if($user->save()){

//          return "se ha registrado correctamente el usuario";

//     }
// }

//registro

protected function getLogout()
    {
        $this->auth->logout();
        Session::flush();
        return redirect('login');
    }
}
