<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Accomodation;

class AccomodationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Accomodation::create([
            'created_by_user_id' => 1,
            'bookig_status' => 0,
            'type' => 'Jungle',
            'qty' => 3,
            'capacity' => 5,
            'tour_type' => 'NA',
            'group_type' => 'NA',
            'amount' => 1500,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Accomodation::create([
            'created_by_user_id' => 1,
            'bookig_status' => 0,
            'type' => 'Aircon',
            'qty' => 5,
            'capacity' => 5,
            'tour_type' => 'NA',
            'group_type' => 'NA',
            'amount' => 800,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Accomodation::create([
            'created_by_user_id' => 1,
            'bookig_status' => 0,
            'type' => 'Jungle Room',
            'qty' => 4,
            'capacity' => 10,
            'tour_type' => 'NA',
            'group_type' => 'NA',
            'amount' => 500,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
