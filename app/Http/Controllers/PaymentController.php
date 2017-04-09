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
            return json_encode(['status'=> false, 'message' => 'Wrong data']);
        }
        if (($request->id % 2) == 0) {
            return json_encode(['status'=> true, 'message' => 'Payment deleted - test', 'id'=> $request->id]);
        } else {
            return json_encode([
                'status'=> false,
                'message' => 'Error deleting odd payment - test',
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
        $payments = new Payment;
        if ($request->has('search')) {
            $payments = $payments->where('payment_id', 'like', '%'.$request->get('search').'%');
            $payments = $payments->orWhere('payment_order_id', 'like', $request->get('search').'%');
            $payments = $payments->orWhere('payment_summ', 'like', $request->get('search').'%');
            $payments = $payments->orWhere('payment_client_name', 'like', $request->get('search').'%');
            $payments = $payments->orWhere('payment_client_phone', 'like', $request->get('search').'%');
        }

        if ($request->has('sort')) {
            $order = $request->get('dir') == 1 ? 'asc' : 'desc';
            $payments = $payments->orderBy($request->get('sort'), $order);
        }
        return json_encode([
            'sql' => $payments->toSql(),
            'payments' => $payments->paginate(config('vue.paginate')),
            'request' => $request->all(),
            
        ]);
    }

    public function view($paymentId)
    {
        return [
            'object' => Payment::find($paymentId),
            'template' => 'payment'
        ];
    }

}
