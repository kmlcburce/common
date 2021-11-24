<?php

namespace Increment\Common\System\Models;

use Illuminate\Database\Eloquent\Model;
use App\APIModel;

class SystemNotification extends APIModel
{
    protected $table = 'system_notifications';
    protected $fillable = ['account_id', 'code', 'device', 'payload', 'title', 'description'];

    public function getAccountIdAttribute($value){
      return intval($value);
    }

}

