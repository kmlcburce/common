<?php

namespace Increment\Common\Notification\Models;

use Illuminate\Database\Eloquent\Model;
use App\APIModel;

class Notification extends APIModel
{
    protected $table = 'notifications';
    protected $fillable = ['id', 'from', 'to', 'payload', 'payload_value', 'route'];
}

