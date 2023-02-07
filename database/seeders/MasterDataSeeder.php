<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedBu();
        $this->seedFunction();
    }

    public function seedBu()
    {
        DB::table('business_units')->insert(
            array(
            [
                'id' => generate_id(),
                'name' => 'BUZI Hydrocarbon',
                'keterangan' => '-',
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1
            ],
            [
                'id' => generate_id(),
                'name' => 'EMP - Bentu Korinci Baru',
                'keterangan' => '-',
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1
            ],
            [
                'id' => generate_id(),
                'name' => 'EMP - Malacca Strait',
                'keterangan' => '-',
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1
            ],
            [
                'id' => generate_id(),
                'name' => 'EMP - Tonga',
                'keterangan' => '-',
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1
            ]
            )
        );
    }

    public function seedFunction(){
        DB::table('shared_functions')->insert(
            array(
            [
                'id' => generate_id(),
                'name' => 'Bentu',
                'keterangan' => '-',
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1
            ],
            [
                'id' => generate_id(),
                'name' => 'Commercial',
                'keterangan' => '-',
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1
            ],
            [
                'id' => generate_id(),
                'name' => 'DWO',
                'keterangan' => '-',
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1
            ],
            [
                'id' => generate_id(),
                'name' => 'Economic Planning',
                'keterangan' => '-',
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1
            ],
            [
                'id' => generate_id(),
                'name' => 'Legal',
                'keterangan' => '-',
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1
            ],
            [
                'id' => generate_id(),
                'name' => 'Safety, Health & Environment',
                'keterangan' => '-',
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1
            ]
            )
        );
    }
}
