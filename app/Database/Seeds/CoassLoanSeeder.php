<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CoassLoanSeeder extends Seeder
{
    public function run()
    {
        $recordmedical = new \App\Models\RecordMedicalModel();
        $transaction = new \App\Models\TransactionModel();
        $coass = new \App\Models\CoassModel();

        for ($i = 0; $i < 10; $i++) {
            $faker = \Faker\Factory::create('id_ID');
            $rm = $recordmedical->select('rm_id')->orderBy('rm_id', 'RANDOM')->limit(1)->first();
            $datatransaction = [
                'rm_id' => $rm['rm_id'],
                // 'loan_date' => $faker->date('Y-m-d', 'now'),
                'loan_date' => $faker->dateTimeBetween('2024'),
                'loan_type' => $faker->numberBetween(1, 2),
                'loan_desc' => $faker->text(130),
            ];

            $transaction->insert($datatransaction);
            $datacoass = [
                'clinic_name' => $faker->company,
                'coass_number' => $faker->ean8,
                'coass_date' => $faker->date('Y-m-d', 'now'),
                'coass_phone' => $faker->phoneNumber,
                'transaction_id' => $transaction->getInsertID(),
                'coass_name' => $faker->name,
                'rm_id' => $rm['rm_id'],
            ];

            $coass->insert($datacoass);
        }
    }
}
