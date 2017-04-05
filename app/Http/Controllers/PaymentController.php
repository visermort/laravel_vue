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
            return json_encode(['status'=> false, 'message' => 'Ошибка при выполнении операции', 'id'=> $request->id]);
        }
    }
}
