<?php

namespace Increment\Common\Comment\Http;

use Illuminate\Http\Request;
use App\Http\Controllers\APIController;
use Increment\Common\Comment\Models\CommentReply;
use App\Jobs\Notifications;
use Carbon\Carbon;
class CommentReplyController extends APIController
{
    function __construct(){
      $this->model = new CommentReply();
    }

    public function createWithNotification(Request $request){
      $data = $request->all();
      $this->model = new CommentReply();
      $this->insertDB($data);
      if($this->response['data']){
        $data['topic'] = 'ticket-comment';
        $data['account'] = $this->retrieveAccountDetailsOnRequests($data['account_id']);
        $data['created_at_human'] = Carbon::now()->copy()->diffForHumans();
        Notifications::dispatch('comment-reply', $data);
      }
    }
}
