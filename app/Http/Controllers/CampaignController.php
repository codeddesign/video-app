<?php

namespace App\Http\Controllers;

use App\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Session;

class CampaignController extends Controller
{
    /**
     * Key for session that holds the temporary preview data.
     */
    const TEMPORARY_PREVIEW_KEY = 'temporary_preview_key';

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
        return view('app.campaign.create', [
            'campaign_types' => json_encode(Campaign::$types),
            'campaign_sizes' => json_encode(Campaign::$sizes),
        ]);
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

        return [
            'message' => 'Campaign removed',
        ];
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
     * Save preview/temporary campaign and it's videos to session.
     *
     * @param Request $request
     *
     * @return array
     */
    public function postPreviewLink(Request $request)
    {
        $campaign = $this->user->addCampaign($request->all(), $toSession = true);

        Session::set(self::TEMPORARY_PREVIEW_KEY, $campaign);

        return [
            'url' => $this->getEmbedLink(),
        ];
    }

    /**
     * Save campaign and it's videos to database.
     * Remove preview/temporary campaign from session.
     *
     * @param Request $request
     *
     * @return array
     */
    public function postSave(Request $request)
    {
        $campaign = $this->user->addCampaign($request->all());

        Session::remove(self::TEMPORARY_PREVIEW_KEY);

        return [
            'url' => $this->getEmbedLink($campaign->id),
            'campaign' => $campaign,
        ];
    }

    /**
     * @param string $campaignId
     *
     * @return string
     */
    public function getEmbedLink($campaignId = 0)
    {
        $pattern = '%s/p%s.js';

        return sprintf($pattern, env('PLAYER_HOST'), $campaignId);
    }
}
