<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WordpressSite extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'domain'];

    /**
     * @var array
     */
    protected $appends = ['link'];

    /**
     * @param string $link
     */
    public function setDomainAttribute($link)
    {
        $this->attributes['domain'] = self::linkDomain($link);
    }

    /**
     * @return string
     */
    public function getLinkAttribute()
    {
        return 'http://'.$this->domain;
    }

    /**
     * @param string $link
     *
     * @return null|WordpressSite
     */
    public static function byLink($link)
    {
        return self::whereDomain(self::linkDomain($link))->first();
    }

    /**
     * @param string $link
     *
     * @return string
     */
    protected static function linkDomain($link)
    {
        $parsed = parse_url($link);

        $domain = strtolower($parsed['host']);

        return str_replace('www.', '', $domain);
    }
}
