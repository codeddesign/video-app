<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\CampaignEvent;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Session;

class HomeController extends Controller
{
    /**
     * @return View
     */
    public function getIndex()
    {
        return view('home.index');
    }

    /**
     * @param bool    $id
     * @param Request $request
     *
     * @return Response
     */
    public function getCampaign(Request $request, $id = null)
    {
        $campaign = Campaign::forPlayer($id);
        if (!$campaign) {
            return $this->crossResponse(['message' => 'Campaign does not exist.'], 404);
        }

        CampaignEvent::create([
            'campaign_id' => $id,
            'name' => 'app',
            'event' => 'load',
        ]);

        return $this->crossResponse($campaign, 200);
    }
}
