<?php

namespace Increment\Common\Comment\Models;

use Illuminate\Database\Eloquent\Model;
use App\APIModel;

class CommentReply extends APIModel
{
    protected $table = 'comment_replies';
    protected $fillable = ['account_id', 'comment_id', 'text'];

    public function getAccountIdAttribute($value){
      return intval($value);
    }

    public function getCommentIdAttribute($value){
      return intval($value);
    }

}
