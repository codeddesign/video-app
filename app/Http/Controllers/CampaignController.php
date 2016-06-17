<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\CampaignPlay;
use App\Http\Controllers\ControllerUser;
use App\User;
use Illuminate\Http\Request;

class CampaignController extends ControllerUser
{
    public function getCreate()
    {
        return view('admin/create-campaign', [
            'menu_flag' => [0, 1, 0, 0, 0, 0],
            'page_name' => 'CREATE CAMPAIGN',
            'success'   => 'Please create new campaign',
        ]);
    }

    public function postCreate(Request $request)
    {
        $data = $request->only([
            'campaign_name',
            'video_url',
            'video_width',
            'video_height',
        ]);

        $exists = Campaign::whereCampaignName($data['campaign_name'])->first();
        if ($exists) {
            return view('admin.create-campaign', [
                'page_name' => 'CREATE CAMPAIGN',
                'menu_flag' => [0, 1, 0, 0, 0, 0],
                'success'   => 'The campaign already exists',
            ]);
        }

        $data['user_id'] = $this->user->id;

        $campaign = Campaign::create($data);

        return redirect('/campaign/view/' . $campaign->id);
    }

    public function getView($campaignId)
    {
        $campaign = Campaign::whereUserId($this->user->id)
            ->whereId($campaignId)
            ->first();

        return view('admin/create-campaign', [
            'campaign'  => $campaign,
            'menu_flag' => [0, 1, 0, 0, 0, 0],
            'page_name' => 'DASHBOARD',
        ]);
    }

    public function getDelete($campaignId)
    {
        $campaign = Campaign::whereUserId($this->user->id)
            ->whereId($campaignId)
            ->first();

        if ($campaign) {
            $campaign->delete();
        }

        return redirect('/');
    }

    public function getStats()
    {
        $stats = CampaignPlay::stats($this->user->id);

        if (!$stats) {
            abort(404);
        }

        return [
            'by_campaign' => $stats['by_campaign'],
            'by_date'     => array_values($stats['by_date']),
            'by_hour'     => array_values($stats['by_hour']),
        ];
    }
}
