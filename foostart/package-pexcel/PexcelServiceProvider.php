<?php namespace Foostart\Pexcel;

use Foostart\Category\FooServiceProvider;
use LaravelAcl\Authentication\Classes\Menu\SentryMenuFactory;
use URL,
    Route;
use Illuminate\Http\Request;

class PexcelServiceProvider extends FooServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Request $request) {

        //generate context key
//        $this->generateContextKey();

        // load view
        $this->loadViewsFrom(__DIR__ . '/Views', 'package-pexcel');

        // include view composers
        require __DIR__ . "/composers.php";

        // publish config
        $this->publishConfig(__DIR__);

        // publish lang
        $this->publishLang(__DIR__);

        // publish views
//        $this->publishViews(__DIR__);

        // publish assets
//        $this->publishAssets(__DIR__);

        // public migrations
        $this->publishMigrations(__DIR__);

        // public seeders
        $this->publishSeeders(__DIR__);
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
     * @source: vendor/foostart/package-pexcel/config
     * @destination: config/
     */
    protected function publishConfig(string $dir = '') {
        $this->publishes([
            $dir . '/config/package-pexcel.php' => config_path('package-pexcel.php'),
                ], 'config');
    }

    /**
     * Public view to system
     * @source: vendor/foostart/package-pexcel/Views
     * @destination: resources/views/vendor/package-pexcel
     */
    protected function publishViews(string $dir = '') {

        $this->publishes([
            $dir . '/Views' => base_path('resources/views/vendor/package-pexcel'),
        ]);
    }
}
