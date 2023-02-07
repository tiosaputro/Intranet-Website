<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MasterDataDepartementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedDepartement();
        // $this->seedFunction();
    }

    public function seedDepartement()
    {
        DB::table('departements')->insert(
            array(
            [
                'id' => generate_id(),
                'name' => 'ICT',
                'descriptions' => '-',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id' => generate_id(),
                'name' => 'LEGAL',
                'descriptions' => '-',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id' => generate_id(),
                'name' => 'PROCUREMENT SR. SPECIALIST, BUZI',
                'descriptions' => '-',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id' => generate_id(),
                'name' => 'TECHNICAL PLANNING',
                'descriptions' => '-',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id' => generate_id(),
                'name' => 'DCRM',
                'descriptions' => '-',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id' => generate_id(),
                'name' => 'IR',
                'descriptions' => '-',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id' => generate_id(),
                'name' => 'ENGINEERING',
                'descriptions' => '-',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id' => generate_id(),
                'name' => 'GEOSCIENCE',
                'descriptions' => '-',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id' => generate_id(),
                'name' => 'GEOPHYSICIST',
                'descriptions' => '-',
                'created_by' => 1,
                'updated_by' => 1
            ]
            )
        );
    }
}
