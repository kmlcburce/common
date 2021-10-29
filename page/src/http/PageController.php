<?php

namespace Increment\Common\Page\Http;

use Illuminate\Http\Request;
use App\Http\Controllers\APIController;
use Increment\Common\Page\Models\Page;
use Carbon\Carbon;

class PageController extends APIController
{
  function __construct()
  {
    $this->model = new Page();
    $this->notRequired = array('additional_informations');
  }

  public function create(Request $request){
    $data = $request->all();
    $data['code'] = $this->generateCode();
    $this->model = new Page();
    $res = $this->insertDB($data);
    $this->response['data'] = $res;
    return $this->response();
  }

  public function generateCode()
  {
    $code = 'pge_' . substr(str_shuffle($this->codeSource), 0, 60);
    $codeExist = Page::where('code', '=', $code)->get();
    if (sizeof($codeExist) > 0) {
      $this->generateCode();
    } else {
      return $code;
    }
  }

}
