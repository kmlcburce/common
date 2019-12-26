<?php

namespace Increment\Common\Rating\Models;

use Illuminate\Database\Eloquent\Model;
use App\APIModel;

class Rating extends APIModel
{
    protected $table = 'ratings';
    protected $fillable = ['account_id', 'payload', 'payload_value', 'value'];

    public function getAccountIdAttribute($value){
      return intval($value);
    }

    public function getValueAttribute($value){
      return intval($value);
    }
}

