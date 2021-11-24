<?php

namespace Increment\Common\Page\Http;

use Illuminate\Http\Request;
use App\Http\Controllers\APIController;
use Increment\Common\Page\Models\PageRole;
use Carbon\Carbon;

class PageRoleController extends APIController
{
  function __construct()
  {
    $this->model = new PageRole();
  }
}
