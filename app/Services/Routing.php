<?php

namespace App\Services;

use App\Models\Component;
use App\Models\MenuItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class Routing
{


    public function run()
    {
        $path = $this->getPath();
        $path_segments = $this->getPathSegments($path);
        $parent_dir = $path_segments['parent_dir'];

        $menu = $this->getMenuItem([$path, $parent_dir]);

        abort_if(!$menu, 404, 'Menu item not found');

        $module = $this->getModule($menu->association->module->id);
        $parameter = null;

        $route = $module->params->route->resource;

        if ($menu->association->resource && !$parent_dir) {
            $parameter = $menu->association->resource->id;
        } else if (!$menu->association->resource && !$parent_dir) {
            $route = $module->params->route->index;
        } else {
            $parameter = $this->getResource($module, $path_segments['last_path_segment'])?->id;
            abort_if(!$parameter, 404, 'Resource not found');
        }

        $routes = Route::getRoutes();
        $route = $routes->getByName($route);
        $route->bind(request());

        // Le asignamos los parámetros
        $route->setParameter('id', $parameter);
        return $route->run();
    }

    private function getPath()
    {
        return request()->path();
    }

    private function getPathSegments($path)
    {
        $path_segments = explode('/', $path);
        $last_path_segment = array_pop($path_segments);
        $parent_dir = implode('/', $path_segments);

        return [
            'last_path_segment' => $last_path_segment,
            'parent_dir' => $parent_dir,
        ];
    }

    private function getMenuItem($paths): MenuItem|null
    {
        return MenuItem::whereIn('path', $paths)->first();
    }


    private function getModule($module_id)
    {
        return Component::findOrFail($module_id);
    }

    private function getResource(Component $module, $last_segment)
    {
        $conditions = $module->params->search_model_by;
        return DB::table($module->params->table)->where(function ($query) use ($conditions, $last_segment) {
            foreach ($conditions as $key => $condition) {
                $query->orWhere($condition, $last_segment);
            }
        })->first();
    }
}
