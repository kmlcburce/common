<?php

namespace Increment\Common\Scope\Http;

use Illuminate\Http\Request;
use App\Http\Controllers\APIController;
use Increment\Common\Scope\Models\ScopeLocation;
use Carbon\Carbon;
class ScopeLocationController extends APIController
{
	function __construct(){
		$this->model = new ScopeLocation();
      $this->notRequired = array('route', 'city', 'region');
	}
}
