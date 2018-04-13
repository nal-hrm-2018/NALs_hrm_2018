<?php

namespace App\Http\Controllers\Auth;

use App\Models\Employee;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    public function getRegister()
    {
        if (Auth::guard()->check()) {
            return view('user.pages.home');
        }

        return view('user.pages.register');
    }

    public function register(Request $request)

    {
        $data = $request->only([
            'name',
            'email',
            'password'
        ]);

        $input = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ];
        $this->validator($input)->validate();
        $user = $this->create($input);
        if ($user) {
            Auth::login($user);

            return redirect()->action('/');
        }

        return redirect()
            ->action('Auth\LoginController@getRegister')
            ->with('message', trans('message.register_fail'));

    }
    protected function create( $data)
    {
        return Employee::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
