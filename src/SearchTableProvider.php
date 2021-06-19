<?php


namespace Makuen\Searchtable;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Makuen\Searchtable\Commands\SearchTable;

/**
 * Class SearchTableProvider
 * @package Makuen\Searchtable
 * @property App $app
 */
class SearchTableProvider extends ServiceProvider
{
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                SearchTable::class
            ]);
        }
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . "/route.php");
        $this->loadViewsFrom(__DIR__ . "/views", "Searchtable");
    }
}
