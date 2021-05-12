<?php

namespace Increment\Common\Scope\Http;

use Illuminate\Http\Request;
use App\Http\Controllers\APIController;
use Increment\Common\Scope\Models\LocationScope;
use Carbon\Carbon;
class LocationScopeController extends APIController
{
	function __construct(){
		$this->model = new LocationScope();
      $this->notRequired = array('route', 'city', 'region');
	}

  public function retrieve(Request $request){
    $data = $request->all();
    $this->retrieveDB($data);
    $this->response['size'] = LocationScope::where('deleted_at', '=', null)->count();
    return $this->response();
  }

  public function createScope(Request $request){
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

}
