<?php

namespace Increment\Common\Scope\Http;

use Illuminate\Http\Request;
use App\Http\Controllers\APIController;
use Increment\Common\Scope\Models\LocationScope;
use Carbon\Carbon;

class LocationScopeController extends APIController
{
  function __construct()
  {
    $this->model = new LocationScope();
    $this->notRequired = array('route', 'city', 'region');
  }

  public function retrieve(Request $request)
  {
    $data = $request->all();
    $this->retrieveDB($data);
    if (isset($data['condition'])) {
      $condition = $data['condition'];
      if (sizeof($condition) == 1) {
        $con = $condition[0];
        $this->response['size'] = LocationScope::where('deleted_at', '=', null)->where($con['column'], $con['clause'], $con['value'])->count();
      }
      if (sizeof($condition) == 2) {
        $con = $condition[0];
        $con1 = $condition[1];
        if ($con1['clause'] != 'or') {
          $this->response['size'] = LocationScope::where('deleted_at', '=', null)->where($con['column'], $con['clause'], $con['value'])->where($con1['column'], $con1['clause'], $con1['value'])->count();
        } else {
          $this->response['size'] = LocationScope::where('deleted_at', '=', null)->where($con['column'], $con['clause'], $con['value'])->orWhere($con1['column'], '=', $con1['value'])->count();
        }
      }
    } else {
      $this->response['size'] = LocationScope::where('deleted_at', '=', null)->count();
    }
    return $this->response();
  }

  public function createScope(Request $request)
  {
    $data = $request->all();
    $this->model = new LocationScope();
    $params = array(
      'city' => $data['city'],
      'code' => $data['code'],
      'country' => $data['country'],
      'latitude' => $data['latitude'],
      'longitude' => $data['longitude'],
      'region' => $data['region'],
      'route' => $data['route']
    );
    $this->insertDB($params);
    return $this->response();
  }

  public function retrieveByParams($route, $returns)
  {
    $result = LocationScope::where('route', '=', $route)->where('deleted_at', '=', null)->get($returns);
    return $result;
  }
}
