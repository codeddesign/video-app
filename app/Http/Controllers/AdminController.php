<?php

namespace App\Http\Controllers;

use App\Campaign;
use Input;

class AdminController extends ControllerUser
{
    public function index()
    {
        return view('admin.index', [
            'campaign'  => Campaign::whereUserId($this->user->id)->get(),
            'menu_flag' => [1, 0, 0, 0, 0, 0],
            'page_name' => 'DASHBOARD',
            'success'   => 'Welcome!',
        ]);
    }

    public function adminSearch()
    {
        $menu_flag = [1, 0, 0, 0, 0, 0];
        $page_name = "DASHBOARD";
        $input     = Input::all();

        $campaign = Campaign::all();

        return view('admin/index')->with(['campaign' => $campaign, 'menu_flag' => $menu_flag, 'page_name' => $page_name]);
    }
}
