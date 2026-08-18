<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TabletSpace;
use Illuminate\Support\Str;
use App\Models\CarpetModel;

class TabletPlanController extends Controller
{
    public function index(Request $request)
    {
        $product = $request->get('product');

        if ($product) {
            session([
                'tablet_product' => $product
            ]);
        }

        $product = session('tablet_product');

        $title = match ($product) {

            'carpet'     => 'پلان اجرای موکت',

            'grass'      => 'پلان اجرای چمن مصنوعی',

            'tile'       => 'پلان اجرای موکت تایل',

            'laminate'   => 'پلان اجرای لمینت',

            'wallpaper'  => 'پلان اجرای کاغذ دیواری',

            default      => 'پلان پروژه',

        };

        if (!session()->has('project_token')) {

            session([
                'project_token' => Str::uuid()->toString()
            ]);

        }

        $projectToken = session('project_token');

      $spaces = TabletSpace::with([
    'carpetModel',
    'carpetCode'
])
->where(
    'project_token',
    $projectToken
)
->get();

$carpetModels = CarpetModel::with('codes')->get();

return view('tablet.plan', compact(
    'spaces',
    'title',
    'carpetModels'
));
    }

public function create(Request $request)
{
    $space = $request->get('space');

    $model = $request->get('model');
    $code = $request->get('code');

    $carpetModel = CarpetModel::find($model);

    $carpetCode = null;

    if ($code) {
        $carpetCode = \App\Models\CarpetCode::find($code);
    }

    $html = view('tablet.space_create', compact(
        'space',
        'model',
        'code',
        'carpetModel',
        'carpetCode'
    ))->render();

    // اصلاح نهایی هندسه مربع/مستطیل در خروجی همین صفحه.
    $rectangleFix = <<<'JS'
// ==========================================
// DTZ RECTANGLE GEOMETRY FIX
// ==========================================

function createRectangleFromTwoLines(){

    if(lines.length < 2){
        return;
    }

    const line1 = lines[0];
    const line2 = lines[1];

    const lengthMeter = Number(line1.meter);
    const widthMeter = Number(line2.meter);

    if(!Number.isFinite(lengthMeter) || lengthMeter <= 0 ||
       !Number.isFinite(widthMeter) || widthMeter <= 0){
        return;
    }

    const A = { x: line1.x1, y: line1.y1 };
    const B = { x: line1.x2, y: line1.y2 };
    const P = { x: line2.x1, y: line2.y1 };
    const Q = { x: line2.x2, y: line2.y2 };

    // مشخص می‌کنیم ضلع دوم به کدام سر ضلع اول وصل شده است.
    const candidates = [
        { connected: A, far: Q, distance: distance(A, P) },
        { connected: A, far: P, distance: distance(A, Q) },
        { connected: B, far: Q, distance: distance(B, P) },
        { connected: B, far: P, distance: distance(B, Q) }
    ];

    candidates.sort(function(a, b){
        return a.distance - b.distance;
    });

    const connected = candidates[0].connected;
    const far = candidates[0].far;

    const dx = B.x - A.x;
    const dy = B.y - A.y;
    const firstPixelLength = Math.hypot(dx, dy);

    if(firstPixelLength <= 0){
        return;
    }

    // بردار واحد ضلع اول و بردار عمود دقیق آن.
    const ux = dx / firstPixelLength;
    const uy = dy / firstPixelLength;

    let perpX = -uy;
    let perpY = ux;

    // سمت مستطیل از جهت واقعی ضلع دوم گرفته می‌شود.
    const secondDx = far.x - connected.x;
    const secondDy = far.y - connected.y;

    if((secondDx * perpX + secondDy * perpY) < 0){
        perpX *= -1;
        perpY *= -1;
    }

    // طول تصویری ضلع دوم برای نمایش، ولی هندسه کاملاً عمود است.
    const secondPixelLength = Math.max(
        distance(P, Q),
        firstPixelLength * (widthMeter / Math.max(lengthMeter, 0.0001))
    );

    const offsetX = perpX * secondPixelLength;
    const offsetY = perpY * secondPixelLength;

    // چهار گوشه دقیقاً یک مستطیل می‌سازند.
    const C = {
        x: B.x + offsetX,
        y: B.y + offsetY
    };

    const D = {
        x: A.x + offsetX,
        y: A.y + offsetY
    };

    // مهم: ترتیب همیشه A -> B -> C -> D -> A است.
    // بنابراین دیگر ضلع روبه‌رو حذف یا با ضلع مجاور تکراری نمی‌شود.
    lines = [
        {
            x1: A.x,
            y1: A.y,
            x2: B.x,
            y2: B.y,
            meter: lengthMeter
        },
        {
            x1: B.x,
            y1: B.y,
            x2: C.x,
            y2: C.y,
            meter: widthMeter
        },
        {
            x1: C.x,
            y1: C.y,
            x2: D.x,
            y2: D.y,
            meter: lengthMeter
        },
        {
            x1: D.x,
            y1: D.y,
            x2: A.x,
            y2: A.y,
            meter: widthMeter
        }
    ];

    const lengthInput = document.getElementById('length');
    const widthInput = document.getElementById('width');

    if(lengthInput){
        lengthInput.value = lengthMeter;
    }

    if(widthInput){
        widthInput.value = widthMeter;
    }

    redrawCanvas();

    if(typeof calculateArea === 'function'){
        calculateArea();
    }
}
JS;

    // تابع قدیمی داخل Blade را با نسخه قطعی هندسی جایگزین می‌کنیم.
    $pattern = '/\/\/ ==========================================\s*\/\/ ساخت مستطیل از دو ضلع\s*\/\/ ==========================================\s*function createRectangleFromTwoLines\(\)\s*\{.*?\n\}\s*function redrawCanvas\(\)/s';

    $replacement = $rectangleFix . "\n\nfunction redrawCanvas()";

    $html = preg_replace($pattern, $replacement, $html, 1);

    return response($html);
}
public function storeSpace(Request $request)
{
    $request->validate([
        'name' => 'required'
    ]);


    $space = new TabletSpace();

    $space->project_token = session('project_token');
    $space->name = $request->name;
    $space->drawing = $request->drawing;
    $space->area = $request->area;
    $space->roll = $request->roll;
    $space->roll_count = $request->roll_count;
    $space->carpet_model_id = $request->carpet_model_id;

$space->carpet_code_id = $request->carpet_code_id;

    $space->save();

    return redirect()->route('tablet.plan', [
        'product' => session('tablet_product')
    ]);
}


public function destroy($id)
{
    $space = TabletSpace::findOrFail($id);

    $space->delete();

    return redirect()->route('tablet.plan', [
        'product' => session('tablet_product')
    ]);
}
}