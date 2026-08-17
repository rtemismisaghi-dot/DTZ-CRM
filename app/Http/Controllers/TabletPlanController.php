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

    return view('tablet.space_create', compact(
        'space',
        'model',
        'code',
        'carpetModel',
        'carpetCode'
    ));
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