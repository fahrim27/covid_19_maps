<?php

use App\JenisKasus;
use Illuminate\Database\Seeder;

class JenisKasusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jk = ['Positif', 'ODP', 'PDP', 'Meninggal', 'Sembuh'];

        for($i = 0 ; $i< count($jk) ; $i++)
        {
            JenisKasus::create([
                'nama' => $jk[$i]
            ]);
        }
    }
}
