<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use Illuminate\Support\Facades\Validator;
use DB;

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

    public function indexPaginate(Request $request)
    {
        $config = [];
        if ($request->has('config')) {
            switch ($request->config) {
                case ('1'):
                    $config = [
                        'actions' => [],
                    ];
                    break;
                case ('2'):
                    $config = [
                        'actionsCommon' => [],
                    ];
                    break;
                case ('3'):
                    $config = [
                        'actions' => [
                            [
                            'value' => '<i class="fa fa-trash" aria-hidden="true"></i>',
                            'title'=> 'Delete payment',
                            'action'=> '/payments/delete',
                            'method'=> 'post',
                            'message'=> 'Do you really want to delete payment?',
                            'disable' => 'check_box_disable'//условие здесь другое
                            ],
                        ],
                    ];
                    break;
            }
        }
        return view('payment.index_paginate', [
            'config' => json_encode($config),
        ]);
    }

    public function getDataPaginate(Request $request)
    {
        //$payments = new Payment;
        $perPage = ($request->has('per_page') && (int) $request->per_page > 0  ?
            (int) $request->per_page : config('vue.paginate'));
        $payments = Payment::select('payments.*');
        $payments->addSelect(DB::raw('(`payment_id` % 3 = 0) as disable_delete'));//доступно ли удаление - для примера
        $payments->addSelect(DB::raw('(`payment_id` % 5 = 0) as check_box_disable'));//доступен ли checkbox
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
            'payments' => $payments->paginate($perPage),
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
