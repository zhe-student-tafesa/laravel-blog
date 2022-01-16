<?php

namespace App\Http\Model;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Config  extends Authenticatable
{
     
    protected $table="config";
    protected $primaryKey="conf_id";  //设置 主键 是user_id
    public $timestamps= false;
    public $guarded= [];// 没有需要保护的 



     
 
}
