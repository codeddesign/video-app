<?php

namespace App\Http\Controllers;

use App\Adcube\Nexmo;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Mail;
use Session;

class AccountController extends Controller
{
    /**
     * Session key that holds the user information when attempting to create a new account.
     *
     * @string
     */
    const SESSION_KEY = 'TEMPORARY_USER';

    /**
     * @return Redirect
     */
    public function getIndex()
    {
        return redirect('/account/login');
    }

    /**
     * @return View
     */
    public function getLogin()
    {
        $this->redirectWhenUser();

        return view('account.login');
    }

    /**
     * @param Request $request
     *
     * @return View|Redirect
     */
    public function postLogin(Request $request)
    {
        $credential = $request->only(['email', 'password']);

        if (!Auth::attempt($credential)) {
            return response(['message' => 'Credentials do not match our records'], 403);
        }

        $user = Auth::user();
        if (!$user->confirmation_code) {
            Session::set(self::SESSION_KEY, $user);

            Auth::logout();

            return ['redirect' => '/account/register?step=phone'];
        }

        return ['redirect' => '/dashboard'];
    }

    /**
     * @return Redirect
     */
    public function getLogout()
    {
        Auth::logout();

        return redirect('/');
    }

    /**
     * @return View
     */
    public function getRegister()
    {
        $this->redirectWhenUser();

        return view('account.register');
    }

    /**
     * @param Request $request
     *
     * @return View|Redirect
     */
    public function postRegister(Request $request)
    {
        $data = $request->only(['email', 'password']);

        $user = User::whereEmail($data['email'])->first();
        if ($user) {
            Session::set(self::SESSION_KEY, $user);

            if (!$user->confirmation_code) {
                return ['message' => 'This account already exists, but was never verified.'];
            }

            return response(['message' => 'This email already exists in our records.'], 403);
        }

        $user = User::create($data);

        Session::set(self::SESSION_KEY, $user);

        return ['success' => true];
    }

    /**
     * Phone number verify.
     *
     * @param Request $request
     */
    public function postVerifyPhone(Request $request)
    {
        try {
            $response = Nexmo::verifyNumber($request->get('phone'));

            return ['success' => 'true'];
        } catch (\Exception $ex) {
            return response(['message' => $ex->getMessage()], 403);
        }
    }

    public function postVerifyPhoneCode(Request $request)
    {
        try {
            $response = Nexmo::verifyCode($request->get('phone_code'));

            if ($response->status == 0) {
                $user = Session::get(self::SESSION_KEY);
                $user->confirmation_code = $request->get('phone_code');
                $user->save();

                Mail::send('account.email', ['confirmation_code' => $user['confirmation_code']], function ($message) use ($user) {
                    $message->from('noreply@ad3media.com', 'WebMaster');

                    $message->to($user['email'])->subject('Verify your email address');
                });

                Session::remove(self::SESSION_KEY);

                return ['success' => true];
            }

            return ['success' => false, 'message' => $response->error_text];
        } catch (\Exception $ex) {
            return response(['message' => $ex->getMessage()], 403);
        }
    }

    /**
     * Email Verify.
     *
     * @param Request $request
     */
    public function getEmailVerify($confirmation_code)
    {
        if (!$confirmation_code) {
            throw new InvalidConfirmationCodeException();
        }

        $user = User::whereConfirmationCode($confirmation_code)->first();

        if (!$user) {
            throw new InvalidConfirmationCodeException();
        }

        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();

        return view('account.login');
    }
    /**
     * @return View
     */
    public function getRecover()
    {
        $this->redirectWhenUser();

        return view('account.recover');
    }

    /**
     * @return View
     */
    public function postRecover()
    {
        $this->redirectWhenUser();

        return view('account.recover'); // todo
    }

    /**
     * Redirect to home page.
     */
    protected function redirectWhenUser()
    {
        if ($this->user) {
            Redirect::to('/dashboard')->send();
            exit;
        }
    }
}
