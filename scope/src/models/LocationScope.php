<?php

namespace Increment\Common\Scope\Models;
use Illuminate\Database\Eloquent\Model;
use App\APIModel;
class LocationScope extends APIModel
{
  protected $table = 'location_scopes';
  protected $fillable = ['code', 'scope', 'city', 'region', 'country', 'latitude', 'longitude'];
}
