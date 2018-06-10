<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use Illuminate\Support\Facades\Validator;
use DB;
use Faker;

class PaymentController extends Controller
{
    /** вывод таблицы
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $config = [];
        //из сессии - сохранённое значение элементов на страницу
        if ($request->session()->has('grid-paginate-per-page') &&
            (int) $request->session()->get('grid-paginate-per-page') > 0) {
            $config['perPage'] = $request->session()->get('grid-paginate-per-page');
        }
        //в зависимости от параметров  - разная конфигурация
        if ($request->has('config')) {
            switch ($request->config) {
                case ('1'):
                    $config['actions'] = [];
                    break;
                case ('2'):
                    $config['actionsCommon'] = [];
                    break;
                case ('3'):
                    $config['actions'] = [
                        [
                            'value' => '<i class="fa fa-trash" aria-hidden="true"></i>',
                            'title'=> 'Delete payment',
                            'action'=> '/payments/delete',
                            'method'=> 'post',
                            'message'=> 'Do you really want to delete payment?',
                            'disable' => 'check_box_disable'//условие здесь другое
                        ],
                    ];
                    break;
            }
        }
        return view('payment.index', [
            'config' => json_encode($config),

        ]);
    }

    /**
     * ответ на тестовый запрос на удаление
     * @param Request $request
     * @return string
     */
    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'id' => 'required|exists:payments,id',
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

    /** ответ на тестовый запрос на редактирование
     * @param $payment_id
     * @return string
     */
    public function edit($payment_id)
    {
        return view('service.under_construction');
    }

    /**
     * ответ на тестовый запрос на экспорт
     * @return string
     */
    public function export()
    {
        return json_encode([
            'status'=> false,
            'message' => 'Service under constuction!',
        ]);
    }

    /**
     * данные для таблицы
     * @param Request $request
     * @return string
     */
    public function getData(Request $request)
    {
        //$payments = new Payment;
        $perPage = ($request->has('per_page') && (int) $request->per_page > 0  ?
            (int) $request->per_page : config('vue.paginate'));
        $request->session()->put('grid-paginate-per-page', $perPage);
        $payments = Payment::select('payments.*');
        $payments->addSelect(DB::raw('(`id` % 3 = 0) as disable_delete'));//доступно ли удаление - для примера
        $payments->addSelect(DB::raw('(`id` % 5 = 0) as check_box_disable'));//доступен ли checkbox
        $searchMethods = $request->has('search_methods') ? $request->get('search_methods') : false;
        if ($request->has('search')) {
            foreach ($request->get('search') as $key => $item) {
                $searchMethod = $searchMethods && isset($searchMethods[$key]) ? $searchMethods[$key] : '';
                if ($searchMethod == 'between') {
                    $itemArray = explode(' - ', $item);
                    $payments->whereBetween($key, $itemArray);
                } elseif ($searchMethod == 'equal') {
                    $payments->where($key, '=', $item);
                } else {
                    $payments->where($key, 'like', '%' . $item . '%');
                }
            }
        }

        if ($request->has('sort')) {
            $order = $request->get('dir') == 1 ? 'asc' : 'desc';
            $payments = $payments->orderBy($request->get('sort'), $order);
        }
        return json_encode([
            'sql' => $payments->toSql(),
            'bindings' => $payments->getBindings(),
            'payments' => $payments->paginate($perPage),
            'request' => $request->all(),

        ]);
    }

    /**
     * данные при клике на платёж - получение информации о платеже
     * @param $payment_id
     * @return string
     */
    public function getContentData($payment_id)
    {
        if (!is_int((int) $payment_id)) {
            abort(404);
        }
        $payment = Payment::find($payment_id);
        $faker = Faker\Factory::create();

        if ($payment) {
            return json_encode([
                'payment' => $payment,
                'order' => $payment->order,
                'payments' => $payment->order->payments,
                'text' => $faker->realText(),
                'good' => $payment->order->good,
                'paymentStatuses' => Payment::$paymentStatuses
            ]);
        } else {
            abort(404);
        }
    }


    /**
     * @param $paymentId
     * @return array
     */
    public function view($paymentId)
    {
        return [
            'object' => Payment::find($paymentId),
            'template' => 'payment'
        ];
    }

}
