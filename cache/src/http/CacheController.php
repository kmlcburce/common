<?php

namespace Increment\Common\Cache\Http;

use Illuminate\Http\Request;
use App\Http\Controllers\APIController;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class CacheController extends APIController
{
    public function insert($key, $value){
        $res = Cache::put($key, $value);
        return $res;
    }

    public function insertArray($keys, $value){
        $array = array();
        array_push($array, $value);
        $res = Cache::get($keys);
        if($res !== null){
            if(is_array($res)){
                $i=0;
                foreach ($res as $key) {
                    array_push($array, $key);
                    $i++;
                }
            }
        }
        $res = Cache::put($keys, $array);
        return $res;
    }

    public function retrieve($key){
        $data = Cache::get($key);
        return $data;
    }

    public function checkIfExist($key){
        return Cache::get($key);
    }
}
