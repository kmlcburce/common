<?php

namespace Increment\Common\Tutorial\Models;

use Illuminate\Database\Eloquent\Model;
use App\APIModel;

class Tutorial extends APIModel
{
    protected $table = 'tutorials';
    protected $fillable = ['account_id'];
}

