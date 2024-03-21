<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RecordMedicalSeeder extends Seeder
{
    public function run()
    {
        $recordmedical = new \App\Models\RecordMedicalModel();
        for ($i = 0; $i < 10000; $i++) {
            $faker = \Faker\Factory::create('id_ID');
            $data = [
                'rm_id' => $faker->uuid,
                'fullname' => $faker->name,
                'address' => $faker->address,
                'gender' => $faker->numberBetween(0, 1),
                // 'gender' => 1,
                'birth_date' => $faker->date('Y-m-d', 'now'),
                'service_unit' => $faker->numberBetween(1, 6),

            ];
            $recordmedical->insert($data);
        }
    }
}
