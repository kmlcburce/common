<?php

namespace Increment\Common\Cache\Http;

use Illuminate\Http\Request;
use App\Http\Controllers\APIController;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class CacheController extends APIController
{
    public function insert($key, $value){
        // $data = $request->all();
        // $key = $data['key'];
        // $value = $data['value'];
        $res = Cache::put($key, $value);
        return $res;
    }

    public function retrieve($key){
        // $data = $request->all();
        // $key = $data['key'];
        $data = Cache::get($key);
        return $data;
    }

    public function checkIfExist($key){
        return Cache::get($key);
    }
}
