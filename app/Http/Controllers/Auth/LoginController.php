<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $input = $request->all();
  
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);
        
        //$inactivo = \DB::select("SELECT exists (select 1 from users where name='{$request->username}' and estado='INACTIVO') existe")[0]->existe;
        

        /*if($inactivo) {
            
            return redirect()->route('login')
                ->with('error','Su usuario esta INACTIVO.');
        }*/
  
        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        
        if(auth()->attempt(array($fieldType => $input['username'], 'password' => $input['password'])))
        {
            return redirect()->route('home');
            /*if(auth()->user()->isRole('cliente')){
                return redirect("/");
            }
            else{
                return redirect()->route('home');
            }*/


        }else{
            return redirect()->route('login')
                ->with('error','El usuario o la contraseña son incorrectas.');
        }
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new Response('', 204)
            : redirect('/login');
    }
}
