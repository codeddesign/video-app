<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use \Auth;

class AccountController extends Controller
{
    public function getIndex()
    {
        if ($this->user) {
            Redirect::to('/')->send();
        }

        return view('admin.register');
    }

    public function postIndex(Request $request)
    {
        $data = $request->only(['email', 'password', 'confirm_password']);
        if ($data['password'] != $data['confirm_password']) {
            return view('admin.register', ['error' => 'Passwords do not match']);
        }

        if (User::whereEmail($data['email'])->first()) {
            return view('admin.register', ['error' => 'This account already exists']);
        }

        $user = User::create($data);

        Auth::login($user);

        return redirect('/');
    }

    public function getRecover()
    {
        return view('admin.lost-password');
    }

    public function postRecover()
    {
        return view('admin.lost-password'); // todo
    }

    public function getEdit()
    {
        return view('admin/account-password', [
            'menu_flag' => [1, 0, 0, 0, 0, 0],
            'page_name' => 'EDIT ACCOUNT',
        ]);
    }

    public function postEdit(Request $request)
    {
        $data = $request->only(['password', 'confirm_password']);
        if ($data['password'] != $data['confirm_password']) {
            return view('admin.account-password', [
                'menu_flag' => [1, 0, 0, 0, 0, 0],
                'error'     => 'Passwords do not match',
                'page_name' => 'EDIT_ACCOUNT',
            ]);
        }

        $this->user->password = $data['password'];
        $this->user->save();

        return redirect('/');
    }
}
