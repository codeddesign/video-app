<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use \Auth;

class AccountController extends Controller
{
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
        $this->redirectHomeWhenUser();

        return view('account.login');
    }

    /**
     * @param  Request $request
     *
     * @return View|Redirect
     */
    public function postLogin(Request $request)
    {
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return view('admin/login', [
                'error' => 'Please enter your account again',
            ]);
        }

        return redirect('/');
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
        $this->redirectHomeWhenUser();

        return view('account.register');
    }

    /**
     * @param  Request $request
     *
     * @return View|Redirect
     */
    public function postRegister(Request $request)
    {
        $this->redirectHomeWhenUser();

        $data = $request->only(['email', 'password', 'confirm_password']);
        if ($data['password'] != $data['confirm_password']) {
            return view('account.register', ['error' => 'Passwords do not match']);
        }

        if (User::whereEmail($data['email'])->first()) {
            return view('account.register', ['error' => 'This account already exists']);
        }

        $user = User::create($data);

        Auth::login($user);

        return redirect('/');
    }

    /**
     * @return View
     */
    public function getRecover()
    {
        $this->redirectHomeWhenUser();

        return view('account.recover');
    }

    /**
     * @return View
     */
    public function postRecover()
    {
        $this->redirectHomeWhenUser();

        return view('account.recover'); // todo
    }

    /**
     * @return void
     */
    protected function redirectHomeWhenUser()
    {
        if ($this->user) {
            Redirect::to('/')->send();
        }
    }
}
