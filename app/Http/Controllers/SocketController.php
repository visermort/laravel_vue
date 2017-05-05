<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use lRedis;
use Illuminate\Support\Facades\Redis;


class SocketController extends Controller
{

    public function index()
    {
        return view('socket.welcome');
    }
    
    public function message()
    {
        return view('socket.message');
    }

    public function sendMessage(Request $request)
    {
        try {
            $redis = Redis::connection();

            if ($redis) {
                $redis->publish('message', $request->get('message'));
            }
        } catch (Exception $exception) {
            Log::error('Error writing to redis ' . $exception->getMessage());
        }

        return redirect('/message');
    }
    
}
