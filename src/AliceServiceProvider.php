<?php


namespace Kilip\Laravel\Alice;


use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Kilip\Laravel\Alice\Loader\DoctrineORMLoader;
use Kilip\Laravel\Alice\Util\FileLocator;

class AliceServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $app = $this->app;

        $app->bind(DoctrineORMLoader::class,function(Application $app){
            $registry = $app->get('registry');
            $locator = new FileLocator(config('alice.paths',[]));
            return new DoctrineORMLoader($registry, $locator);
        });
        $app->alias(DoctrineORMLoader::class, 'alice.doctrine');
    }

    public function register()
    {

    }
}