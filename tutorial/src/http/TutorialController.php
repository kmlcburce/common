<?php

namespace Increment\Common\Tutorial\Http;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Increment\Common\Tutorial\Models\Tutorial;
use App\Http\Controllers\APIController;
class TutorialController extends APIController
{
    function __construct(){
      $this->model = new Tutorial();
    }
}
