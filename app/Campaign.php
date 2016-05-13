<?php
 
namespace App;
 
use Illuminate\Database\Eloquent\Model;
 
class Campaign extends Model
{
    protected $table = 'campaign';
 
    protected $fillable = ['id', 'campaign_name','ad_name','video_url','video_size','video_plays','revenue','active','created_at','updated_at'];

  
}
 