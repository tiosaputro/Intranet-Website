<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MasterDataDirectorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedDirectory();
        // $this->seedFunction();
    }

    public function seedDirectory()
    {
        DB::table('directories')->insert(
            array(
            [
                'id' => generate_id(),
                'category' => 'emergency',
                'name' => 'GM / Eppy G',
                'departement' => '',
                'lantai' => '',
                'ext' => '',
                'phone' => '8111334878',
                'position' => 'Coordinate Emergency',
                'photo_path' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1
            ],
            [
                'id' => generate_id(),
                'category' => 'emergency',
                'name' => 'Abdul Aziz Tarmuzi',
                'departement' => '',
                'lantai' => '',
                'ext' => '',
                'phone' => '81318377797',
                'position' => 'Coordinate Emergency',
                'photo_path' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1
            ],
            [
                'id' => generate_id(),
                'category' => 'emergency',
                'name' => 'Andri Kurniawan',
                'departement' => '',
                'lantai' => '',
                'ext' => '',
                'phone' => '8128211864',
                'position' => 'Coordinate Emergency',
                'photo_path' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1
            ],
            [
                'id' => generate_id(),
                'category' => 'emergency',
                'name' => 'GM / Agung Budi D',
                'departement' => '',
                'lantai' => '',
                'ext' => '',
                'phone' => '8161666456',
                'position' => 'Coordinate Emergency',
                'photo_path' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1
            ],
            [
                'id' => generate_id(),
                'category' => 'emergency',
                'name' => 'Suderajat',
                'departement' => '',
                'lantai' => '',
                'ext' => '',
                'phone' => '81324280485',
                'position' => 'Coordinate Emergency',
                'photo_path' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1
            ],
            [
                'id' => generate_id(),
                'category' => 'emergency',
                'name' => 'GM /Budi Susanto',
                'departement' => '',
                'lantai' => '',
                'ext' => '',
                'phone' => '811820779',
                'position' => 'Coordinate Emergency',
                'photo_path' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1
            ],
            [
                'id' => generate_id(),
                'category' => 'emergency',
                'name' => 'Radig Wisnu',
                'departement' => '',
                'lantai' => '',
                'ext' => '',
                'phone' => '81213580061',
                'position' => 'Coordinate Emergency',
                'photo_path' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1
            ],
            [
                'id' => generate_id(),
                'category' => 'emergency',
                'name' => 'Yusni Aditiah',
                'departement' => '',
                'lantai' => '',
                'ext' => '',
                'phone' => '8119932908',
                'position' => 'Coordinate Emergency',
                'photo_path' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1
            ],

            [
                'id' => generate_id(),
                'category' => 'emergency',
                'name' => 'Iman Soerjasantosa',
                'departement' => '',
                'lantai' => '',
                'ext' => '',
                'phone' => '816962804',
                'position' => 'Coordinate Emergency',
                'photo_path' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1
            ],
            [
                'id' => generate_id(),
                'category' => 'extension',
                'name' => 'Dhimas Arief Rahmawan CP',
                'departement' => 'GEOPHYSICIST',
                'lantai' => '30',
                'ext' => '7210',
                'phone' => '-',
                'position' => '',
                'photo_path' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1
            ],
            [
                'id' => generate_id(),
                'category' => 'extension',
                'name' => 'Hendarman',
                'departement' => 'GEOSCIENCE',
                'lantai' => '31',
                'ext' => '7279',
                'phone' => '-',
                'position' => '',
                'photo_path' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1
            ],
            [
                'id' => generate_id(),
                'category' => 'extension',
                'name' => 'Jati Priyantoro',
                'departement' => 'ENGINEERING',
                'lantai' => '31',
                'ext' => '7289',
                'phone' => '-',
                'position' => '',
                'photo_path' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1
            ],
            [
                'id' => generate_id(),
                'category' => 'extension',
                'name' => 'Priyo Pratomo',
                'departement' => 'ENGINEERING',
                'lantai' => '27',
                'ext' => '7302',
                'phone' => '-',
                'position' => '',
                'photo_path' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1
            ],
            [
                'id' => generate_id(),
                'category' => 'extension',
                'name' => 'Gunawan',
                'departement' => 'ENGINEERING',
                'lantai' => '27',
                'ext' => '7435',
                'phone' => '-',
                'position' => '',
                'photo_path' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1
            ],
            [
                'id' => generate_id(),
                'category' => 'extension',
                'name' => 'Porman Hutajulu',
                'departement' => 'TECHNICAL PLANNING',
                'lantai' => '27',
                'ext' => '7281',
                'phone' => '-',
                'position' => '',
                'photo_path' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1
            ],
            [
                'id' => generate_id(),
                'category' => 'extension',
                'name' => 'Sumarso',
                'departement' => 'ICT',
                'lantai' => '27',
                'ext' => '7535',
                'phone' => '-',
                'position' => '',
                'photo_path' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1
            ],
            [
                'id' => generate_id(),
                'category' => 'extension',
                'name' => 'Iman Soerjasantosa',
                'departement' => 'PROCUREMENT SR. SPECIALIST, BUZI',
                'lantai' => '27',
                'ext' => '7277',
                'phone' => '-',
                'position' => '',
                'photo_path' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1
            ],
            [
                'id' => generate_id(),
                'category' => 'extension',
                'name' => 'Abdul Rosyid',
                'departement' => 'ICT',
                'lantai' => '27',
                'ext' => '7212',
                'phone' => '-',
                'position' => '',
                'photo_path' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1
            ],
            [
                'id' => generate_id(),
                'category' => 'extension',
                'name' => 'Apen Nainggolan',
                'departement' => 'ICT',
                'lantai' => '27',
                'ext' => '7458',
                'phone' => '-',
                'position' => '',
                'photo_path' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1
            ],
            [
                'id' => generate_id(),
                'category' => 'extension',
                'name' => 'Bayu Indrawan',
                'departement' => 'ICT',
                'lantai' => '27',
                'ext' => '7214',
                'phone' => '-',
                'position' => '',
                'photo_path' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1
            ],
            [
                'id' => generate_id(),
                'category' => 'extension',
                'name' => 'Dinda Widy',
                'departement' => 'DCRM',
                'lantai' => '27',
                'ext' => '7320',
                'phone' => '-',
                'position' => '',
                'photo_path' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1
            ],
            [
                'id' => generate_id(),
                'category' => 'extension',
                'name' => 'M. Yunus Nasution',
                'departement' => 'IR',
                'lantai' => '27',
                'ext' => '7484',
                'phone' => '-',
                'position' => '',
                'photo_path' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1
            ]

            )
        );
    }
}
