<?php

namespace App\Http\Controllers;

use App\Models\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComponentController extends Controller
{
    public function index()
    {
        $components = Component::select(['id', 'label'])->get();

        return response()->json($components, 200, [], JSON_NUMERIC_CHECK);
    }

    public function showResources(Request $request)
    {
        // Validamos que el módulo dado sea un string válido
        $validate = $this->validate($request, [
            'module_id' => 'nullable|integer'
        ]);
        if (!$request->module_id) return response()->json([]);

        // Buscamos el componente asociado con dicho id
        $component = Component::findOrFail($validate['module_id']);
        if (!$component->params->table) return response()->json([]);
        $resources = DB::table($component->params->table)->select(['id', 'title'])->get();
        return response()->json($resources);
    }
}
