<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CarpetModel;
use App\Models\CarpetCode;

class CarpetModelSeeder extends Seeder
{
    public function run(): void
    {
        $models = [

            'زیبا' => [],

            'زیبا اسپرت' => [],

            'کات' => [
                '9111',
                '5111',
                '9711',
                '5412',
            ],

            'بی افرا' => [],

            'نیکاس' => [],

            'پامچال' => [],

            'یاسمن' => [],

            'یاس' => [],

            'الماس' => [],

            'باران' => [],

            'آسا' => [],

            'پونه' => [],

            'نعنا' => [],

            'شبنم' => [],

            'نیلوفر' => [],

            'پتینه' => [],

            'راش' => [],

            'ونوس پلاس' => [],

            'هلیا' => [],

        ];

        foreach ($models as $name => $codes) {

            $model = CarpetModel::updateOrCreate(
                [
                    'model_name' => $name,
                ],
                [
                    'status' => true,
                ]
            );

            foreach ($codes as $code) {

                CarpetCode::updateOrCreate(
                    [
                        'code' => $code,
                    ],
                    [
                        'carpet_model_id' => $model->id,
                    ]
                );

            }
        }
    }
}