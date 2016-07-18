<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * @return View
     */
    public function getIndex()
    {
        return view('app.profile.index');
    }

    /**
     * @param Request $request
     *
     * @return View|Redirect
     */
    public function postIndex(Request $request)
    {
        $data = $request->only(['password', 'confirm_password']);
        if ($data['password'] != $data['confirm_password']) {
            return view('app.profile.index', [
                'error' => 'Passwords do not match',
            ]);
        }

        $this->user->password = $data['password'];
        $this->user->save();

        return redirect('/app');
    }
}
