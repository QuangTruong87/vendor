<?php

namespace Foostart\English;

use Illuminate\Support\ServiceProvider;
use LaravelAcl\Authentication\Classes\Menu\SentryMenuFactory;
use URL,
    Route;
use Illuminate\Http\Request;

class EnglishServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {

        //generate context key
//        $this->generateContextKey();

        // load view
        $this->loadViewsFrom(__DIR__ . '/Views', 'package-english');

        // include view composers
        require __DIR__ . "/composers.php";

        // publish config
        $this->publishConfig();

        // publish lang
        $this->publishLang();

        // publish views
        //$this->publishViews();

        // publish assets
        $this->publishAssets();

        // public migrations
        $this->publishMigrations();

        // public seeders
        $this->publishSeeders();

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__ . '/routes.php';
    }

    /**
     * Public config to system
     * @source: vendor/foostart/package-english/config
     * @destination: config/
     */
    protected function publishConfig()
    {
        $this->publishes([
            __DIR__ . '/config/package-english.php' => config_path('package-english.php'),
        ], 'config');
    }

    /**
     * Public language to system
     * @source: vendor/foostart/package-english/lang
     * @destination: resources/lang
     */
    protected function publishLang()
    {
        $this->publishes([
            __DIR__ . '/lang' => base_path('resources/lang'),
        ]);
    }

    /**
     * Public view to system
     * @source: vendor/foostart/package-english/Views
     * @destination: resources/views/vendor/package-english
     */
    protected function publishViews()
    {

        $this->publishes([
            __DIR__ . '/Views' => base_path('resources/views/vendor/package-english'),
        ]);
    }

    protected function publishAssets()
    {
        $this->publishes([
            __DIR__ . '/public' => public_path('packages/foostart/package-english'),
        ]);
    }

    /**
     * Publish migrations
     * @source: foostart/package-english/database/migrations
     * @destination: database/migrations
     */
    protected function publishMigrations()
    {
        $this->publishes([
            __DIR__ . '/database/migrations' => $this->app->databasePath() . '/migrations',
        ]);
    }

    /**
     * Publish seeders
     * @source: foostart/package-english/database/seeders
     * @destination: database/seeders
     */
    protected function publishSeeders()
    {
        $this->publishes([
            __DIR__ . '/database/seeders' => $this->app->databasePath() . '/seeders',
        ]);
    }

}
