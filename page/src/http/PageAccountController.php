<?php

namespace Increment\Common\Page\Http;

use Illuminate\Http\Request;
use App\Http\Controllers\APIController;
use Increment\Common\Page\Models\PageAccount;
use Carbon\Carbon;

class PageAccountController extends APIController
{
  function __construct()
  {
    $this->model = new PageAccount();
  }
}
