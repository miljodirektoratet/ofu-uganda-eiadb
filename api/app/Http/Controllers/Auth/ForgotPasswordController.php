<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

use Response;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use ResetsPasswords;
/**
   * Create a new password controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->subject = trans('messages.reset_email_subject');
  }

  /**
   * Display the form to request a password reset link.
   *
   * @return Response
   */
  public function getEmail()
  {
    return Response::json(['message' => trans('messages.api_only')], 400);
  }

  /**
   * Send a reset link to the given user.
   *
   * @param  Request  $request
   * @return Response
   */
  public function sendResetLinkEmail(Request $request)
  {
    $this->validate($request, ['email' => 'required|email']);

    $response = \Password::sendResetLink($request->only('email'));

    switch ($response)
    {
      case PasswordBroker::RESET_LINK_SENT:
        return Response::json(['message' => trans($response)], 200);

      case PasswordBroker::INVALID_USER:
        return Response::json(['error' => trans($response)], 422);
    }
  }

  public function postReset(Request $request)
  {
    $this->validate($request, [
      'token' => 'required',
      'email' => 'required|email',
      'password' => 'required|confirmed|min:8',
    ]);

    $credentials = $request->all(
      'email', 'password', 'password_confirmation', 'token'
    );

    $response = \Password::reset($credentials, function($user, $password)
    {
      $user->password = bcrypt($password);

      $user->save();

      \Auth::login($user);
    });

    switch ($response)
    {
      case PasswordBroker::PASSWORD_RESET:
        return Response::json(['message' => trans($response)], 200);

      default:
        return Response::json(['error' => trans($response)], 422);
    }
  }

}