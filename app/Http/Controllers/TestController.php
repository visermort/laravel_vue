<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function index()
    {
        return view('test.test');
    }
    
    public function comments()
    {
        return view('test.comments');
    }
    
    public function getComments(Request $request)
    {
        return json_encode([
            [ 'id' => 1,
                'data'=>'2017-03-20',
             'text' => 'sdafkj kajdsf dkafs kjdaf aldksfj'],
            [ 'id' => 2, 'data'=>'2017-03-21',
                'text' => 'jsakdfds akjdsfdsaf daksfjf sdafkj kajdsf dkafs kjdaf aldksfj'],
            [ 'id' => 3, 'data'=>'2017-03-22',
                'text' => 'sdafkj  kdfjdsaf dkjfdsaf kajdsf dkafs kjdaf aldksfj'],
            [ 'id' => 4, 'data'=>'2017-03-23',
                'text' => 'sdafkj dklasjfdis ieuf[woiaf ;adslkfjsd;  kajdsf dkafs kjdaf aldksfj'],
        ]);
    }
    
}
