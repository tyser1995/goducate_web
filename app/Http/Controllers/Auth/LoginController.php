<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Socialite;
use Session;
use App\Models\User;

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
        
    //Google Login
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }
    
    //Google callback  
    public function handleGoogleCallback(Request $request){
        try {
            $user = Socialite::driver('google')->stateless()->user();
            // OAuth Two Providers
            $token = $user->token;
            $refreshToken = $user->refreshToken; // not always provided
            $expiresIn = $user->expiresIn;
            
            // OAuth One Providers
            $token = $user->token;
            $tokenSecret = $user->tokenSecret;
            //return $user->token;
        } catch (\Exception $e) {
            return redirect('/login')->withError(__('No account is linked to this email'));
        }
      
        // if(explode("@", $user->email)[1] !== 'cpu.com'){
        //     return redirect()->to('/');
        // }
        // check if they're an existing user
        $existingUser = User::where('email', $user->email)->first();
        
        if($existingUser){
            // log them in
            Auth::login($existingUser);
        }else{
            return redirect('/login')->withError(__('No account is linked to this email'));
            //account created
            // User::create([
            //     'name' => $user->name,
            //     'email' => $user->email,
            //     'password' => Hash::make('admin1234'),
            //     'role' => 4,
            // ]);
            // Auth::login($user->email);
        }
        return redirect(RouteServiceProvider::HOME);
    }

    public function login(Request $request)
    {
        $input = $request->all();
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
           
        ]);
        
        if (auth()->attempt(array('email' => $input['email'], 'password' => $input['password']))) {
            if (auth()->user()) {
                return redirect(RouteServiceProvider::HOME);
            }
        } else {
            return redirect()->back()->withError("Username and Password do not matched.!");
        }
    }
    
}