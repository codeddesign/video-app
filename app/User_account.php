<?php
 
namespace App;
 
use Illuminate\Database\Eloquent\Model;
 
class User_account extends Model
{
    protected $table = 'user_account';
 
    protected $fillable = ['id', 'username','password','created_at','updated_at'];

  
}
 