<?php

namespace Increment\Common\Image\Http;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Increment\Common\Image\Models\Image;
use App\Http\Controllers\APIController;
use Illuminate\Support\Facades\Storage;
class ImageController extends APIController
{
    function __construct(){
      if($this->checkAuthenticatedUser() == false){
        return $this->response();
      }
      $this->model = new Image();
    }

    public function retrieve(Request $request){
      $data = $request->all();
      $this->model = new Image();
      $this->retrieveDB($data);
      if(sizeof($this->response['data']) > 0){
        $i = 0;
        foreach ($this->response['data'] as $key) {
          $this->response['data'][$i]['active'] = false;
          $i++;
        }
      }
      return $this->response();
    }

    public function upload(Request $request){
      $data = $request->all();
      if(isset($data['file_url'])){
        $date = Carbon::now()->toDateString();
        $time = str_replace(':', '_',Carbon::now()->toTimeString());
        $ext = $request->file('file')->extension();
        $fileUrl = str_replace(' ', '_', $data['file_url']);
        $fileUrl = str_replace('%20', '_', $fileUrl);
        $filename = $data['account_id'].'_'.$date.'_'.$time.'_'.$fileUrl;
        $result = $request->file('file')->storeAs('images', $filename);
        $url = '/storage/image/'.$filename;
        $this->model = new Image();
        $insertData = array(
          'account_id'    => $data['account_id'],
          'url'           => $url
        );
        $this->insertDB($insertData);
        $this->response['data'] = $url;
        return $this->response();
      }
      return response()->json(array(
        'data'  => null,
        'error' => null,
        'timestamps' => Carbon::now()
      ));
    }

    public function uploadUnLink(Request $request){
      $data = $request->all();
      if(isset($data['file_url'])){
        $date = Carbon::now()->toDateString();
        $time = str_replace(':', '_',Carbon::now()->toTimeString());
        $ext = $request->file('file')->extension();
        $filename = $data['account_id'].'_'.$date.'_'.$time.'.'.$ext;
        $result = $request->file('file')->storeAs('images', $filename);
        $url = '/storage/image/'.$filename;
        $this->response['data'] = $url;
        return $this->response();
      }
      return response()->json(array(
        'data'  => null,
        'error' => null,
        'timestamps' => Carbon::now()
      ));
    }

    public function uploadBase64(Request $request){
      $data = $request->all();
      if(isset($data['file_base64'])){
        $date = Carbon::now()->toDateString();
        $time = str_replace(':', '_',Carbon::now()->toTimeString());
        $filename = $data['account_id'].'_'.$date.'_'.$time.'.png';
        $image = base64_decode($data['file_base64']);
        Storage::disk('local')->put('images/'.$filename, $image);
        $url = '/storage/image/'.$filename;
        $this->response['data'] = $url;
        return $this->response();
      }
      return response()->json(array(
        'data'  => null,
        'error' => null,
        'timestamps' => Carbon::now()
      ));
    }

}
