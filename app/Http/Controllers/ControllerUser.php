<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

abstract class ControllerUser extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct();

        if (!$this->user) {
            if ($request->ajax()) {
                abort('Not authenticated', 403);
            }

            Redirect::to('/account')->send();
            exit;
        }
    }
}
