<?php

namespace App\Http\Controllers;

use App\CampaignPlay;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    public function getIndex(Request $request)
    {
        if ($request->get('event') == 'yt:playing') {
            CampaignPlay::create([
                'campaign_id' => $request->get('campaign'),
                'referer' => $_SERVER['HTTP_REFERER'],
            ]);
        }

        return response($this->onePixel())
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Content-Type', 'image/png');
    }

    /**
     * @return mixed
     */
    protected function onePixel()
    {
        return base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII='
        );
    }
}
