<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Storage;

class VastController extends Controller
{
    // public function getIndex(Request $request)
    // {
    //     $campaign = $request->get('c');

    //     $content = Storage::get('tag.xml');

    //     return response($content)
    //         ->header('Access-Control-Allow-Origin', '*')
    //         ->header('Content-Type', 'text/xml');
    // }

    public function getTrack(Request $request)
    {
        return response($this->onePixel())
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Content-Type', 'image/png');
    }

    protected function onePixel()
    {
        return base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII='
        );
    }
}
