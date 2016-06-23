<?php

namespace App\Http\Controllers;

use App\MonthStats;
use App\User;
use Illuminate\Http\Request;

class CampaignController extends ControllerUser
{
    const CENTS = .3;

    public function getIndex()
    {
        return view('dashboard.campaign');
    }

    public function postIndex(Request $request)
    {
        $data = $request->only([
            'campaign_name',
            'video_url',
            'video_width',
            'video_height',
        ]);

        if (!$this->user->campaignByName($data['campaign_name'])) {
            $campaign = $this->user->addCampaign($data);

            return redirect('/campaign/view/'.$campaign->id);
        }

        return view('dashboard.campaign', [
            'error' => 'This campaign name is taken',
        ]);
    }

    public function getView($campaignId)
    {
        return view('dashboard.campaign', [
            'campaign' => $this->user->campaignById($campaignId),
        ]);
    }

    public function getDelete($campaignId)
    {
        $campaign = $this->user->campaignById($campaignId);

        if ($campaign) {
            $campaign->delete();
        }

        return redirect('/');
    }

    public function getStats()
    {
        $stats = MonthStats::current($this->user);

        return [
            'campaigns' => $this->user->campaigns,
            'stats' => $stats->data(),
        ];
    }
}
