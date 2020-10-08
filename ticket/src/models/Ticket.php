<?php

namespace Increment\Common\Ticket\Models;

use Illuminate\Database\Eloquent\Model;
use App\APIModel;

class Ticket extends APIModel
{
    //
    protected $table = 'tickets';
    protected $fillable = ['code', 'complete_name', 'email_address', 'type', 'content', 'status', 'assigned_to'];
}




