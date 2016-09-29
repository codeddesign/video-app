<?php

namespace App;

use App\Http\Controllers\CampaignController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;

class Campaign extends Model
{
    use SoftDeletes;

    /**
     * List of campaigns/ad types that are available.
     *
     * Important:
     *  Main keys like 'sidebarrow' should NOT be changed.
     *  Available for edit are only the values, like 'Sidebar Row'
     *
     * @var array
     */
    public static $types = [
        'sidebarrow' => [
            'title' => 'Sidebar Row',
            'available' => false,
            'single' => false,
            'has_name' => true,
        ],
        'actionoverlay' => [
            'title' => 'Action Overlay',
            'available' => false,
            'single' => false,
            'has_name' => true,
        ],
        'standard' => [
            'title' => 'Standard',
            'available' => true,
            'single' => true,
            'has_name' => false,
        ],
        'halfpagegallery' => [
            'title' => 'Half-Page Gallery',
            'available' => false,
            'single' => false,
            'has_name' => false,
        ],
        'fullwidthgallery' => [
            'title' => 'Full-Width Gallery',
            'available' => false,
            'single' => false,
            'has_name' => true,
        ],
        'horizontalrow' => [
            'title' => 'Horizontal Row',
            'available' => false,
            'single' => false,
            'has_name' => true,
        ],
        'onscrolldisplay' => [
            'title' => 'On-Scroll Display',
            'available' => true,
            'single' => true,
            'has_name' => true,
        ],
        'incontentgallery' => [
            'title' => 'In Content Gallery',
            'available' => false,
            'single' => false,
            'has_name' => true,
        ],
        'sidebarinfinity' => [
            'title' => 'Sidebar infinity',
            'available' => true,
            'single' => true,
            'has_name' => true,
        ],
     ];

    /**
     * @var array
     */
    public static $sizes = [
        'auto' => 'auto',
        'small' => '560x315',
        'medium' => '640x360',
        'large' => '853x480',
        'hd720' => '1280x720',
    ];

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'name', 'type', 'rpm', 'size'];

    /**
     * @var array
     */
    protected $appends = ['created_at_humans'];

    /**
     * @return mixed
     */
    public function videos()
    {
        return $this->hasMany(Video::class, 'campaign_id');
    }

    /**
     * Humans readable time.
     * We handle missing created_at when is temporary/on-session.
     */
    public function getCreatedAtHumansAttribute()
    {
        if (!$this->created_at) {
            return '1 second ago';
        }

        return $this->created_at->diffForHumans();
    }

    /**
     * It saves them to database only if $toSession is false.
     *
     * @param array $data
     * @param bool  $toSession
     *
     * @return array
     */
    public function addVideos(array $data, $toSession = false)
    {
        $videos = Video::videosFromData($data);

        $list = [];
        foreach ($videos as $url) {
            if (trim($url)) {
                $video = new Video();
                $video->fill([
                    'campaign_id' => $this->id,
                    'url' => $url,
                ]);

                if (!$toSession) {
                    $video->save();
                }

                $list[] = $video->toArray();
            }
        }

        return $list;
    }

    /**
     * @param string $type
     *
     * @return array
     */
    public static function byType($type)
    {
        return self::$types[$type];
    }

    /**
     * @param string $type
     *
     * @return bool
     */
    public static function typeHasName($type)
    {
        $type = self::byType($type);

        return $type['has_name'];
    }

    /**
     * Returns campaign details and information about campaign's type.
     * First it makes and attempt to fetch campaign data from session,
     *  in case it's some data in preview. Otherwise, if non-zero id
     *  is provided it gets it from database.
     *
     * @param int $id
     *
     * @return Campaign|null
     */
    public static function forPlayer($id)
    {
        $campaign = Session::get(CampaignController::TEMPORARY_PREVIEW_KEY);

        if ($id != 0) {
            $campaign = self::withTrashed()
                ->with('videos')
                ->find($id);
        }

        if (!$campaign) {
            return false;
        };

        $info = self::$types[$campaign->type];
        $info['type'] = $campaign->type;

        return [
            'campaign' => filterModelKeys(
                $campaign->toArray(),
                ['id', 'name', 'size', 'url', 'source']
            ),
            'info' => filterModelKeys(
                $info,
                ['type', 'available', 'single', 'has_name']
            )
        ];
    }
}
