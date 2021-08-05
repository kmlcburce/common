<?php

namespace Increment\Common\Comment\Models;

use Illuminate\Database\Eloquent\Model;
use App\APIModel;

use Carbon\Carbon;
class Comment extends APIModel
{
  protected $table = 'comments';
  protected $fillable = ['account_id', 'payload', 'payload_value', 'text'];

  public function getAccountIdAttribute($value){
    return intval($value);
  }

  public function getCreatedAtAttribute($value){
    return Carbon::createFromFormat($this->dateTimeFormat, $value)->copy()->diffForHumans();
  }

}

