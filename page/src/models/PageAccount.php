<?php

namespace Increment\Common\Page\Models;
use Illuminate\Database\Eloquent\Model;
use App\APIModel;
class PageAccount extends APIModel
{
  protected $table = 'page_roles';
  protected $fillable = ['status', 'account_id', 'page_id'];
}
