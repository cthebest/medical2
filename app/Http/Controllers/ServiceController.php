<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::paginate(10);
        return Inertia('Service/Index', compact('services'));
    }


    public function create()
    {
        return Inertia('Service/Create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('create_services')) {
            abort(403);
        }

        $path = null;

        if ($request->has('file') && $request->file('file')) {
            $path = Storage::putFileAs(
                'public/service/images',
                $request->file('file'),
                $request->file('file')->hashName()
            );
        }

        $attributes = $request->merge([
            'image' => $path,
            'alias' => Str::slug($request->title),
            'association' => $this->getAttributes($request)
        ]);

        $service = (new Service())->fill($attributes->except('file'));
        $service->save();
        $request->session()->flash('message', 'Servicio creado con éxito');
        return redirect()->route('services.edit', $service);
    }


    private function getAttributes($request)
    {

        return json_encode([
            'module' => ['id' => 1, 'label' => 'Artículos'],
            'resource' => $request->resource
        ]);
    }


    public function edit(Service $service)
    {
        $serviceCollection = new Collection();
        $serviceCollection->put('id', $service->id);
        $serviceCollection->put('title', $service->title);
        $serviceCollection->put('description', $service->description);
        $serviceCollection->put('image', $service->image);
        $serviceCollection->put('image_uri', $service->image_uri);
        $serviceCollection->put('resource', $service->association->resource);
        $service = $serviceCollection;

        return Inertia('Service/Edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        if (!auth()->user()->can('update_services')) {
            abort(403);
        }

        $path = null;

        if ($request->has('file') && $request->file('file')) {
            $path = Storage::putFileAs(
                'public/service/images',
                $request->file('file'),
                $request->file('file')->hashName()
            );
        }


        $attributes = $request->merge([
            'image' => $path ?? $service->image,
            'alias' => Str::slug($request->title),
            'association' => $this->getAttributes($request)
        ]);

        $service->update($attributes->except('file'));

        $request->session()->flash('message', 'Servicio actualizado con éxito');
        return redirect()->route('services.edit', $service->id);
    }

    /**
     * Método que permite eliminar un solo artículo
     */
    public function destroy(Service $service)
    {
        if (!auth()->user()->can('delete_services')) {
            abort(403);
        }

        $service->delete();
        session()->flash('message', 'Artículo eliminado con éxito');
        return redirect()->route('services.index');
    }
}
