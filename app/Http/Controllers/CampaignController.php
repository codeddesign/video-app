<?php

namespace App\Http\Controllers;

use App\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class CampaignController extends Controller
{
    /**
     * @return View
     */
    public function getIndex()
    {
        return view('app.campaign.index');
    }

    /**
     * @return View
     */
    public function getCreate()
    {
        return view('app.campaign.create', ['campaign_types' => json_encode(Campaign::$types)]);
    }

    public function getList()
    {
        return [
            'campaigns' => $this->user->campaigns,
        ];
    }

    /**
     * @param int $campaignId
     *
     * @return Redirect
     */
    public function getDelete($campaignId)
    {
        $campaign = $this->user->campaignById($campaignId);

        if ($campaign) {
            $campaign->delete();
        }

        return redirect('/app/campaign');
    }

    /**
     * @param int $campaignId
     *
     * @return string
     */
    public function getView($campaignId)
    {
        return 'todo';
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function postPreviewLink(Request $request)
    {
        return [
            'url' => self::jsEmbedLink(0),
        ];
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function postSave(Request $request)
    {
        $campaign = $this->user->addCampaign($request->all());

        return [
            'url' => self::jsEmbedLink($campaign->id),
            'campaign' => $campaign,
        ];
    }

    /**
     * @param string $campaignId
     *
     * @return string
     */
    protected static function jsEmbedLink($campaignId)
    {
        $pattern = '%s/p%s.js';

        return sprintf($pattern, env('PLAYER_HOST'), $campaignId);
    }
}
