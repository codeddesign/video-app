<?php

namespace App\Services;

use InvalidArgumentException;
use App\Video;

class Youtube
{
    /**
     * Gets youtube video's title.
     *
     * @param string|array $url
     *
     * @return string|bool
     */
    public static function title($data)
    {
        $url = self::urlFromData($data);

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        if (preg_match('/<title>(.*?)<\/title>/i', $response, $matched)) {
            $title = str_ireplace('- youtube', '', $matched[1]);

            return trim($title);
        }

        return false;
    }

    /**
     * @param string|array $url
     *
     * @return string|bool
     */
    public static function id($url)
    {
        if (is_array($url)) {
            $url = self::urlFromData($url);
        }

        if (!trim($url)) {
            return false;
        }

        $parsed = parse_url($url);

        if (!isset($parsed['query'])) {
            throw new InvalidArgumentException('Provided links is not valid.');
        }

        foreach (explode('&', $parsed['query']) as $data) {
            list($key, $value) = explode('=', $data);

            $pairs[$key] = trim($value);
        }

        return $pairs['v'];
    }

    /**
     * @param array $data
     *
     * @return string
     */
    private static function urlFromData($data)
    {
        return Video::videosFromData($data)[0];
    }
}
