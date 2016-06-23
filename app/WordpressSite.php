<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WordpressSite extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'link'];
}
