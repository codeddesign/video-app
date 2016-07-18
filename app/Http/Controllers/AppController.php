<?php

namespace App\Http\Controllers;

use App\Services\Mail;
use App\Services\Nexmo;
use App\User;
use App\UserToken;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AppController extends Controller
{
    /**
     * Session key that holds the user information when attempting to create a new account.
     *
     * @string
     */
    const TEMPORARY_USER = 'TEMPORARY_USER';

    /**
     * @return View
     */
    public function getIndex()
    {
        if ($this->user) {
            return view('app.index');
        }

        return $this->getLogin();
    }

    /**
     * @return array
     */
    public function getLogin()
    {
        return view('auth.login');
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function postLogin(Request $request)
    {
        $credential = $request->only(['email', 'password']);

        if (!Auth::attempt($credential)) {
            return response(['message' => 'Credentials do not match our records'], 403);
        }

        $user = Auth::user();
        if (!$user->verified_phone) {
            $this->saveTemporary($user);

            return ['redirect' => '/app/register?step=phone'];
        }

        return ['redirect' => '/app'];
    }

    /**
     * @return View
     */
    public function getRegister()
    {
        return view('auth.register');
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function postRegister(Request $request)
    {
        $data = $request->only(['email', 'password']);

        $user = User::whereEmail($data['email'])->first();
        if ($user) {
            if (!$user->verified_phone) {
                return ['message' => 'This account already exists, but was never verified.'];
            }

            return response(['message' => 'This email already exists in our records.'], 403);
        }

        $user = User::create($data);

        Mail::sendVerificationEmail($user);

        $this->saveTemporary($user);

        return ['success' => true];
    }

    /**
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

    /**
     * @param Request $request
     *
     * @return array
     */
    public function postVerifyPhoneCode(Request $request)
    {
        try {
            $response = Nexmo::verifyCode($request->get('phone_code'));

            if ($response->status == 0) {
                $this->user->confirmedPhone();

                $this->removeTemporary();

                return ['success' => true];
            }

            return ['success' => false, 'message' => $response->error_text];
        } catch (\Exception $ex) {
            return response(['message' => $ex->getMessage()], 403);
        }
    }

    /**
     * @param string $code
     *
     * @return View
     */
    public function getVerifyEmail($code)
    {
        $success = UserToken::process($code);
        if (!$success) {
            return 'This link is no longer valid.';
        }

        return 'Your email is now verified! <a href="/app">Login</a>';
    }

    /**
     * @return View
     */
    public function getRecover()
    {
        return view('auth.recover');
    }

    /**
     * @return View
     */
    public function postRecover()
    {
        return 'todo';
    }

    /**
     * @return Redirect
     */
    public function getLogout()
    {
        Auth::logout();

        return redirect('/app');
    }

    /**
     * @return array
     */
    public function getToken()
    {
        return ['token' => csrf_token()];
    }

    /**
     * @param User $user
     */
    protected function saveTemporary(User $user)
    {
        Session::set(self::TEMPORARY_USER, $user);

        Auth::logout();
    }

    /**
     * @param User $user
     */
    protected function removeTemporary(User $user)
    {
        Session::remove(self::TEMPORARY_USER, $user);
    }
}
