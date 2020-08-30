<?php

namespace Increment\Common\Scope\Models;
use Illuminate\Database\Eloquent\Model;
use App\APIModel;
class ScopeLocation extends APIModel
{
  protected $table = 'scope_locations';
  protected $fillable = ['code', 'scope', 'city', 'region', 'country'];
}
