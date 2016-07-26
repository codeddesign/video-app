<?php

namespace App\Http\Controllers;

use App\CampaignEvent;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('cors', [
            'only' => [
                'getIndex',
            ],
        ]);
    }

    public function getIndex(Request $request)
    {
        CampaignEvent::create([
            'campaign_id' => $request->get('i'),
            'name' => $request->get('n'),
            'event' => $request->get('e'),
        ]);

        return response($this->onePixel())
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
