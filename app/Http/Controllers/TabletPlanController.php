<?php

namespace App\Http\Controllers;

use App\Models\CarpetCode;
use App\Models\CarpetModel;
use App\Models\TabletSpace;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TabletPlanController extends Controller
{
    public function index(Request $request)
    {
        $product = $request->get('product');

        if ($product) {
            session(['tablet_product' => $product]);
        }

        $product = session('tablet_product');

        $title = match ($product) {
            'carpet' => 'پلان اجرای موکت',
            'grass' => 'پلان اجرای چمن مصنوعی',
            'tile' => 'پلان اجرای موکت تایل',
            'laminate' => 'پلان اجرای لمینت',
            'wallpaper' => 'پلان اجرای کاغذ دیواری',
            default => 'پلان پروژه',
        };

        if (!session()->has('project_token')) {
            session(['project_token' => Str::uuid()->toString()]);
        }

        $projectToken = session('project_token');

        $spaces = TabletSpace::with(['carpetModel', 'carpetCode'])
            ->where('project_token', $projectToken)
            ->get();

        $carpetModels = CarpetModel::with('codes')->get();

        return view('tablet.plan', compact('spaces', 'title', 'carpetModels'));
    }

    public function create(Request $request)
    {
        $space = trim((string) $request->query('space', ''));
        $modelId = $request->query('model');
        $codeId = $request->query('code');

        $carpetModel = $modelId !== null && $modelId !== ''
            ? CarpetModel::with('codes')->find($modelId)
            : null;

        $carpetCode = $codeId !== null && $codeId !== ''
            ? CarpetCode::find($codeId)
            : null;

        return view('tablet.space_create_agent', [
            'space' => $space,
            'model' => $modelId,
            'code' => $codeId,
            'carpetModel' => $carpetModel,
            'carpetCode' => $carpetCode,
        ]);
    }

    public function storeSpace(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
        ]);

        $space = new TabletSpace();
        $space->project_token = session('project_token');
        $space->name = $validated['name'];
        $space->drawing = $request->input('drawing');
        $space->area = $request->input('area');
        $space->roll = $request->input('roll');
        $space->roll_count = $request->input('roll_count');
        $space->carpet_model_id = $request->input('carpet_model_id');
        $space->carpet_code_id = $request->input('carpet_code_id');
        $space->save();

        return redirect()->route('tablet.plan', [
            'product' => session('tablet_product'),
        ]);
    }

    public function destroy($id)
    {
        $space = TabletSpace::findOrFail($id);
        $space->delete();

        return redirect()->route('tablet.plan', [
            'product' => session('tablet_product'),
        ]);
    }
}
