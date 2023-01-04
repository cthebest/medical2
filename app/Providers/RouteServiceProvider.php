<?php

namespace App\Providers;

use App\Models\MenuItem;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/admin';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));


            Route::middleware('web')
                ->group(base_path('routes/guest.php'));

            Route::middleware('web')
                ->group(base_path('routes/admin.php'));


            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            $this->routing();
        });
    }

    private function routing()
    {

        Route::middleware('web')->get('{url}', function () {
            $requestUri = request()->getUri();
            $parseUrl = parse_url($requestUri);
            $parameter = '';
            $explodePath = explode('/', $parseUrl['path']);
            $hasPathMoreTokens = false;
            $countPath = count($explodePath);
            if ($countPath > 2) {
                $requestUri = $parseUrl['scheme'] . '://' . $parseUrl['host'] . '/' . $explodePath['1'];
                $hasPathMoreTokens = true;
            }

            $menuItem = MenuItem::wherePath($requestUri)->first();


            if ($menuItem) {
                $query = $this->getMenuItemParameters($menuItem);
                $module = $query['module'];

                if ($hasPathMoreTokens) {
                    $query['resource'] = $this->getResourceForNonMenuItem($module, $explodePath[2])->id;
                }

                if (count($query) > 1) {
                    $module .= '.id';
                    $parameter = $query['resource'];
                }

                // Obtenemos todas las rutas de nuestro
                $routes = Route::getRoutes();
                // Obtenemos la objeto de la ruta que necesitamos
                $route = $routes->getByName($module);
                $route->bind(request());
                // Le asignamos los parámetros
                $route->setParameter('id', $parameter);
                return $route->run();
            }
        })->where('url', '[A-Za-z0-9_\-\/]+');
    }

    private function getMenuItemParameters(MenuItem $menuItem)
    {
        // Creamos un request para obtener el componente
        $url = parse_url($menuItem->link, PHP_URL_QUERY);
        $query = [];
        $parameter = null;
        parse_str($url, $query);

        return $query;
    }

    private function getResourceForNonMenuItem($module, $resource)
    {
        $model =  DB::table($module)->where('alias', $resource)->first();
        if (!$model) abort(404);
        return $model;
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
