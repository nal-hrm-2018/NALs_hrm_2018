<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorizationRequest;
use App\Models\Employee;
use App\Http\Requests\LoginRequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function getLogin()
    {
        if (Auth::guard()->check()) {
            return back();
        }
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {

        $remember = $request->get('remember');

        $data = $request->only([
            'email',
            'password',
        ]);

        if (Auth::attempt(
            [
                'email' => $data['email'],
                'password' => $data['password'],
            ], $remember)
        ) {

            return redirect()->intended(action('User\DashboardController@index'));
        }
        return redirect()
            ->action('Auth\LoginController@getLogin')
            ->with('msg_fail', trans('auth.failed'));
    }
}
