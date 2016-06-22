<?php

namespace App;

use App\User;
use Illuminate\Support\Collection;

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
     * @var integer
     */
    protected $year;

    /**
     * @var integer
     */
    protected $month;

    /**
     * @var Collection
     */
    protected $campaigns;

    /**
     * @var array
     */
    protected $onMonth = [];

    /**
     * @var array
     */
    protected $onDay = [];

    /**
     * @var array
     */
    protected $onHour = [];

    /**
     * @var array
     */
    protected $total = [];

    /**
     * @var array
     */
    private static $default = [
        'plays'   => 0,
        'revenue' => 0,
    ];

    /**
     * @param User    $user
     * @param integer $year
     * @param integer $month
     */
    public function __construct(User $user, $year, $month)
    {
        $this->user  = $user;
        $this->year  = $year;
        $this->month = $month;

        $this->campaigns = $this->user->campaigns()
             ->with(['plays' => function ($query) {
                 $query->whereBetween('created_at', $this::monthRange());
             }])
             ->get();

        $this->setCampaignsStats();

        $this->setTotalStats();
    }

    public static function current(User $user)
    {
        return new self($user, date('Y'), date('m'));
    }

    /**
     * @return array
     */
    public function all()
    {
        return [
            'onMonth' => $this->onMonth,
            'onDay'   => $this->onDay,
            'onHour'  => $this->onHour,
        ];
    }

    /**
     * @return array
     */
    public function total()
    {
        return $this->total;
    }

    /**
     * @return $this
     */
    protected function setCampaignsStats()
    {
        foreach ($this->campaigns as $campaign) {
            $this->onMonth[$campaign->id] = $this->playsAndRevenue($campaign->plays);

            $this->onDay[$campaign->id] = $this->getCampaignOnGroup(
                $campaign,
                'day',
                $this->monthDays()
            );

            $this->onHour[$campaign->id] = $this->getCampaignOnGroup(
                $campaign,
                'hour',
                $this->dayHours()
            );
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function setTotalStats()
    {
        foreach (['onDay', 'onHour'] as $key) {
            if (!isset($total[$key])) {
                $this->total[$key] = [];
            }

            foreach ($this->{$key} as $campaignId => $chunks) {
                foreach ($chunks as $chunkId => $data) {
                    if (!isset($this->total[$key][$chunkId])) {
                        $this->total[$key][$chunkId] = self::$default;
                    }

                    $this->total[$key][$chunkId]['plays'] += $data['plays'];
                    $this->total[$key][$chunkId]['revenue'] += $data['revenue'];
                }
            }
        }

        foreach ($this->onMonth as $campaignIn => $data) {
            if (!isset($this->total['onMonth'])) {
                $this->total['onMonth'] = self::$default;
            }

            $this->total['onMonth']['plays'] += $data['plays'];
            $this->total['onMonth']['revenue'] += $data['revenue'];
        }

        return $this;
    }

    /**
     * @param  Campaign $campaign
     * @param  string   $groupedBy
     * @param  array    $add
     *
     * @return array
     */
    private function getCampaignOnGroup(Campaign $campaign, $groupedBy, $add)
    {
        $plays = $campaign
            ->plays
            ->groupBy($groupedBy)
            ->map(function ($plays) {
                return $this->playsAndRevenue($plays);
            })
            ->toArray();

        $plays = $plays + $add;

        ksort($plays);

        return $plays;
    }

    /**
     * @param  Collection $plays
     *
     * @return array
     */
    protected function playsAndRevenue(Collection $plays)
    {
        return [
            'plays'   => $plays->count(),
            'revenue' => $plays->count() * $this->CENTS,
        ];
    }

    /**
     * @return array
     */
    protected function monthRange()
    {
        $from_date = date('Y-m-d', strtotime(implode('-', [$this->year, $this->month, '01'])));
        $to_date   = date('Y-m-d', strtotime($from_date . ' 1 month -1 second'));

        return [
            $from_date,
            $to_date,
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
            $days[$day] = self::$default;
        }

        return $days;
    }

    /**
     * @return array
     */
    protected function dayHours()
    {
        $hours = [];
        foreach (range(1, 24) as $hour) {
            $hours[$hour] = self::$default;
        }

        return $hours;
    }
}
