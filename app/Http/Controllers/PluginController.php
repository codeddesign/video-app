<?php

namespace App\Http\Controllers;

use App\User;
use App\WordpressSite;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PluginController extends Controller
{
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
            return $this->response([
                'error' => 'This site is not approved. Contact your admin.',
            ]);
        }

        $user = User::find($site->user_id);

        $campaign = $user->addCampaign([
            'type' => 'standard',
            'name' => '',
            'video' => $request->get('video_url'),
            'size' => 'auto',
        ]);

        return $this->response([
            'campaign' => $campaign->id,
            'youtube' => $campaign->video_url,
        ]);
    }

    /**
     * Cross-origin response.
     *
     * @param array $data
     *
     * @return Response|array
     */
    private function response(array $data)
    {
        return response($data)->header('Access-Control-Allow-Origin', '*');
    }
}
