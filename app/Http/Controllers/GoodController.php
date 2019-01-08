<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Good;
use App\Order;
use App\Payment;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GoodController extends Controller
{
    //
    public function index()
    {
        return view('goods.index');
    }

    public function get()
    {
        $goods = Good::all();
        $goods = $goods->each(function ($item, $key) {
            $item['id'] = $item->id;
            $item['title'] = $item->goods_name.' '.$item->goods_price;
        });
        return response()->json($goods);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:goods,goods_name',
            'price' => 'required|numeric',
        ]);
        $good = Good::create([
            'goods_name' => $request->name,
            'goods_price' => $request->price,
        ]);
        return response()->json(['good' => $good]);
    }

    public function orders($good_id, Request $request)
    {
        $orders = Order::where('order_good_id', $good_id)->get();
        $orders = $orders->each(function ($item, $key) {
            $item['id'] = $item->id;
            $item['title'] = 'Count '.$item->order_count.' summ '.$item->order_summ.' client '.
                $item->order_client_name.' '.$item->order_client_address;
        });
        return response()->json($orders);
    }

    /**
     * дерево открывается страница
     * @return mixed
     *
     */
    public function startTree()
    {
        return view('goods.tree');
    }

    /**
     * получаем список товаров
     * @return mixed
     */
    public function get2(Request $request)
    {
        if (!$request->ajax()) {
            throw new NotFoundHttpException();
        }
        $goods = Good::all();
        $goods = $goods->each(function ($item, $key) {
            $item['id'] = $item->id;
            $item['title'] = $item->goods_name.' price '.$item->goods_price;
            $item['isFolder'] = true;
            $item['childsLink'] = '/api/orders2/'.$item->id;//ссылка на дочерние
            $item['href'] = '/api/good/'.$item->id;//ссылка на объект
        });
        return response()->json($goods);
    }

    /**
     * список заказов для товара
     * @param $good_id
     * @return mixed
     */
    public function orders2($good_id, Request $request)
    {
        if (!$request->ajax()) {
            throw new NotFoundHttpException();
        }
        $orders = Order::where('order_good_id', $good_id)->get();
        $orders = $orders->each(function ($item, $key) {
            $item['id'] = $item->id;
            $item['title'] = 'Count '.$item->order_count.' summ '.$item->order_summ.' client '.
                $item->order_client_name;
            $item['isFolder'] = true;
            $item['childsLink'] = '/api/payment/' . $item->id;
            $item['href'] = '/api/order/'.$item->id;//ссылка на объект
        });
        return response()->json($orders);
    }

    /**
     * список оплат для заказа
     * @param $order_id
     * @return mixed
     */
    public function payment($order_id, Request $request)
    {
        if (!$request->ajax()) {
            throw new NotFoundHttpException();
        }
        $payments = Payment::where('payment_order_id', $order_id)->get();
        $payments = $payments->each(function ($item, $key) {
            $item['id'] = $item->id;
            $item['title'] = 'From '.$item->created_at.', summ '.$item->payment_summ.'. Status '.$item->paymentStatus();
            $item['isFolder'] = false;
            $item['childsLink'] = '';
            $item['href'] = '/api/payments/'.$item->id;//ссылка на объект
        });
        return response()->json($payments);
    }

    public function view($goodId, Request $request)
    {
        if (!$request->ajax()) {
            throw new NotFoundHttpException();
        }
        return response()->json([
            'object' => Good::find($goodId),
            'template' => 'good'
        ]);
    }

    public function orderView($orderId, Request $request)
    {
        if (!$request->ajax()) {
            throw new NotFoundHttpException();
        }
        return response()->json([
            'object' => Order::find($orderId),
            'template' => 'order'
        ]);
    }

}
