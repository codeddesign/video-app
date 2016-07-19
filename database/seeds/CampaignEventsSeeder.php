<?php

use App\CampaignEvent;

class CampaignEventsSeeder extends DatabaseSeeder
{
    private $names = ['ad', 'video', 'app'];

    private $adEvents = [
        'alladscompleted',
        'contentResumeRequested',
        'contentPauseRequest',
        'failed:9',
        'failed:1',
        'failed:2',
        'failed:3',
        'failed:4',
        'failed:5',
        'failed:6',
        'failed:7',
        'failed:8',
        'failed:9',
        'failed:10',
        'loaded',
        'start',
        'complete',
        'click',
    ];

    public function run()
    {
        foreach (range(1, 1000000) as $ignoreme) {
            $name = $this->random(self::$names);
            switch ($name) {
                case 'app':
                    $event = 'load';
                case 'video':
                    $event = 'played';
                break;
                default:
                    $event = $this->random(self::$adEvents);
                break;
            }

            CampaignEvent::create([
                'campaign_id' => 1,
                'name' => $name,
                'event' => $event,
            ]);
        }
    }

    private function random($source)
    {
        $index = rand(0, count(self::$source) - 1);

        return self::$source[$index];
    }
}
