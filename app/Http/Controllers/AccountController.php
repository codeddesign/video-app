<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Auth;

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
     * @param Request $request
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
     * @param Request $request
     *
     * @return View|Redirect
     */
    public function postRegister(Request $request)
    {
        $this->redirectHomeWhenUser();

        $data = $request->only(['email', 'password']);

        if (User::whereEmail($data['email'])->first()) {
            return response()->json(['status' => 0]);
        } else {
            return response()->json(['status' => 1]);
        }

    }

    public function postVerify(Request $request)
    {
        $data = $request->all();

        $url = 'https://api.nexmo.com/verify/json?' . http_build_query([
                'api_key' => '43756f0f',
                'api_secret' => 'dee2bce0b4e8c12a',
                'number' => $data['number'],
                'brand' => 'Ad3'
            ]);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        $result = json_decode($response);

        if($result->status == 0) {
            return response()->json(['status' => 0, 'request_id' => $result->request_id]);
        } else if($result->status == 3) {
            return response()->json(['status' => 3]);
        } else if($result->status == 10) {
            return response()->json(['status' => 10]);
        }
    }

    public function getVerify(Request $request)
    {
        $data = $request->all();

        $url = 'https://api.nexmo.com/verify/check/json?' . http_build_query([
                'api_key' => '43756f0f',
                'api_secret' => 'dee2bce0b4e8c12a',
                'request_id' => $data['request_id'],
                'code' => $data['pin']
            ]);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        $result = json_decode($response);

        if($result->status == 0) {
            $user = User::create($data);
            Auth::login($user);

            return response()->json(['status' => 0]);
        } else if($result->status == 16) {
            return response()->json(['status' => 16]);
        }

        exit;
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
     * Redirect to home page.
     */
    protected function redirectHomeWhenUser()
    {
        if ($this->user) {
            Redirect::to('/')->send();
        }
    }
}
