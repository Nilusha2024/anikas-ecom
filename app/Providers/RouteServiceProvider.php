<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapVueRoutes();

        $this->mapAdminRoutes();

        $this->mapSellerRoutes();

        $this->mapbinRoutes();

        $this->mapSububscriptionRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    protected function mapVueRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/vueroute.php'));
    }

    public function mapAdminRoutes(){
        
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/admin.php'));
    }

    public function mapSellerRoutes(){
        
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/seller.php'));
    }

    protected function mapSububscriptionRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/subscription.php'));
    }

    protected function mapbinRoutes(){
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/bin.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }


}
