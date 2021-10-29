<?php

namespace Increment\Common\Page\Models;
use Illuminate\Database\Eloquent\Model;
use App\APIModel;
class Page extends APIModel
{
  protected $table = 'pages';
  protected $fillable = ['code', 'account_id', 'title', 'address', 'category'];
}
