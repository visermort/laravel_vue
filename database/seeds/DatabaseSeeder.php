<?php

use Illuminate\Database\Seeder;
use App\Good;
use App\Order;
use App\Payment;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            DB::table('payments')->delete();
            DB::table('orders')->delete();
            DB::table('goods')->delete();

            $faker = Faker::create();
            for ($i=0; $i<10; $i++) {
                $good = Good::create([
                    'goods_name' => $faker->word,
                    'goods_price' => $faker->randomFloat(2, 1, 10000),
                ]);
                for ($j=0; $j<10; $j++) {
                    $count = mt_rand(1, 20);
                    $order = Order::create([
                        'order_good_id' => $good->id,
                        'order_good_price' => $good->goods_price,
                        'order_count' => $count,
                        'order_summ' => $good->goods_price * $count,
                        'order_client_name' => $faker->name,
                        'order_client_phone' => $faker->phoneNumber,
                        'order_client_address' => $faker->address,
                    ]);
                    $payCount = mt_rand(1, 3);
                    for ($k=0; $k < $payCount; $k++) {
                        Payment::create([
                            'payment_order_id' => $order->id,
                            'payment_summ' => $order->order_summ,
                            'payment_client_name' => $order->order_client_name,
                            'payment_client_phone' => $order->order_client_phone,
                            'payment_status' => $k,

                        ]);
                    }

                }
            }
        });

        $this->call(Calendar::class);
        $this->call(OrderImages::class);

    }
}
