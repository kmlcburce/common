<?php

namespace Increment\Common\Ticket\Models;

use Illuminate\Database\Eloquent\Model;
use App\APIModel;

class Ticket extends APIModel
{
    //
    protected $table = 'tickets';
    protected $fillable = ['code', 'account_id', 'type', 'content', 'images', 'status', 'assigned_to'];
}




