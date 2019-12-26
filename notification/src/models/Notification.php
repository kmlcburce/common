<?php

namespace Increment\Common\Notification\Models;

use Illuminate\Database\Eloquent\Model;
use App\APIModel;

class Notification extends APIModel
{
    protected $table = 'notifications';
    protected $fillable = ['from', 'to', 'payload', 'payload_value', 'route'];

    public function getFromAttribute($value){
      return intval($value);
    }
    
    public function getToAttribute($value){
      return intval($value);
    }

}

