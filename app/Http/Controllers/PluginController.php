<?php

namespace App\Http\Controllers;

use App\User;
use App\WordpressSite;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PluginController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('cors', [
            'only' => [
                'getCampaignAdd',
            ],
        ]);
    }

    public function getIndex()
    {
    }

    /**
     * It creates a new campaign.
     *
     * @param Request $request
     *
     * @return array
     */
    public function getCampaignAdd(Request $request)
    {
        $site = WordpressSite::byLink(refererUtil());
        if (!$site) {
            return response(['error' => 'This site is not approved. Contact your admin.']);
        }

        $user = User::find($site->user_id);

        $campaign = $user->addCampaign([
            'type' => 'standard',
            'name' => '',
            'video' => $request->get('video_url'),
            'size' => 'auto',
        ]);

        return response([
            'campaign' => $campaign->id,
        ]);
    }
}
