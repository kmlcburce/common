<?php

namespace Increment\Common\Invitation\Models;
use Illuminate\Database\Eloquent\Model;
use App\APIModel;
class Invitation extends APIModel
{
    protected $table = 'invitations';
    protected $fillable = ['code', 'account_id', 'address', 'status'];

    public function getAccountIdAttribute($value){
      return intval($value);
    }

}
