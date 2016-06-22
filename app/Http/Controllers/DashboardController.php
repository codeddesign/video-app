<?php

namespace App\Http\Controllers;

use App\Campaign;
use Illuminate\Http\Request;
use Input;

class DashboardController extends ControllerUser
{
    public function getIndex()
    {
        return view('dashboard.index');
    }

    /**
     * @return Redirect|View
     */
    public function getSettings()
    {
        if (!$this->user) {
            return redirect('/');
        }

        return view('dashboard.settings');
    }

    /**
     * @return Redirect|View
     */
    public function postSettings(Request $request)
    {
        if (!$this->user) {
            return redirect('/');
        }

        $data = $request->only(['password', 'confirm_password']);
        if ($data['password'] != $data['confirm_password']) {
            return view('dashboard.settings', [
                'error' => 'Passwords do not match',
            ]);
        }

        $this->user->password = $data['password'];
        $this->user->save();

        return redirect('/');
    }

    public function postGlobalSearch(Request $request)
    {
        $input = Input::all();

        $campaigns = Campaign::where('campaign_name', 'LIKE', '%' . $input['searchFor'] . '%')->get();

        return json_encode($campaigns);
    }
}
