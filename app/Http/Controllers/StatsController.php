<?php

namespace App\Http\Controllers;

use App\CampaignEvent;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function getIndex()
    {
        return view('stats.index');
    }

    public function getInfo(Request $request)
    {
        return CampaignEvent::stats($request->all());
    }
}
