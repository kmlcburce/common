<?php

namespace Increment\Common\Comment\Http;

use Illuminate\Http\Request;
use Increment\Common\Comment\Models\Comment;
use Increment\Common\Comment\Models\CommentReply;
use App\Http\Controllers\APIController;
use Carbon\Carbon;
class CommentController extends APIController
{
    function __construct(){
      $this->model = new Comment();
    }

    public function retrieve(Request $request){
      $data = $request->all();
      $this->retrieveDB($data);

      $result = $this->response['data'];
      if(sizeof($result) > 0){
        $i = 0;
        foreach ($result as $key) {
          $this->response['data'][$i]['account'] = $this->retrieveAccountDetails($result[$i]['account_id']);
          $this->response['data'][$i]['comment_replies'] = $this->getReplies($result[$i]['id']);
          // $this->response['data'][$i]['created_at_human'] = Carbon::createFromFormat($this->dateTimeFormat, $result[$i]['created_at'])->copy()->tz($this->response['timezone'])->diffInHumans();
          $this->response['data'][$i]['new_reply_flag'] = false;
          $i++;
        }
      }
      return $this->response();
    }

    public function retrieveComments(Request $request){
      $data = $request->all();
      $this->retrieveDB($data);

      $result = $this->response['data'];
      if(sizeof($result) > 0){
        $i = 0;
        foreach ($result as $key) {
          $this->response['data'][$i]['account'] = $this->retrieveAccountDetails($result[$i]['account_id']);
          $this->response['data'][$i]['comment_replies'] = $this->getReplies($result[$i]['id']);
          $this->response['data'][$i]['created_at_human'] = Carbon::createFromFormat('Y-m-d H:i:s', $result[$i]['created_at'], $this->response['timezone'])->copy()->format('F j, Y h:i A');
          $this->response['data'][$i]['new_reply_flag'] = false;
          $this->response['data'][$i]['members'] = app('App\Http\Controllers\CommentMemberController')->retrieveMemberWithInfo($result[$i]['id']);
          $i++;
        }
      }
      return $this->response();
    }

    public function getReplies($commentId){
      $this->localization();
      $result = CommentReply::where('comment_id', '=', $commentId)->orderBy('created_at', 'ASC')->get();
      if(sizeof($result) > 0){
        $i = 0;
        foreach ($result as $key) {
          $result[$i]['account'] = $this->retrieveAccountDetails($result[$i]['account_id']);
          // $result[$i]['created_at_human'] = Carbon::createFromFormat('Y-m-d H:i:s', $result[$i]['created_at'])->copy()->tz($this->response['timezone'])->format('F j, Y h:i A');
          $i++;
        }
        return $result;
      }else{
        return null;
      }
    }

    public function getComments($payload, $payloadValue){
      $result = Comment::where('payload', '=', $payload)->where('payload_value', '=', $payloadValue)->get();
      return sizeof($result);
    }
}
