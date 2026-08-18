<?php

namespace App\Http\Controllers\Tablet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TabletController extends Controller
{
    public function index()
    {
        return view('tablet.page1');
    }


    // ==========================================
    // تحلیل تصویر پلان
    // ==========================================

    public function analyzeSpaceImage(Request $request)
    {
        try {

            // --------------------------------------
            // بررسی تصویر
            // --------------------------------------

            if (!$request->hasFile('plan_image')) {

                return response()->json([
                    'success' => false,
                    'message' => 'تصویر دریافت نشد.'
                ], 422);

            }


            $image = $request->file('plan_image');


            if (!$image->isValid()) {

                return response()->json([
                    'success' => false,
                    'message' => 'فایل تصویر معتبر نیست.'
                ], 422);

            }


            // --------------------------------------
            // API KEY
            // --------------------------------------

            $apiKey = env('OPENAI_API_KEY');


            if (!$apiKey) {

                return response()->json([
                    'success' => false,
                    'message' => 'OPENAI_API_KEY در فایل .env تنظیم نشده است.'
                ], 500);

            }


            // --------------------------------------
            // تبدیل تصویر به Base64
            // --------------------------------------

            $imageData = base64_encode(
                file_get_contents($image->getRealPath())
            );


            $mimeType = $image->getMimeType();


            // --------------------------------------
            // ارسال تصویر به OpenAI
            // --------------------------------------

            $response = Http::withToken($apiKey)
                ->timeout(120)
                ->post(
                    'https://api.openai.com/v1/responses',
                    [

                        'model' => 'gpt-5.6',

                        'input' => [

                            [

                                'role' => 'user',

                                'content' => [

                                    [

                                        'type' => 'input_text',

                                        'text' => <<<TEXT

این تصویر یک پلان یا نقشه فضای داخلی برای نصب موکت است.

تصویر را دقیق بررسی کن.

اگر روی تصویر عددی برای طول یا عرض نوشته شده است،
آن اعداد را پیدا کن.

اگر شکل فضا مستطیل یا مربع است،
طول و عرض را استخراج کن.

اگر چند فضا یا چند عدد وجود دارد،
فقط ابعاد مربوط به فضای اصلی را مشخص کن.

پاسخ را فقط به صورت JSON بده.

فرمت دقیق:

{
    "length": عدد یا null,
    "width": عدد یا null,
    "area": عدد یا null,
    "shape": "rectangle" یا "square" یا "irregular" یا null,
    "confidence": عدد بین 0 و 1
}

واحد تمام ابعاد متر است.

اگر از روی تصویر نمی‌توان با اطمینان اندازه را تشخیص داد،
مقدار آن را null قرار بده.

TEXT

                                    ],

                                    [

                                        'type' => 'input_image',

                                        'image_url' =>
                                            'data:' .
                                            $mimeType .
                                            ';base64,' .
                                            $imageData

                                    ]

                                ]

                            ]

                        ]

                    ]
                );


            // --------------------------------------
            // بررسی پاسخ OpenAI
            // --------------------------------------

            if (!$response->successful()) {

                return response()->json([

                    'success' => false,

                    'message' =>
                        'خطا از OpenAI: ' .
                        $response->body()

                ], 500);

            }


            $data = $response->json();


            // --------------------------------------
            // گرفتن متن خروجی
            // --------------------------------------

            $outputText = '';


            if (isset($data['output'])) {

                foreach ($data['output'] as $outputItem) {

                    if (
                        isset($outputItem['type']) &&
                        $outputItem['type'] === 'message'
                    ) {

                        if (isset($outputItem['content'])) {

                            foreach (
                                $outputItem['content']
                                as $content
                            ) {

                                if (
                                    isset($content['type']) &&
                                    $content['type'] === 'output_text'
                                ) {

                                    $outputText .=
                                        $content['text'] ?? '';

                                }

                            }

                        }

                    }

                }

            }


            // --------------------------------------
            // اگر خروجی خالی بود
            // --------------------------------------

            if (!$outputText) {

                return response()->json([

                    'success' => false,

                    'message' =>
                        'پاسخ قابل خواندن از AI دریافت نشد.',

                    'raw' => $data

                ], 500);

            }


            // --------------------------------------
            // پاک کردن Markdown JSON
            // --------------------------------------

            $outputText = trim($outputText);


            $outputText = preg_replace(
                '/^```json\s*/i',
                '',
                $outputText
            );


            $outputText = preg_replace(
                '/\s*```$/',
                '',
                $outputText
            );


            $outputText = trim($outputText);


            // --------------------------------------
            // تبدیل JSON
            // --------------------------------------

            $analysis = json_decode(
                $outputText,
                true
            );


            if (!is_array($analysis)) {

                return response()->json([

                    'success' => false,

                    'message' =>
                        'AI پاسخ JSON معتبر برنگرداند.',

                    'ai_response' =>
                        $outputText

                ], 500);

            }


            // --------------------------------------
            // استانداردسازی مقادیر
            // --------------------------------------

            $length =
                isset($analysis['length'])
                    ? (float) $analysis['length']
                    : null;


            $width =
                isset($analysis['width'])
                    ? (float) $analysis['width']
                    : null;


            $area =
                isset($analysis['area'])
                    ? (float) $analysis['area']
                    : null;


            // --------------------------------------
            // اگر AI مساحت نداد،
            // خودمان حساب کنیم
            // --------------------------------------

            if (
                $area === null &&
                $length !== null &&
                $width !== null
            ) {

                $area =
                    $length *
                    $width;

            }


            // --------------------------------------
            // پاسخ نهایی به JavaScript
            // --------------------------------------

            return response()->json([

                'success' => true,

                'message' =>
                    'تصویر با موفقیت تحلیل شد.',

                'analysis' => [

                    'length' =>
                        $length,

                    'width' =>
                        $width,

                    'area' =>
                        $area,

                    'shape' =>
                        $analysis['shape'] ?? null,

                    'confidence' =>
                        $analysis['confidence'] ?? null,

                ],

                'ai_response' =>
                    $outputText

            ]);


        } catch (\Throwable $e) {


            // --------------------------------------
            // خطای کلی
            // --------------------------------------

            return response()->json([

                'success' => false,

                'message' =>
                    'خطای Backend: ' .
                    $e->getMessage()

            ], 500);

        }

    }

}