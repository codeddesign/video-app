<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Http\Controllers\ControllerUser;
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
            'ad_name',
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
            'campaign_name' => $campaign->campaign_name,
            'video_url'     => $campaign->video_url,
            'video_width'   => $campaign->video_width,
            'video_height'  => $campaign->video_height,
            'menu_flag'     => [0, 1, 0, 0, 0, 0],
            'page_name'     => 'DASHBOARD',
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
}
