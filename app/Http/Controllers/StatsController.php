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

    public function postInfo(Request $request)
    {
        return [
            'types' => CampaignEvent::eventTypes(),
            'info' => CampaignEvent::eventList($request->all()),
        ];
    }
}
