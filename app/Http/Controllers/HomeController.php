<?php

namespace App\Http\Controllers;

use App\Campaign;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redis;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('cors', [
            'only' => [
                'getCampaign',
            ],
        ]);
    }

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
        if ($id != 0 && $campaign = Redis::get('campaign.'.$id)) {
            return $this->campaignResponse($campaign);
        }

        if (!$campaign = Campaign::forPlayer($id)) {
            return $this->campaignResponse();
        }

        Redis::set('campaign.'.$id, json_encode($campaign));

        return $this->campaignResponse($campaign);
    }

    /**
     * @param bool|array $campaign
     *
     * @return Response
     */
    protected function campaignResponse($campaign = false)
    {
        if (!$campaign) {
            return response(['message' => 'Campaign does not exist.'], 404);
        }

        if (is_string($campaign)) {
            $campaign = json_decode($campaign, true);
        }

        return response(array_merge($campaign, [
            'tags' => env_adTags(),
            'ip' => ipUtil(),
        ]));
    }
}
