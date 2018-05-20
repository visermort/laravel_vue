<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use bheller\ImagesGenerator\ImagesGeneratorProvider;
use App\Order;

class OrderImages extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $faker->addProvider(new ImagesGeneratorProvider($faker));
        $orders = Order::all();
        $path = 'public/data-images';

        $dir = base_path().'/'.$path;

        if (file_exists($dir) !== true) {
            mkdir($dir, 0777, true);
        }
        foreach ($orders as $order) {
            $image = $faker->imageGenerator($path, $faker->numberBetween(600, 800), $faker->numberBetween(400, 600), 'jpg', true, $faker->word, $faker->hexColor, $faker->hexColor);
            $imagePath = substr($image, strlen($path) + 1 );

            $order->image = $imagePath;
            $order->save();
        }
    }
}
