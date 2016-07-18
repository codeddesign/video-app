<?php

namespace App\Services;

use InvalidArgumentException;
use Session;
use Exception;

class Nexmo
{
    /**
     * @var string
     */
    const SESSION_KEY = 'NEXMO_SESSION';

    /**
     * @var array
     */
    protected static $API = [
        'number' => 'https://api.nexmo.com/verify/json?%s',
        'code' => 'https://api.nexmo.com/verify/check/json?%s',
    ];

    /**
     * @var array
     */
    private $query;

    /**
     * @var string
     */
    private $url;

    /**
     * @var array
     */
    private $response;

    /**
     * @param array  $config
     * @param array  $data
     * @param string $mode
     */
    public function __construct(array $config, array $data, $mode)
    {
        $this->setConfig($config)
            ->addData($data)
            ->setUrl($mode);
    }

    /**
     * @param string number
     *
     * @return array
     */
    public static function verifyNumber($number)
    {
        $key = env('NEXMO_KEY');
        $secret = env('NEXMO_SECRET');
        $brand = env('NEXMO_BRAND');

        $nexmo = new self(compact('key', 'secret', 'brand'), compact('number'), 'number');
        $nexmo->request();

        Session::set(self::SESSION_KEY, $nexmo->response());

        return $nexmo->response();
    }

    /**
     * @param int $code
     *
     * @return array
     */
    public static function verifyCode($code)
    {
        $key = env('NEXMO_KEY');
        $secret = env('NEXMO_SECRET');

        $data = Session::get(self::SESSION_KEY);
        if (!$data) {
            throw new Exception('Current session expired. Refresh the page and try again.');
        }

        $request_id = $data->request_id;
        $nexmo = new self(compact('key', 'secret'), compact('request_id', 'code'), 'code');
        $nexmo->request();

        Session::remove(self::SESSION_KEY);

        return $nexmo->response();
    }

    public function response()
    {
        if ($this->response->status != 0) {
            throw new Exception($this->response->error_text);
        }

        return $this->response;
    }

    /**
     * @return $this
     */
    public function request()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->url,
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        $this->response = json_decode(trim($response));

        return $this;
    }

    /**
     * @param string $mode
     */
    private function setUrl($mode)
    {
        if (!isset(self::$API[$mode])) {
            throw new InvalidArgumentException('Internal error: Unknown url mode "%s".');
        }

        $this->url = sprintf(self::$API[$mode], http_build_query($this->query));

        return $this;
    }

    /**
     * @param array $data
     */
    private function addData(array $data)
    {
        $this->checkValues($data, 'Error: A value for "%s" is required');

        $this->query = array_merge($this->query, $data);

        return $this;
    }

    /**
     * @param array $config
     */
    private function setConfig(array $config)
    {
        $this->checkValues($config, 'Internal error: Api "%s" is required');

        $this->query = $config;

        return $this;
    }

    /**
     * @param array  $data
     * @param string $exception
     *
     * @throws InvalidArgumentException
     */
    private function checkValues(array $data, $exception)
    {
        foreach ($data as $key => $value) {
            if (!trim($value)) {
                throw new InvalidArgumentException(
                    sprintf($exception, $key)
                );
            }
        }
    }
}
