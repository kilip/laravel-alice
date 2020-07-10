<?php

/*
 * This file is part of the Kilip Laravel Alice project.
 *
 * (c) Anthonius Munthi <https://itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Kilip\Laravel\Alice;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Kilip\Laravel\Alice\Loader\DoctrineORMLoader;
use Kilip\Laravel\Alice\Loader\LoaderInterface;
use Kilip\Laravel\Alice\Util\FileLocator;
use Kilip\Laravel\Alice\Util\FileLocatorInterface;

class AliceServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/alice.php' => config_path('alice.php'),
        ]);
        $app = $this->app;

        $app->bind(FileLocatorInterface::class, function (Application $app) {
            $paths = config('alice.paths', []);

            return new FileLocator($paths);
        });
        $app->alias(FileLocatorInterface::class, 'alice.locator');

        $app->bind(DoctrineORMLoader::class, function (Application $app) {
            $locatorName = config('alice.locator', 'alice.locator');
            $registry = $app->get('registry');
            $locator = $app->get($locatorName);

            return new DoctrineORMLoader($registry, $locator);
        });
        $app->alias(DoctrineORMLoader::class, 'alice.loader.doctrine');

        $app->bind(LoaderInterface::class, function (Application $app) {
            $loaderName = config('alice.loader', 'alice.loader.doctrine');

            return $app->get($loaderName);
        });
        $app->alias(LoaderInterface::class, 'alice.loader');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/alice.php', 'alice');
    }
}
