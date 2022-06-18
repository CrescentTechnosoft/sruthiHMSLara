<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RegistrationSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Registration::factory(50)->create();
    }
}
