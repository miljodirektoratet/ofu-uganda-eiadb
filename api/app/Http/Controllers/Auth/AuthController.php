<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use \Illuminate\Http\Request;

use Response;

class AuthController extends Controller {

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

  use AuthenticatesAndRegistersUsers;

  /**
   * Create a new authentication controller instance.
   *
   * @param  \Illuminate\Contracts\Auth\Guard  $auth
   * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
   * @return void
   */
  public function __construct(Guard $auth, Registrar $registrar)
  {
    $this->auth = $auth;
    $this->registrar = $registrar;
  }

  /**
   * Show the application registration form.
   *
   * @return \Illuminate\Http\Response
   */
  public function getRegister()
  {
    return Response::json(['message' => trans('messages.not_supported')], 400);
  }

  /**
   * Handle a registration request for the application.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function postRegister(Request $request)
  {
    return Response::json(['message' => trans('messages.not_supported')], 400);
  }

  /**
   * Show the application login form.
   *
   * @return \Illuminate\Http\Response
   */
  public function getLogin()
  {
    return Response::json(['message' => trans('messages.api_only')], 400);
  }

  /**
   * Handle a login request to the application.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function postLogin(Request $request)
  {
    $this->validate($request, [
      'initials' => 'required', 'password' => 'required',
    ]);

    $credentials = $request->only('initials', 'password');

    if ($this->auth->attempt($credentials, $request->has('remember')))
    {
      return Response::json(['message' => trans('messages.logged_in')], 200);
    }
    return Response::json(['error' => $this->getFailedLoginMessage()], 400);
  }

  /**
   * Log the user out of the application.
   *
   * @return \Illuminate\Http\Response
   */
  public function getLogout()
  {
    $this->auth->logout();

    return Response::json(['message' => trans('messages.logged_out')], 200);
  }
}