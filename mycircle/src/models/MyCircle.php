<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\APIModel;
class MyCircle extends APIModel
{
    protected $table = 'my_circles';
    protected $fillable = ['code', 'account_id', 'account', 'status'];

    public function getAccountIdAttribute($value){
      return intval($value);
    }
}
