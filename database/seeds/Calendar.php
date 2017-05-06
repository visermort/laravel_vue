<?php

use Illuminate\Database\Seeder;
use App\Boat;
use App\Calendar as Event;
use App\UserToCalendar;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\User;
use Carbon\Carbon;

class Calendar extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            DB::table('boats')->delete();
            DB::table('calendar')->delete();
            DB::table('users')->delete();
            DB::table('user_to_calendar')->delete();
            $faker = Faker::create();
            
            for ($i=0; $i<5; $i++) {
                Boat::create([
                    'boat_name' => $faker->word,
                ]);
            }

            $boats = Boat::all();
            for ($i=0; $i<100; $i++) {
                $date = $faker->dateTimeBetween('now', '+10 day');
                $dateStart = Carbon::createFromFormat('Y-m-d H:i:s', $date->format('Y-m-d H:i:s'))
                    ->startOfDay()->addHour(mt_rand(8, 20))->addMinute(mt_rand(0, 3) * 15);


                Event::create([
                    'name' => 'Wake seans',
                    'boat_id' => $boats->random()->id,
                    'description' => $faker->text,
                    'status' => 1,
                    'length' => 1,
                    'event_date' => $dateStart,
                ]);
            }
            for ($i=0; $i<50; $i++) {
                User::create([
                    'user_name' => strtolower($faker->firstName),
                    'user_email' => $faker->email,
                    'user_address' => $faker->address,
                    'user_phone' => $faker->e164PhoneNumber,
                    'password' => md5($faker->password),
                ]);
            }
            
            $events = Event::all();
            foreach ($events as $event) {
                $users = User::all()->random(mt_rand(1, 10));
                foreach ($users as $user) {
                    UserToCalendar::create([
                        'user_id' => $user->id,
                        'calendar_id' => $event->id,
                    ]);
                }
            }



        });
    }
}
