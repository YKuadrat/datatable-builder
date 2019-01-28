<?php

namespace YKuadrat\DatatableBuilder;

use Illuminate\Support\ServiceProvider;

class DatatableBuilderProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadViews();
        $this->publishAssets();
        $this->publishConfig();
    }

    private function loadViews()
    {
        $viewsPath = $this->packagePath('resources' . DIRECTORY_SEPARATOR . 'views');
        $this->loadViewsFrom($viewsPath, 'datatable-builder');

        $this->publishes([
            $viewsPath => base_path('resources/views/vendor/datatable-builder'),
        ], 'views');
    }

    private function publishAssets()
    {
        $this->publishes([
            $this->packagePath('resources/assets') => public_path('vendor/datatable-builder'),
        ], 'assets');
    }

    private function publishConfig()
    {
        $configPath = $this->packagePath('config' . DIRECTORY_SEPARATOR . 'datatable-builder.php');

        $this->publishes([
            $configPath => config_path('datatable-builder.php'),
        ], 'config');

        $this->mergeConfigFrom($configPath, 'datatable-builder');
    }

    private function packagePath($path)
    {
        return __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $path;
    }
}
