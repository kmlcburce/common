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
  }
}
