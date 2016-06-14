<?php

namespace App\Http\Controllers;

use App\Campaign;
use Illuminate\Http\Request;
use Input;

class AdminController extends ControllerUser
{
    public function getIndex()
    {
        return view('admin.index', [
            'campaign'  => Campaign::whereUserId($this->user->id)->get(),
            'menu_flag' => [1, 0, 0, 0, 0, 0],
            'page_name' => 'DASHBOARD',
            'success'   => 'Welcome!',
        ]);
    }

    public function postGlobalSearch(Request $request)
    {
        $input = Input::all();

        $menu_flag = [1, 0, 0, 0, 0, 0];
        $page_name = "DASHBOARD";

        $campaigns = Campaign::where('campaign_name', 'LIKE', '%' . $input['searchFor'] . '%')->get();

        return json_encode($campaigns);
    }
}
