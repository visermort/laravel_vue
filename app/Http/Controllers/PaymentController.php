<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    //
    public function index()
    {
        return view('payment.index');
    }
    
    public function getData()
    {
        return json_encode(['payments' => Payment::all()]);
    }
    
    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'id' => 'required|exists:payments,payment_id',
            ]);
        if ($validator->fails()) {
            return json_encode(['status'=> false, 'message' => 'Неправильные данные']);
        }
        if (($request->id % 2) == 0) {
            return json_encode(['status'=> true, 'message' => 'Операция успешно выполнена', 'id'=> $request->id]);
        } else {
            return json_encode([
                'status'=> false,
                'message' => 'Ошибка при выполнении операции для нечётных записей - тест',
                'id'=> $request->id
            ]);
        }
    }

    public function indexPaginate()
    {
        return view('payment.index_paginate');
    }

    public function getDataPaginate(Request $request)
    {
        if ($request->has('sort')) {
            $order = $request->get('dir') == 1 ? 'asc' : 'desc';
            $payments = Payment::orderBy($request->get('sort'), $order)->paginate(config('vue.paginate'));
        } else {
            $payments = Payment::paginate(config('vue.paginate'));
        }
        return json_encode([
            'payments' => $payments,
            'request' => $request->all(),
        ]);
    }

}
