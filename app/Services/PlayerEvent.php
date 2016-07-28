<?php

namespace App\Services;

use App\CampaignEvent;
use Storage;

class PlayerEvent
{
    /**
     * Query params map for db table.
     *
     * @var array
     */
    protected static $fields_map = [
        'campaign_id' => 'i',
        'name' => 'n',
        'event' => 'e',
    ];

    /**
     * On file event log pattern:
     * date&hour campaign_id name event ip referer.
     *
     * @var string
     */
    public static $file_log_pattern = '%s %s %s %s %s %s';

    /**
     * Save Campaign event to db or file.
     *
     * @param array $data
     *
     * @return mixed
     */
    public static function save(array $data)
    {
        $data = self::eventData($data);
        if (!$data) {
            return false;
        }

        if (stripos($data['event'], 'fail') === false) {
            return CampaignEvent::create($data);
        }

        return self::toFile($data);
    }

    /**
     * Validate query params and associte with table fields.
     *
     * @param array $query
     *
     * @return array|bool
     */
    protected static function eventData(array $query)
    {
        $data = [];
        foreach (self::$fields_map as $field => $key) {
            if (!isset($query[$key])) {
                return false;
            }

            if (!$query[$key]) {
                return false;
            }

            $data[$field] = $query[$key];
        }

        return $data;
    }

    /**
     * Save event to file.
     *
     * @param array $data
     *
     * @return mixed
     */
    protected static function toFile(array $data)
    {
        $body = sprintf(self::$file_log_pattern,
            date('Y-m-d h:i:s'),
            $data['campaign_id'],
            $data['name'],
            $data['event'],
            refererUtil(),
            ipUtil()
        );

        return Storage::put('ads/ad_'.date('Y-m-d').'.txt', $body);
    }
}
