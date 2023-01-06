<?php

namespace App\Http\Controllers;

use App\Models\Component;
use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $attributes = $this->getAttributes($request);
        MenuItem::create($attributes);
        session()->flash('message', 'Ítem de menú creado con éxito');
    }

    public function edit(MenuItem $menuItem)
    {
        $menuItemCollection = new Collection();
        $menuItemCollection->put('id', $menuItem->id);
        $menuItemCollection->put('title', $menuItem->title);
        $menuItemCollection->put('module', $menuItem->association->module);
        $menuItemCollection->put('resource', $menuItem->association->resource);
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
    /**
     * Retrieve and format the attributes needed to create a new menu item.
     * 
     * @param {Request} $request - The HTTP request object.
     * @returns {array} An array of menu item attributes.
     */
    private function getAttributes(Request $request)
    {
        $particles = [];

        // If a resource is specified, retrieve it and add its alias to the particles array
        if ($request->module) {
            $particles[] = Str::slug($request->title);
        }

        // Concatenate the particles into a path string
        $path = implode('/', $particles);

        // Return an array of menu item attributes, including the title, icon, path, and association
        return array_merge(
            $request->only('title', 'icon'),
            [
                'path' => $path, 'association' => json_encode([
                    'module' => $request->module,
                    'resource' => $request->resource
                ])
            ]
        );
    }


    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();
        session()->flash('message', 'Ítem de menú eliminado con éxito');
        return redirect()->route('menu-items.index');
    }
}
