<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use \Auth;

class AuthController extends Controller
{
    /**
     * @return View
     */
    public function getIndex()
    {
        return view('admin/login');
    }

    /**
     * @param  Request $request
     *
     * @return View
     */
    public function postIndex(Request $request)
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

        return redirect('/auth');
    }
}
