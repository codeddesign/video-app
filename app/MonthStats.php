<?php

namespace App;

class MonthStats
{
    /**
     * @var float
     */
    public $CENTS = .03;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var int
     */
    protected $year;

    /**
     * @var int
     */
    protected $month;

    /**
     * @var array
     */
    protected $monthData;

    /**
     * @var array
     */
    protected $dayData;

    /**
     * @var array
     */
    protected $campaignData;

    /**
     * @var array
     */
    private static $default = [
        'plays' => 0,
        'revenue' => 0,
    ];

    /**
     * @param User $user
     * @param int  $year
     * @param int  $month
     */
    public function __construct(User $user, $year, $month)
    {
        $this->user = $user;
        $this->year = $year;
        $this->month = $month;

        $this->setMonthData();

        $this->setDayData();
    }

    public static function current(User $user)
    {
        return new self($user, date('Y'), date('m'));
    }

    /**
     * @return array
     */
    public function data()
    {
        return [
            'month' => $this->monthData,
            'day' => $this->dayData,
            'campaign' => $this->campaignData,
        ];
    }

    protected function setMonthData()
    {
        $data = [
            'plays' => 0,
            'revenue' => 0,
            'list' => [
                'plays' => array_values($this->monthDays()),
                'revenue' => array_values($this->monthDays()),
            ],
        ];

        $campaigns = $this
            ->user->campaigns()
            ->with(['plays' => function ($query) {
                $query->whereBetween('created_at', $this::monthRange());
            }])
            ->get();

        foreach ($campaigns as $campaign) {
            $this->addCampaignData($campaign);

            $data['plays'] += $campaign->plays->count();
            $data['revenue'] += $campaign->plays->count() * $this->CENTS;

            $grouped = $campaign
                ->plays
                ->groupBy('day')
                ->map(function ($p) {
                    return $p->count();
                });

            foreach ($grouped as $key => $value) {
                $data['list']['plays'][$key] += $value;
                $data['list']['revenue'][$key] += $value * $this->CENTS;
            }
        }

        $this->monthData = $data;

        return $this;
    }

    protected function addCampaignData(Campaign $campaign)
    {
        $this->campaignData[$campaign->id] = [
            'plays' => $campaign->plays->count(),
            'revenue' => $campaign->plays->count() * $this->CENTS,
        ];

        return $this;
    }

    protected function setDayData()
    {
        $data = [
            'plays' => 0,
            'revenue' => 0,
            'list' => [
                'plays' => array_values($this->dayHours()),
                'revenue' => array_values($this->dayHours()),
            ],
        ];

        $campaigns = $this
            ->user->campaigns()
            ->with(['plays' => function ($query) {
                $query->whereBetween('created_at', $this->monthRange(date('Y-m-d'), date('Y-m-d')));
            }])
            ->get();

        foreach ($campaigns as $campaign) {
            $data['plays'] += $campaign->plays->count();
            $data['revenue'] += $campaign->plays->count() * $this->CENTS;

            $grouped = $campaign
                ->plays
                ->groupBy('hour')
                ->map(function ($p) {
                    return $p->count();
                });

            foreach ($grouped as $key => $value) {
                $key = ltrim($key, 0);

                $data['list']['plays'][$key] += $value;
                $data['list']['revenue'][$key] += $value * $this->CENTS;
            }
        }

        $this->dayData = $data;

        return $this;
    }

    /**
     * @param bool|string $from_date
     * @param bool|string $to_date
     *
     * @return array
     */
    protected function monthRange($from_date = false, $to_date = false)
    {
        if (!$from_date) {
            $from_date = date('Y-m-d', strtotime(implode('-', [$this->year, $this->month, '01'])));
        }

        if (!$to_date) {
            $to_date = date('Y-m-d', strtotime($from_date.' 1 month -1 second'));
        }

        return [
            $from_date.' 00:00:00',
            $to_date.' 23:59:59',
        ];
    }

    /**
     * @return array
     */
    protected function monthDays()
    {
        $last_day = cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);

        $days = [];
        foreach (range(1, $last_day) as $day) {
            $days[$day] = 0;
        }

        return $days;
    }

    /**
     * @return array
     */
    protected function dayHours()
    {
        $hours = [];
        foreach (range(0, 23) as $hour) {
            $hours[$hour] = 0;
        }

        return $hours;
    }
}
