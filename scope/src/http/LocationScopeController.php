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
    $this->response['size'] = LocationScope::count();
    return $this->response();
  }
}
