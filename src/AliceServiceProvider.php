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

use Fidry\AliceDataFixtures\Loader\SimpleLoader;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Kilip\Laravel\Alice\Loader\DoctrineORMLoader;
use Kilip\Laravel\Alice\Loader\EloquentLoader;
use Kilip\Laravel\Alice\Util\FileLocator;
use Nelmio\Alice\Loader\NativeLoader;
use Psr\Log\LoggerInterface;

class AliceServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function boot()
    {
        $app = $this->app;

        $this->publishes([
            __DIR__.'/../config/alice.php' => config_path('alice.php'),
        ]);
        $app->singleton(FileLocator::class, FileLocator::class);

        $app->singleton(SimpleLoader::class, function (Application $app) {
            $native = new NativeLoader();
            $logger = $app->get(LoggerInterface::class);

            return new SimpleLoader($native->getFilesLoader(), $logger);
        });

        $app->singleton(DoctrineORMLoader::class, DoctrineORMLoader::class);
        $app->alias(DoctrineORMLoader::class, 'alice.loaders.doctrine_orm');

        $app->singleton(EloquentLoader::class, EloquentLoader::class);
        $app->alias(EloquentLoader::class, 'alice.loaders.eloquent');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/alice.php', 'alice'
        );
    }

    public function provides()
    {
        return [
            FileLocator::class,
            SimpleLoader::class,
            DoctrineORMLoader::class,
            EloquentLoader::class,
        ];
    }
}
