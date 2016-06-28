<?php

namespace App\Http\Controllers;

use App\User;
use App\WordpressSite;
use Illuminate\Http\Request;

class PluginController extends Controller
{
    public function getCampaignAdd(Request $request)
    {
        $site = WordpressSite::byLink($request->server('HTTP_REFERER'));
        if (!$site) {
            return $this->corsResponse([
                'error' => 'This site is not approved. Contact your admin.',
            ]);
        }

        $user = User::find($site->user_id);
        if ($user->campaignByName($request->get('campaign_name'))) {
            return $this->corsResponse([
                'error' => 'This campaign name is taken.',
            ]);
        }

        $campaign = $user->addCampaign($request->only('campaign_name', 'video_url'));

        return $this->corsResponse([
            'play_id' => $campaign->play_id,
        ]);
    }

    private function corsResponse($body)
    {
        return response($body)
            ->header('Access-Control-Allow-Origin', '*');
    }
}
