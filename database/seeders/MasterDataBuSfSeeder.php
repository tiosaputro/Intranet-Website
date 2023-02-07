<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MasterDataBuSfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedBU();
        $this->seedSharedFunction();
    }
    public function seedBU()
    {
        DB::table('business_units')->insert(
            array(
            [
                'id' => generate_id(),
                'name' => 'Energi Mega Persada',
                'keterangan' => '-',
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id' => generate_id(),
                'name' => 'BUZI Hydrocarbon',
                'keterangan' => '-',
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id' => generate_id(),
                'name' => 'EMP - Bentu Korinci Baru',
                'keterangan' => '-',
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id' => generate_id(),
                'name' => 'EMP - Malacca Strait',
                'keterangan' => '-',
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id' => generate_id(),
                'name' => 'EMP - Tonga',
                'keterangan' => '-',
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id' => generate_id(),
                'name' => 'EMP - Visi Multi Artha',
                'keterangan' => '-',
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id' => generate_id(),
                'name' => 'EMP - Artha Widya Persada',
                'keterangan' => '-',
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1
            ]
            )
        );
    }

    //create seeder for shared function
    public function seedSharedFunction()
    {
        DB::table('shared_functions')->insert(
            array(
            [
                'id' => generate_id(),
                'name' => 'All Public',
                'keterangan' => '-',
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id' => generate_id(),
                'name' => 'Bentu',
                'keterangan' => '-',
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id' => generate_id(),
                'name' => 'Commercial',
                'keterangan' => '-',
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id' => generate_id(),
                'name' => 'DWO',
                'keterangan' => '-',
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id' => generate_id(),
                'name' => 'Economic Planning',
                'keterangan' => '-',
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1
            ],
            )
        );
    }

}
