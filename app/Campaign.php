<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        return $this->hasMany(Video::class);
    }

    /**
     * Humans readable time.
     */
    public function getCreatedAtHumansAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * @param array $data
     */
    public function addVideos(array $data)
    {
        $videos = Video::videosFromData($data);

        foreach ($videos as $video) {
            if (trim($video)) {
                Video::create([
                    'campaign_id' => $this->id,
                    'url' => $video,
                ]);
            }
        }
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
     *
     * @param int $id
     *
     * @return Campaign|null
     */
    public static function forPlayer($id)
    {
        $campaign = self::withTrashed()
            ->with('videos')
            ->find($id);

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
            ),
        ];
    }
}
