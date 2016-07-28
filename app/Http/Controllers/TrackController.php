<?php

namespace App\Http\Controllers;

use App\Services\PlayerEvent;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    /**
     * Add cors headers.
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware('cors', [
            'only' => [
                'getIndex',
            ],
        ]);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function getIndex(Request $request)
    {
        PlayerEvent::save($request->only('i', 'n', 'e'));

        return response($this->onePixel())
            ->header('Content-Type', 'image/png');
    }

    /**
     * One pixel image.
     *
     * @return mixed
     */
    protected function onePixel()
    {
        return base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII='
        );
    }
}
