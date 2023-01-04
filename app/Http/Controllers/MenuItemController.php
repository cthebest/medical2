<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Illuminate\Support\Str;

class MenuItemController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:Administrador|Editor']);
    }

    public function index()
    {
        $menuItems = MenuItem::paginate(10);
        return Inertia('MenuItem/Index', compact('menuItems'));
    }

    public function create()
    {
        return Inertia('MenuItem/Create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => [
                'required',
                Rule::unique('menu_items', 'title')
            ]
        ]);


        MenuItem::create($this->getAttributes($request));

        session()->flash('message', 'Ítem de menú creado con éxito');
    }

    public function edit(MenuItem $menuItem)
    {

        $menuItemCollection = new Collection();
        $url = parse_url($menuItem->link, PHP_URL_QUERY);
        parse_str($url, $query);

        $menuItemCollection->put('title', $menuItem->title);
        $menuItemCollection->put('id', $menuItem->id);
        $menuItemCollection->put('component_type', isset($query['module']) ? $query['module'] : '');
        $menuItemCollection->put('resource', isset($query['resource']) ? $query['resource'] : '');
        $menuItem = $menuItemCollection;

        return Inertia('MenuItem/Edit', compact('menuItem'));
    }

    public function update(MenuItem $menuItem, Request $request)
    {
        $request->validate([
            'title' => [
                'required',
                Rule::unique('menu_items', 'title')->ignore($menuItem)
            ]
        ]);

        $menuItem->update($this->getAttributes($request));
        session()->flash('message', 'Ítem de menú actualizado con éxito');

        return redirect()->route('menu-items.edit', $menuItem);
    }

    private function getAttributes(Request $request)
    {

        $attributes = [];
        if ($request->component_type) {
            $attributes['module'] = $request->component_type;
        }

        if ($request->resource) {
            $attributes['resource'] = $request->resurce;
        }
        // Lo que verá el usuario en la url de su navegador
        $path = url($request->component_type ? Str::slug($request->title) : '');
        // Lo que entenderá el sistema una vez se busque el item de menú
        $link = url('?' . http_build_query($attributes));

        return array_merge($request->only('title', 'icon'), ['path' => $path, 'link' => $link]);
    }

    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();
        session()->flash('message', 'Ítem de menú eliminado con éxito');
        return redirect()->route('menu-items.index');
    }
}
