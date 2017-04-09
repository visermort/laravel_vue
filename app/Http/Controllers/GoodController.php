<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Good;
use App\Order;
use App\Payment;
use Illuminate\Support\Facades\Validator;

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
            $item['id'] = $item->goods_id;
            $item['title'] = $item->goods_name.' '.$item->goods_price;
        });
        return json_encode($goods);
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
        return json_encode(['good' => $good]);
    }

    public function orders($good_id)
    {
        $orders = Order::where('order_good_id', $good_id)->get();
        $orders = $orders->each(function ($item, $key) {
            $item['id'] = $item->order_id;
            $item['title'] = 'Count '.$item->order_count.' summ '.$item->order_summ.' client '.
                $item->order_client_name.' '.$item->order_client_address;
        });
        return json_encode($orders);
    }

    /**
     * дерево первый способ
     * @return mixed
     */
    public function startTree()
    {
        return view('goods.tree');
    }

    /**
     * дерево второй способ - открывается страница
     * @return mixed
     *
     */
    public function startTree2()
    {
        return view('goods.tree2');
    }

    /**
     * получаем список товаров
     * @return mixed
     */
    public function get2()
    {
        $goods = Good::all();
        $goods = $goods->each(function ($item, $key) {
            $item['id'] = $item->goods_id;
            $item['title'] = $item->goods_name.' price '.$item->goods_price;
            $item['isFolder'] = true;
            $item['childsLink'] = '/api/orders2/'.$item->goods_id;//ссылка на дочерние
            $item['href'] = '/api/good/'.$item->goods_id;//ссылка на объект
        });
        return json_encode($goods);
    }

    /**
     * список заказов для товара
     * @param $good_id
     * @return mixed
     */
    public function orders2($good_id)
    {
        $orders = Order::where('order_good_id', $good_id)->get();
        $orders = $orders->each(function ($item, $key) {
            $item['id'] = $item->order_id;
            $item['title'] = 'Count '.$item->order_count.' summ '.$item->order_summ.' client '.
                $item->order_client_name;
            $item['isFolder'] = true;
            $item['childsLink'] = '/api/payment/' . $item->order_id;
            $item['href'] = '/api/order/'.$item->order_id;//ссылка на объект
        });
        return json_encode($orders);
    }

    /**
     * списрк оплат для заказа
     * @param $order_id
     * @return mixed
     */
    public function payment($order_id)
    {
        $payments = Payment::where('payment_order_id', $order_id)->get();
        $payments = $payments->each(function ($item, $key) {
            $item['id'] = $item->payment_id;
            $item['title'] = 'From '.$item->created_at.', summ '.$item->payment_summ.'. Status '.$item->paymentStatus();
            $item['isFolder'] = false;
            $item['childsLink'] = '';
            $item['href'] = '/api/payments/'.$item->payment_id;//ссылка на объект
        });
        return json_encode($payments);
    }

    public function view($goodId)
    {
        return [
            'object' => Good::find($goodId),
            'template' => 'good'
        ];
    }

    public function orderView($orderId)
    {
        return [
            'object' => Order::find($orderId),
            'template' => 'order'
        ];
    }

}
